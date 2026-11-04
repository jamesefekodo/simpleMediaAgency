<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Brand;
use App\Models\Shop\ProductCategory;
use Illuminate\Support\Facades\File;
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
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:300',
            'name' => 'required|string|max:255|unique:product_categories,name',
            'description' => 'required|string',
        ]);

        /* Create the category first so the slug is available */
        $category = ProductCategory::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
        ]);

        /* Process the image */
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $extension = strtolower($image->getClientOriginalExtension());
            $uploadPath = public_path('assets/uploads/shop/categories/image');
            $baseName = $category->slug;

            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $imageName = $baseName . '.' . $extension;
            $counter = 1;

            while (File::exists($uploadPath . '/' . $imageName)) {
                $imageName = $baseName . '-' . $counter . '.' . $extension;
                $counter++;
            }

            $image->move($uploadPath, $imageName);

            $category->update([
                'image' => $imageName,
            ]);
        }
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
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:300',
        ]);

        $category->update($validatedData);

        /* Process the image */
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = strtolower($image->getClientOriginalExtension());

            $uploadPath = public_path('assets/uploads/shop/categories/image');
            $imageName = $category->slug . '.' . $extension;

            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $oldImagePath = $category->image
                ? $uploadPath . '/' . $category->image
                : null;

            $image->move($uploadPath, $imageName);

            $category->update(['image' => $imageName]);

            if (
                $oldImagePath &&
                File::exists($oldImagePath) &&
                $oldImagePath !== $uploadPath . '/' . $imageName
            ) {
                File::delete($oldImagePath);
            }
        }

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
    public function brands(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('brands.read'),
            403
        );

        $requestType = '';
        $searchKey = '';
        $pageTitle = '';
        $brands = '';


        if (Route::currentRouteName() == 'brandsSearch') {
            $searchKey = $request->input('searchKey');
            $brands = Brand::where('brand', 'like', "%$searchKey%")
                ->orWhere('description', 'like', "%$searchKey%")
                ->orderBy('brand')
                ->paginate(20)->withQueryString();

            $requestType = 'search';
            $pageTitle = 'Search Results :: ' . $searchKey;
        } else {
            $brands = Brand::orderBy('brand')->paginate(20);
            $requestType = 'all';
            $pageTitle = 'Brands';
        }

        $data = [
            'requestType' => $requestType,
            'searchKey' => $searchKey,
            'pageTitle' => $pageTitle,
            'brands' => $brands,
        ];


        return view('users.admin.shop.brands.brands', compact('data'));
    }
    public function addNewBrandSubmit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('brands.create'),
            403
        );

        $validatedData = $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,webp|max:300',
            'brand' => 'required|string|max:255|unique:brands,brand',
            'description' => 'nullable|string',
        ]);

        /* Create the brand first so the slug is available */
        $brand = Brand::create([
            'brand' => $validatedData['brand'],
            'description' => $validatedData['description'] ?? null,
        ]);

        /* Process the logo */
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');

            $extension = strtolower($logo->getClientOriginalExtension());
            $uploadPath = public_path('assets/uploads/shop/brands/logo');
            $baseName = $brand->slug;

            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $logoName = $baseName . '.' . $extension;
            $counter = 1;

            while (File::exists($uploadPath . '/' . $logoName)) {
                $logoName = $baseName . '-' . $counter . '.' . $extension;
                $counter++;
            }

            $logo->move($uploadPath, $logoName);

            $brand->update([
                'logo' => $logoName,
            ]);
        }
        return redirect()->back()->with('success', 'New brand added successfully.');
    }
    public function viewBrands($slug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('brands.read'),
            403
        );

        $brand = Brand::where('slug', $slug)->first();
        if (!$brand) {
            return redirect()->route('brands')->with('error', 'Brand not found.');
        }

        $data = [
            'brand' => $brand,
        ];

        return view('users.admin.shop.brands.viewBrand', compact('data'));
    }
    public function updateBrandSubmit(Request $request, $slug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('brands.update'),
            403
        );

        $brand = Brand::where('slug', $slug)->first();
        if (!$brand) {
            return redirect()->route('brands')->with('error', 'Brand not found.');
        }

        $validatedData = $request->validate([
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:300',
            'brand' => 'required|string|max:255|unique:brands,brand,' . $brand->id . ',id',
            'description' => 'nullable|string',
        ]);



        $validatedData = $request->validate([
            'brand' => 'required|string|max:255|unique:brands,brand,' . $brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:300',
        ]);

        $brand->update([
            'brand' => trim($validatedData['brand']),
            'description' => $validatedData['description'] ?? null,
        ]);

        /* Process the logo */
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');

            $extension = strtolower($logo->getClientOriginalExtension());
            $uploadPath = public_path('assets/uploads/shop/brands/logo');
            $baseName = $brand->slug;

            if (! File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $logoName = $baseName . '.' . $extension;
            $counter = 1;

            while (File::exists($uploadPath . '/' . $logoName)) {
                $logoName = $baseName . '-' . $counter . '.' . $extension;
                $counter++;
            }

            /* Remember the old logo path */
            $oldLogoPath = $brand->logo
                ? $uploadPath . '/' . $brand->logo
                : null;

            /* Move the new logo first */
            $logo->move($uploadPath, $logoName);

            /* Save the new logo name */
            $brand->update([
                'logo' => $logoName,
            ]);

            /* Delete the old logo only after the new one is saved */
            if (
                $oldLogoPath &&
                File::exists($oldLogoPath) &&
                $oldLogoPath !== $uploadPath . '/' . $logoName
            ) {
                File::delete($oldLogoPath);
            }
            return redirect()->back()->with('success', 'Brand updated successfully.');
        }

        return redirect()->back()->with('success', 'Brand updated successfully.');
    }
}
