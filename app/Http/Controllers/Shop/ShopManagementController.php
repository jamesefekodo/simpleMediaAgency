<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ShopManagementController extends Controller
{
    public function manageProductCategories(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product_category.read'),
            403
        );

        $requestType = '';
        $searchKey = '';
        $pageTitle = '';
        $systemPolicies = '';


        if (Route::currentRouteName() == 'productCategoriesSearch') {
            $searchKey = $request->input('searchKey');
            $systemPolicies = ProductCategory::where('name', 'like', "%$searchKey%")
                ->orWhere('description', 'like', "%$searchKey%")
                ->orderBy('name')
                ->paginate(20)->withQueryString();

            $requestType = 'search';
            $pageTitle = 'Search Results :: ' . $searchKey;
        } else {
            $systemPolicies = ProductCategory::orderBy('name')->paginate(20);
            $requestType = 'all';
            $pageTitle = 'Product Categories';
        }

        $data = [
            'requestType' => $requestType,
            'searchKey' => $searchKey,
            'pageTitle' => $pageTitle,
            'systemPolicies' => $systemPolicies,
        ];


        // return view('users.admin.shop.productCategories');
    }
}
