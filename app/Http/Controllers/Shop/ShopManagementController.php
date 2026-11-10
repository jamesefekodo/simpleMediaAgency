<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop\Brand;
use App\Models\Shop\Colour;
use App\Models\Shop\OtherAttribute;
use App\Models\Shop\Product;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
    public function deleteBrand($slug)
    {
        //
    }
    public function colours(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('colour.manage'),
            403
        );

        $requestType = '';
        $searchKey = '';
        $pageTitle = '';
        $colours = '';


        if (Route::currentRouteName() == 'coloursSearch') {
            $searchKey = $request->input('searchKey');
            $colours = Colour::where('hex_code', 'like', "%$searchKey%")
                ->orWhere('name', 'like', "%$searchKey%")
                ->orderBy('name')
                ->paginate(20)->withQueryString();

            $requestType = 'search';
            $pageTitle = 'Search Results :: ' . $searchKey;
        } else {
            $colours = Colour::orderBy('name')->paginate(20);
            $requestType = 'all';
            $pageTitle = 'Colours';
        }

        $data = [
            'requestType' => $requestType,
            'searchKey' => $searchKey,
            'pageTitle' => $pageTitle,
            'colours' => $colours,
        ];


        return view('users.admin.shop.colours.colours', compact('data'));
    }
    public function addNewColourSubmit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('colour.manage'),
            403
        );

        $validatedData = $request->validate([
            'hex_code' => 'required|string|max:7|unique:colours,hex_code',
            'name' => 'required|string|max:255|unique:colours,name',
        ]);


        Colour::create($validatedData);

        return redirect()->back()->with('success', 'New colour added successfully.');
    }
    public function updateColourSubmit(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('colour.manage'),
            403
        );

        $colour = Colour::where('id', $id)->first();
        if (!$colour) {
            return redirect()->route('colours')->with('error', 'Colour not found.');
        }

        $validatedData = $request->validate([
            'hex_code' => 'required|string|max:7|unique:colours,hex_code,' . $colour->id,
            'name' => 'required|string|max:255|unique:colours,name,' . $colour->id,
        ]);

        $colour->update($validatedData);

        return redirect()->back()->with('success', 'Colour updated successfully.');
    }
    public function weights(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('weight.manage'),
            403
        );

        $requestType = '';
        $searchKey = '';
        $pageTitle = '';
        $weights = '';


        if (Route::currentRouteName() == 'weightsSearch') {
            $searchKey = $request->input('searchKey');
            $weights = Weight::where('name', 'like', "%$searchKey%")
                ->orWhere('min_weight', 'like', "%$searchKey%")
                ->orWhere('max_weight', 'like', "%$searchKey%")
                ->orWhere('is_active', 'like', "%$searchKey%")
                ->orderBy('name')
                ->paginate(20)->withQueryString();



            $requestType = 'search';
            $pageTitle = 'Search Results :: ' . $searchKey;
        } else {
            $weights = Weight::orderBy('name')->paginate(20);
            $requestType = 'all';
            $pageTitle = 'Weights';
        }

        $data = [
            'requestType' => $requestType,
            'searchKey' => $searchKey,
            'pageTitle' => $pageTitle,
            'weights' => $weights,
        ];


        return view('users.admin.shop.weights.weights', compact('data'));
    }
    public function addNewWeightSubmit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('weight.manage'),
            403
        );

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:weights,name',
            'min_weight' => 'required|numeric',
            'max_weight' => 'required|numeric|gt:min_weight',
        ]);

        Weight::create($validatedData);

        return redirect()->back()->with('success', 'New weight added successfully.');
    }
    public function updateWeightSubmit(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('weight.manage'),
            403
        );

        $weight = Weight::where('id', $id)->first();
        if (!$weight) {
            return redirect()->route('weights')->with('error', 'Weight not found.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:weights,name,' . $weight->id,
            'min_weight' => 'required|numeric',
            'max_weight' => 'required|numeric|gt:min_weight',
        ]);

        $weight->update($validatedData);

        return redirect()->back()->with('success', 'Weight updated successfully.');
    }
    public function deleteWeight($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('weight.manage'),
            403
        );

        $weight = Weight::where('id', $id)->first();
        if (!$weight) {
            return redirect()->route('weights')->with('error', 'Weight not found.');
        }

        $weight->delete();

        return redirect()->back()->with('success', 'Weight deleted successfully.');
    }
    public function otherAttributes(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('other_attributes.manage'),
            403
        );

        $requestType = '';
        $searchKey = '';
        $pageTitle = '';
        $otherAttributes = '';


        if (Route::currentRouteName() == 'otherAttributesSearch') {
            $searchKey = $request->input('searchKey');
            $otherAttributes = OtherAttribute::where('name', 'like', "%$searchKey%")
                ->orderBy('name')
                ->paginate(20)->withQueryString();

            $requestType = 'search';
            $pageTitle = 'Search Results :: ' . $searchKey;
        } else {
            $otherAttributes = OtherAttribute::orderBy('name')->paginate(20);
            $requestType = 'all';
            $pageTitle = 'Other Attributes';
        }

        $data = [
            'requestType' => $requestType,
            'searchKey' => $searchKey,
            'pageTitle' => $pageTitle,
            'otherAttributes' => $otherAttributes,
        ];


        return view('users.admin.shop.otherAttributes.otherAttributes', compact('data'));
    }
    public function addNewAttributeSubmit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('other_attributes.manage'),
            403
        );

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:other_attributes,name',
            'values' => 'nullable|array',
            'values.*' => 'required|string|max:255',
        ]);

        $attribute = OtherAttribute::create([
            'name' => trim($validatedData['name']),
            'is_active' => true,
        ]);

        if (! empty($validatedData['values'])) {
            foreach ($validatedData['values'] as $value) {
                $attribute->attributeValues()->create([
                    'value' => trim($value),
                ]);
            }
        }

        return redirect()->back()->with('success', 'New attribute added successfully.');
    }
    public function updateAttributeSubmit($id, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('other_attributes.manage'),
            403
        );

        $attribute = OtherAttribute::where('id', $id)->first();

        if (!$attribute) {
            return redirect()->back()->with('error', 'Records not found.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:other_attributes,name,' . $attribute->id,
            'values' => 'required|array|min:1',
            'values.*' => 'required|string|max:255',
        ]);

        $attribute->update([
            'name' => trim($validatedData['name']),
        ]);

        $attribute->attributeValues()->delete();

        foreach ($validatedData['values'] as $value) {
            $attribute->attributeValues()->create([
                'value' => trim($value),
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Attribute updated successfully.');
    }
    public function deleteAttribute($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('other_attributes.manage'),
            403
        );


        $attribute = OtherAttribute::where('id', $id)->first();
        if (!$attribute) {
            return redirect()->back()->with('error', 'Records not found.');
        }

        $attribute->attributeValues()->delete();

        $attribute->delete();

        return redirect()
            ->back()
            ->with('success', 'Attribute deleted successfully.');
    }
    public function products(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product.read'),
            403
        );

        $searchKey = trim($request->get('searchKey', ''));

        $products = Product::query()
            ->with(['brand', 'categories', 'images'])
            ->when($searchKey, function ($query) use ($searchKey) {
                $query->where(function ($productQuery) use ($searchKey) {
                    $productQuery->where('name', 'like', '%' . $searchKey . '%')
                        ->orWhere('sku', 'like', '%' . $searchKey . '%')
                        ->orWhere('slug', 'like', '%' . $searchKey . '%')
                        ->orWhereHas('brand', function ($brandQuery) use ($searchKey) {
                            $brandQuery->where('brand', 'like', '%' . $searchKey . '%');
                        })
                        ->orWhereHas('categories', function ($categoryQuery) use ($searchKey) {
                            $categoryQuery->where('name', 'like', '%' . $searchKey . '%');
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $data = [
            'pageTitle' => 'Products',
            'products' => $products,
            'searchKey' => $searchKey,
            'requestType' => request()->filled('search_key') ? 'search' : 'all',
        ];
        return view('users.admin.shop.products.products', compact('data'));
    }
    public function newProduct()
    {

        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product.create'),
            403
        );

        $data = [
            'pageTitle' => 'Create Product',
            'brands' => Brand::orderBy('brand')->get(),
            'categories' => ProductCategory::orderBy('name')->get(),
            'weights' => Weight::orderBy('min_weight')->get(),
        ];
        return view('users.admin.shop.products.createNewProduct', compact('data'));
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        $uniqueSlug = $product ? ',' . $product->slug : '';
        $uniqueSku = $product ? ',' . $product->sku : '';

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:products,slug' . $uniqueSlug,
            ],
            'brand_slug' => ['nullable', 'exists:brands,slug'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'sku' => [
                'nullable',
                'string',
                'max:100',
                'unique:products,sku' . $uniqueSku,
            ],
            'barcode' => ['nullable', 'string', 'max:100'],
            'type' => ['required', 'in:simple,variable'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'track_stock' => ['nullable', 'boolean'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'allow_backorder' => ['nullable', 'boolean'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'weight_id' => ['nullable', 'exists:weights,id'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'category_slugs' => ['nullable', 'array'],
            'category_slugs.*' => ['exists:product_categories,slug'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:300',
            ],
        ]);
    }

    private function productData(Request $request, array $validated, ?Product $product = null): array
    {
        return [
            'brand_slug' => $validated['brand_slug'] ?? null,
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'barcode' => $validated['barcode'] ?? null,
            'type' => $validated['type'],
            'price' => $validated['price'] ?? null,
            'compare_at_price' => $validated['compare_at_price'] ?? null,
            'cost_price' => $validated['cost_price'] ?? null,
            'currency' => $validated['currency'],
            'track_stock' => $request->boolean('track_stock'),
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'allow_backorder' => $request->boolean('allow_backorder'),
            'low_stock_threshold' => $validated['low_stock_threshold'] ?? 0,
            'weight_id' => $validated['weight_id'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $validated['published_at'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ];
    }

    private function storeProductImage($image, Product $product, bool $isPrimary = false): void
    {
        $path = $image->store('products/' . $product->slug, 'public');

        $product->images()->create([
            'path' => $path,
            'alt_text' => $product->name,
            'position' => $product->images()->count() + 1,
            'is_primary' => $isPrimary,
        ]);
    }


    public function addNewProductSubmit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('product.create'),
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand_slug' => ['nullable', 'exists:brands,slug'],
            'type' => ['required', 'in:simple,variable'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'weight_id' => ['nullable', 'exists:weights,id'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:300',
            ],
            'category_slugs' => ['nullable', 'array'],
            'category_slugs.*' => ['exists:product_categories,slug'],
        ]);

        $product = Product::create([
            'brand_slug' => $validated['brand_slug'] ?? null,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price' => $validated['price'] ?? null,
            'compare_at_price' => $validated['compare_at_price'] ?? null,
            'cost_price' => $validated['cost_price'] ?? null,
            'currency' => 'NGN',
            'weight_id' => $validated['weight_id'] ?? null,
            'stock_quantity' => $validated['stock_quantity'] ?? 0,
            'track_stock' => true,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
        ]);

        if (! empty($validated['category_slugs'])) {
            $product->categories()->sync($validated['category_slugs']);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $path = $image->store('products/' . $product->slug, 'public');

            $product->images()->create([
                'path' => $path,
                'alt_text' => $product->name,
                'position' => 1,
                'is_primary' => true,
            ]);
        }

        return redirect()
            ->route('viewProduct', $product->slug)
            ->with('success', 'Product created successfully.');
    }
}
