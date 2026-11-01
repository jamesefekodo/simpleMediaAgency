<?php

namespace App\Http\Middleware;

use App\Models\BasicSystemSetting;
use App\Models\Config\SystemPolicy\SystemPolicy;
use App\Models\Config\SystemPolicy\UserAgreedPolicy;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // verify Mfa
        if (Auth::check()) {
            $user = Auth::user();
            // check permision start
            // update admin access permission
            $userRec = User::where('username', $user->username)->first();

            // check permnission end
            // auto update last seen start
            if (
                ! $userRec->last_seen_at
                || $userRec->last_seen_at->diffInSeconds(now()) > 60 // 1 minutes
            ) {
                $userRec->forceFill(['last_seen_at' => now()])->save();
            }
            // auto update last seen end
            $currentSessionId = Session::getId();
            $currentSession = DB::table('sessions')->where('id', $currentSessionId)->first();
            $userActiveSessions = DB::table('sessions')->where('user_id', $user->id)->count();
            if (!$currentSession) {
                $currentSession = (object) [
                    'id' => $currentSessionId,
                    'user_id' => $user->id,
                    'mfa_verified' => Session::get('mfa_verified', 0),
                    'login_otp' => Session::get('login_otp'),
                    'login_otp_expires_at' => Session::get('login_otp_expires_at'),
                ];
            }


            $basicDefaultSettings = BasicSystemSetting::first();

            // 0 - admin, 1-staff , 2- customer

            $accountType = (int) $user->account_type;
            $accountStatus = $user->account_status;
            $maintenanceModeLock = $basicDefaultSettings->maintenance_mode === true && (int) $accountType !== 0;


            $maintenanceStatus = 'waiting';
            $emailVerificationStatus = 'waiting';
            $mfaVerificationStatus = 'waiting';
            $policyGuard = 'waiting';
            $sessionLimitStatus = in_array((int) $accountType, [0, 1], true) ? 'waiting' : 'cleared';
            $inactiveAccount = 'waiting';




            // Maintenance mode
            if ($maintenanceModeLock === true) {
                if (
                    !Route::is('maintenanceMode') &&
                    !Route::is('logoutRequest')
                ) {
                    return redirect()->route('maintenanceMode');
                }
            } else {
                $maintenanceStatus = 'cleared';
            }

            // // Account Email Verification
            if ($maintenanceStatus === 'cleared') {
                if ($user->email_verification !== true) {
                    if (
                        !Route::is('verifyUserEmail')
                        && !Route::is('logoutRequest')
                        && !Route::is('verifyUserEmailResendOtp')
                        && !Route::is('verifyUserEmailSubmit')
                    ) {
                        return redirect()->route('verifyUserEmail');
                    }
                } else {
                    $emailVerificationStatus = 'cleared';
                }
            }

            // Mfa verification
            if (
                $maintenanceStatus === 'cleared' &&
                $emailVerificationStatus === 'cleared'
            ) {
                if ((bool) $user->require_login_mfa === true) {
                    if (
                        (bool) $currentSession->mfa_verified !== true
                        || $currentSession->login_otp !== null
                        || $currentSession->login_otp_expires_at !== null
                    ) {
                        if (
                            !Route::is('authenticateLogin')
                            && !Route::is('logoutRequest')
                            && !Route::is('resendLoginOtp')
                            && !Route::is('verifyLoginOtp')
                            && !Route::is('verifyLoginOtpSubmit')
                        ) {
                            return redirect()->route('authenticateLogin');
                        }
                    } else {
                        $mfaVerificationStatus = 'cleared';
                    }
                } else {
                    $mfaVerificationStatus = 'cleared';
                }
            }


            // Policy Guard
            ############# -> Init
            // 0 - admin, 1-staff , 2- customer
            $applicableToUserColumn = null;

            // Determine the applicable column based on account type or admin privilege
            if (in_array($user->account_type, [0, 1])) {
                $applicableToUserColumn = 'applicable_to_administrator';
            } elseif ($user->account_type == 2) {
                $applicableToUserColumn = 'applicable_to_customer';
            }

            // Retrieve the active system policies that are applicable to the user
            $systemPolicies = SystemPolicy::where('is_active', true);

            if ($applicableToUserColumn) {
                $systemPolicies->where($applicableToUserColumn, true);
            }

            $systemPolicies = $systemPolicies->get();

            // Reverify the first functions
            // ############# -> Init

            if (
                $maintenanceStatus === 'cleared' &&
                $emailVerificationStatus === 'cleared' &&
                $mfaVerificationStatus === 'cleared' &&
                $policyGuard === 'waiting'


            ) {
                if (
                    $maintenanceStatus === 'cleared' &&
                    $emailVerificationStatus === 'cleared' &&
                    $mfaVerificationStatus === 'cleared' &&
                    $policyGuard === 'waiting'
                ) {
                    $hasUnagreedPolicy = false;

                    foreach ($systemPolicies as $policy) {
                        $reAgreementRequired = UserAgreedPolicy::where('username', $user->username)
                            ->where('policy', $policy->slug)
                            ->where('agreement_status', '!=', 'agreed')
                            ->exists();

                        $agreementRecordNotFound = !UserAgreedPolicy::where('username', $user->username)
                            ->where('policy', $policy->slug)
                            ->exists();

                        if ($reAgreementRequired || $agreementRecordNotFound) {
                            $hasUnagreedPolicy = true;

                            if (
                                !Route::is('manageSystemPolicyAgreement') &&
                                !Route::is('userAgreeToSystemPolicy') &&
                                !Route::is('logoutRequest')
                            ) {
                                return redirect()->route('manageSystemPolicyAgreement');
                            }

                            break;
                        }
                    }

                    if (!$hasUnagreedPolicy) {
                        $policyGuard = 'cleared';
                    }
                }
            }



            // Session Management
            // Reverify the first functions
            if (
                $maintenanceStatus === 'cleared' &&
                $emailVerificationStatus === 'cleared' &&
                $mfaVerificationStatus === 'cleared' &&
                $policyGuard === 'cleared' &&
                $sessionLimitStatus === 'waiting'
            ) {
                if (
                    $userActiveSessions > 1
                    && in_array((int) $accountType, [0, 1], true)
                ) {
                    if (
                        !Route::is('manageSession')
                        && !Route::is('logoutRequest')
                        && !Route::is('endOtherSessions')
                    ) {
                        return redirect()->route('manageSession');
                    }
                } else {
                    $sessionLimitStatus = 'cleared';
                }
            }


            // Awaiting Verification
            // Reverify the first functions
            if (
                $maintenanceStatus === 'cleared' &&
                $emailVerificationStatus === 'cleared' &&
                $mfaVerificationStatus === 'cleared' &&
                $policyGuard === 'cleared' &&
                $sessionLimitStatus === 'cleared'

            ) {
                if ($accountStatus == false) {
                    if (
                        !Route::is('inactiveAccount')
                        && !Route::is('logoutRequest')
                    ) {
                        return redirect()->route('inactiveAccount');
                    }
                }
                $inactiveAccount = 'cleared';
            }


            // // Disabled Account
            // // Reverify the first functions
            // if (
            //     $maintenanceStatus === 'cleared' &&
            //     $emailVerificationStatus === 'cleared' &&
            //     $mfaVerificationStatus === 'cleared' &&
            //     $policyGuard === 'cleared' &&
            //     $sessionLimitStatus === 'cleared' &&
            //     $profileSetupStatus === 'cleared' &&
            //     $awaitingVerificationStatus === 'cleared'

            // ) {
            //     if ($accountStatus == 3) {
            //         if (
            //             !Route::is('disabledUserAccount')
            //             && !Route::is('logoutRequest')
            //         ) {
            //             return redirect()->route('disabledUserAccount');
            //         }
            //     } else {
            //         $disabledAccountStatus = 'cleared';
            //     }
            // }

            // // Require Academic Status Update
            // // Reverify the first functions
            // if (
            //     $maintenanceStatus === 'cleared' &&
            //     $emailVerificationStatus === 'cleared' &&
            //     $mfaVerificationStatus === 'cleared' &&
            //     $policyGuard === 'cleared' &&
            //     $sessionLimitStatus === 'cleared' &&
            //     $profileSetupStatus === 'cleared' &&
            //     $awaitingVerificationStatus === 'cleared' &&
            //     $disabledAccountStatus === 'cleared'
            // ) {
            //     if ($accountType === 2 && $user->memberAcademicInfo && $user->memberAcademicInfo->academic_status === 'unknown') {
            //         if (
            //             !Route::is('memberUpdateAcademicStatus')
            //             && !Route::is('logoutRequest')
            //             && !Route::is('memberUpdateAcademicStatusStep2')
            //             && !Route::is('memberUpdateAcademicStatusSubmit')
            //         ) {
            //             return redirect()->route('memberUpdateAcademicStatus');
            //         }
            //     } else {
            //         $requireAcademicStatusUpdate = 'cleared';
            //     }
            // }

            // // for admin - check if he has at least one role and the role has at least one permission
            // // reverify the first functions
            // if (
            //     $maintenanceStatus === 'cleared' &&
            //     $emailVerificationStatus === 'cleared' &&
            //     $mfaVerificationStatus === 'cleared' &&
            //     $policyGuard === 'cleared' &&
            //     $sessionLimitStatus === 'cleared' &&
            //     $profileSetupStatus === 'cleared' &&
            //     $awaitingVerificationStatus === 'cleared' &&
            //     $disabledAccountStatus === 'cleared' &&
            //     $requireAcademicStatusUpdate === 'cleared'
            // ) {
            //     $userRec = User::where('username', $user->username)->first();
            //     $hasRole = $userRec->roles()->exists();

            //     $hasAnyPermission = $userRec->roles()
            //         ->whereHas('permissions')
            //         ->exists();
            //     if ($user->account_type == 1) {
            //         if (!$hasRole || !$hasAnyPermission) {
            //             abort(403);
            //         }
            //     }
            // }
        }

        return $response;
    }
}
