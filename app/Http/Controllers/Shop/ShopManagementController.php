<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ShopManagementController extends Controller
{
    public function productCategories(Request $request)
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
        $productCategories = '';


        if (Route::currentRouteName() == 'productCategoriesSearch') {
            $searchKey = $request->input('searchKey');
            $productCategories = ProductCategory::where('name', 'like', "%$searchKey%")
                ->orWhere('description', 'like', "%$searchKey%")
                ->orderBy('name')
                ->paginate(20)->withQueryString();

            $requestType = 'search';
            $pageTitle = 'Search Results :: ' . $searchKey;
        } else {
            $productCategories = ProductCategory::orderBy('name')->paginate(20);
            $requestType = 'all';
            $pageTitle = 'Product Categories';
        }

        $data = [
            'requestType' => $requestType,
            'searchKey' => $searchKey,
            'pageTitle' => $pageTitle,
            'productCategories' => $productCategories,
        ];


        return view('users.admin.shop.categories.productCategories', compact('data'));
    }

    public function addNewProductCategorySubmit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product_category.create'),
            403
        );

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'description' => 'nullable|string',
        ]);

        ProductCategory::create($validatedData);

        return redirect()->back()->with('success', 'New product category added successfully.');
    }
    public function viewProductCategory($slug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product_category.read'),
            403
        );

        $category = ProductCategory::where('slug', $slug)->first();
        if (!$category) {
           return redirect()->route('productCategories')->with('error', 'Product category not found.');
        }

        $data = [
            'category' => $category,
        ];

        return view('users.admin.shop.categories.viewProductCategory', compact('data'));
    }
    public function updateProductCategory(Request $request, $slug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product_category.update'),
            403
        );

        $category = ProductCategory::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->route('productCategories')->with('error', 'Product category not found.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validatedData);

        return redirect()->back()->with('success', 'Product category updated successfully.');
    }
    public function deleteProductCategory($slug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product_category.delete'),
            403
        );

        $category = ProductCategory::where('slug', $slug)->first();
        if (!$category) {
            return redirect()->route('productCategories')->with('error', 'Product category not found.');
        }


        // $category->delete();

        return redirect()->route('productCategories')->with('success', 'Product category deleted successfully.');
    }
}
