<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Config\SystemPolicy\SystemPolicy;
use App\Models\Config\SystemPolicy\UserAgreedPolicy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemPolicyController extends Controller
{
    public function manageSystemPolicyAgreement()
    {
        $user = Auth::user();
        $applicableToUserColumn = null;

        // 0 - admin, 1-staff , 2- customer

        // Determine the applicable column based on account type or admin privilege
        if (in_array($user->account_type, [0, 1]) || $user->admin_privilege) {
            $applicableToUserColumn = 'applicable_to_administrator';
        } elseif ($user->account_type == 2) {
            $applicableToUserColumn = 'applicable_to_customer';
        }

        // Retrieve the active system policies that are applicable to the user
        $systemPolicies = SystemPolicy::where('is_active', true)
            ->where($applicableToUserColumn, 1)
            ->get();

        // Retrieve the user's agreed policies
        $userAgreedPolicies = UserAgreedPolicy::where('username', $user->username)
            ->get()
            ->keyBy('policy'); // Key by policy slug for easier lookup

        $newPolicies = [];
        $updatedPolicies = [];
        $agreedPolicies = [];

        foreach ($systemPolicies as $policy) {
            $userAgreement = $userAgreedPolicies->get($policy->slug);

            if (!$userAgreement) {
                // Policy is in SystemPoliciesAndTerms but not agreed to by the user
                $newPolicies[] = $policy;
            } elseif ($userAgreement->agreement_status == 'updated') {
                // Policy is agreed but updated
                $updatedPolicies[] = $policy;
            } elseif ($userAgreement->agreement_status == 'agreed') {
                // Policy is agreed by the user
                $agreedPolicies[] = $policy;
            }
        }


        // Prepare data for view
        $data = [
            'newPolicies' => $newPolicies,
            'updatedPolicies' => $updatedPolicies,
            'agreedPolicies' => $agreedPolicies,
        ];

        return view('miscellaneous.policyAgreement.agreementIndex', compact('data'));
    }
    public function userAgreeToSystemPolicy(Request $request)
    {
        $request->validate([
            'policy' => 'required|exists:system_policies,slug',
            'agreement_status' => 'required|in:agreed',
        ]);

        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $policyOnceAgreed = UserAgreedPolicy::where('username', $user->username)->where('policy', $request->policy)->first();
        if ($policyOnceAgreed) {
            // Update the agreement
            $agreement = $policyOnceAgreed;
            $agreement->username = $user->username;
            $agreement->policy = $request->policy;
            $agreement->agreement_status = $request->agreement_status;
            $agreement->agreement_date = $today;
            $agreement->save();
        } else {
            // New agreement
            $agreement = new UserAgreedPolicy();
            $agreement->username = $user->username;
            $agreement->policy = $request->policy;
            $agreement->agreement_status = $request->agreement_status;
            $agreement->agreement_date = $today;
            $agreement->save();
        }
        return redirect()->back()->with('success', 'Done!');
    }
}
