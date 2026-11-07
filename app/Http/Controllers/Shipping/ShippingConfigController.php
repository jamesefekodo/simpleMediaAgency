<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress\Location;
use App\Models\ShippingAddress\ShippingRate;
use App\Models\ShippingAddress\ShippingSurcharge;
use App\Models\ShippingAddress\ShippingZone;
use App\Models\Shop\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ShippingConfigController extends Controller
{
    public function shippingZones(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $searchKey = trim($request->get('searchKey', ''));

        $locations = Location::where('is_active', true)
            ->orderBy('name')
            ->get();

        $zones = ShippingZone::query()
            ->withCount(['locations', 'shippingRates'])
            ->when($searchKey, function ($query) use ($searchKey) {
                $query->where(function ($zoneQuery) use ($searchKey) {
                    $zoneQuery->where('name', 'like', '%' . $searchKey . '%')
                        ->orWhere('slug', 'like', '%' . $searchKey . '%')
                        ->orWhere('description', 'like', '%' . $searchKey . '%');
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $data = [
            'pageTitle' => 'Shipping Zones',
            'locations' => $locations,
            'zones' => $zones,
            'searchKey' => $searchKey,
        ];

        return view('users.admin.shipping.shippingConfig.zones.shippingZones', compact('data'));
    }

    public function createNewShippingZone(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );


        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'slug' => [
            //     'nullable',
            //     'string',
            //     'max:255',
            //     'regex:/^[a-z0-9]+(?:[-_][a-z0-9]+)*$/',
            //     'unique:shipping_zones,slug',
            // ],
            'description' => ['nullable', 'string', 'max:1000'],
            'free_shipping_threshold' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'location_ids' => ['nullable', 'array'],
            'location_ids.*' => ['exists:locations,id'],
        ]);

        DB::transaction(function () use ($request, $validated) {
            $zone = ShippingZone::create([
                'name' => $validated['name'],
                // 'slug' => !empty($validated['slug'])
                //     ? Str::slug($validated['slug'])
                //     : Str::slug($validated['name']),
                'description' => $validated['description'] ?? null,
                'free_shipping_threshold' => $validated['free_shipping_threshold'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            $zone->locations()->sync($validated['location_ids'] ?? []);
        });

        return redirect()
            ->back()
            ->with('success', 'Shipping zone created successfully.');
    }

    public function updateShippingZone($slug, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $shippingZone = ShippingZone::where('slug', $slug)->first();
        if (!$shippingZone) {
            return redirect()->back()->with('error', 'Shipping zone not found.');
        }



        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'slug' => [
            //     'nullable',
            //     'string',
            //     'max:255',
            //     'regex:/^[a-z0-9]+(?:[-_][a-z0-9]+)*$/',
            //     'unique:shipping_zones,slug,' . $shippingZone->id,
            // ],
            'description' => ['nullable', 'string', 'max:1000'],
            'free_shipping_threshold' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'location_ids' => ['nullable', 'array'],
            'location_ids.*' => ['exists:locations,id'],
        ]);

        DB::transaction(function () use ($request, $shippingZone, $validated) {
            $shippingZone->update([
                'name' => $validated['name'],
                // 'slug' => $validated['slug'] ?? Str::slug($validated['name']),
                'description' => $validated['description'] ?? null,
                'free_shipping_threshold' => $validated['free_shipping_threshold'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            $shippingZone->locations()->sync($validated['location_ids'] ?? []);
        });

        return redirect()
            ->back()
            ->with('success', 'Shipping zone updated successfully.');
    }
    public function deleteShippingZone($slug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $shippingZone = ShippingZone::where('slug', $slug)->first();
        if (!$shippingZone) {
            return redirect()->back()->with('error', 'Shipping zone not found.');
        }


        DB::transaction(function () use ($shippingZone) {
            $shippingZone->locations()->detach();

            $shippingZone->delete();
        });

        return redirect()
            ->back()
            ->with('success', 'Shipping zone deleted successfully.');
    }

    public function locations(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );
        $requestType = 'all';
        $searchKey = '';
        $pageTitle = 'Shipping Locations';

        $selectedType = $request->input('type', 'country');
        $selectedParent = $request->input('parent');

        $allowedTypes = ['country', 'state', 'lga', 'city'];

        if (! in_array($selectedType, $allowedTypes)) {
            $selectedType = 'country';
        }

        $locations = Location::query()
            ->where('type', $selectedType)
            ->when($selectedParent, function ($query) use ($selectedParent) {
                $query->where('parent_id', $selectedParent);
            })
            ->when($request->filled('searchKey'), function ($query) use ($request) {
                $searchKey = $request->input('searchKey');

                $query->where(function ($subQuery) use ($searchKey) {
                    $subQuery->where('name', 'like', "%{$searchKey}%")
                        ->orWhere('code', 'like', "%{$searchKey}%");
                });
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        if ($request->filled('searchKey')) {
            $requestType = 'search';
            $pageTitle = 'Search Results :: ' . $request->input('searchKey');
        }

        $parentOptions = [];

        if ($selectedType !== 'country') {
            $parentType = match ($selectedType) {
                'state' => 'country',
                'lga' => 'state',
                'city' => 'lga',
                default => null,
            };

            $parentOptions = Location::where('type', $parentType)
                ->orderBy('name')
                ->get();
        }


        $allLocations = Location::where('is_active', true)->orderBy('name')->get();

        $data = [
            'requestType' => $requestType,
            'searchKey' => $searchKey,
            'pageTitle' => $pageTitle,
            'locations' => $locations,
            'selectedType' => $selectedType,
            'selectedParent' => $selectedParent,
            'parentOptions' => $parentOptions,
            'allLocations' => $allLocations,
        ];


        return view('users.admin.shipping.shippingConfig.locations.locations', compact('data'));
    }

    public function createLocationSubmit(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:country,state,lga,city',
            'parent_id' => 'nullable|exists:locations,id',
            'code' => 'nullable|string|max:10',
            'is_active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validatedData['name']);

        $counter = 1;
        $originalSlug = $slug;

        while (Location::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Location::create([
            'name' => trim($validatedData['name']),
            'slug' => $slug,
            'type' => $validatedData['type'],
            'parent_id' => $validatedData['parent_id'] ?? null,
            'code' => $validatedData['code'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Location added successfully.');
    }
    public function updateLocation(Request $request, Location $location)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );


        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:country,state,lga,city',
            'parent_id' => 'nullable|exists:locations,id',
            'code' => 'nullable|string|max:10',
            'is_active' => 'nullable|boolean',
        ]);

        if ($location->id == $validatedData['parent_id']) {
            return redirect()
                ->back()
                ->with('error', 'A location cannot be its own parent.');
        }

        $location->update([
            'name' => trim($validatedData['name']),
            'type' => $validatedData['type'],
            'parent_id' => $validatedData['parent_id'] ?? null,
            'code' => $validatedData['code'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Location updated successfully.');
    }
    public function deleteLocation(Location $location)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        if ($location->children()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Delete or move its child locations first.');
        }

        $location->delete();

        return redirect()
            ->back()
            ->with('success', 'Location deleted successfully.');
    }

    public function surcharges(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $searchKey = trim($request->get('searchKey', ''));
        $selectedType = $request->get('type');

        $surcharges = ShippingSurcharge::query()
            ->when($searchKey, function ($query) use ($searchKey) {
                $query->where(function ($surchargeQuery) use ($searchKey) {
                    $surchargeQuery->where('name', 'like', '%' . $searchKey . '%')
                        ->orWhere('slug', 'like', '%' . $searchKey . '%')
                        ->orWhere('description', 'like', '%' . $searchKey . '%');
                });
            })
            ->when($selectedType, function ($query) use ($selectedType) {
                $query->where('type', $selectedType);
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $data = [
            'pageTitle' => 'Shipping Surcharges',
            'surcharges' => $surcharges,
            'searchKey' => $searchKey,
            'selectedType' => $selectedType,
        ];

        return view('users.admin.shipping.shippingConfig.surcharges.shippingSurcharges', compact('data'));
    }
    public function createShippingSurcharge(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'in:fixed,percentage'],
            'value' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        ShippingSurcharge::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'value' => $validated['value'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Shipping surcharge created successfully.');
    }
    public function updateShippingSurcharge($slug, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );
        $shippingSurcharge = ShippingSurcharge::where('slug', $slug)->first();
        if (!$shippingSurcharge) {
            return redirect()->back()->with('error', 'Shipping surcharge not found.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'in:fixed,percentage'],
            'value' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $shippingSurcharge->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'value' => $validated['value'],
            'is_active' => $request->boolean('is_active'),
        ]);
        return redirect()
            ->back()
            ->with('success', 'Shipping surcharge updated successfully.');
    }

    public function deleteShippingSurcharge($slug)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );
        $shippingSurcharge = ShippingSurcharge::where('slug', $slug)->first();
        if (!$shippingSurcharge) {
            return redirect()->back()->with('error', 'Shipping surcharge not found.');
        }

        $shippingSurcharge->delete();

        return redirect()
            ->back()
            ->with('success', 'Shipping surcharge deleted successfully.');
    }
    public function shippingRates(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $searchKey = trim($request->get('searchKey', ''));
        $selectedZoneId = $request->get('zone');

        $zones = ShippingZone::orderBy('name')->get();

        $weights = Weight::orderBy('min_weight')->get();

        $rates = ShippingRate::query()
            ->with(['shippingZone', 'weight'])
            ->when($searchKey, function ($query) use ($searchKey) {
                $query->where(function ($rateQuery) use ($searchKey) {
                    $rateQuery->where('base_fee', 'like', '%' . $searchKey . '%')
                        ->orWhere('per_kg_fee', 'like', '%' . $searchKey . '%')
                        ->orWhereHas('shippingZone', function ($zoneQuery) use ($searchKey) {
                            $zoneQuery->where('name', 'like', '%' . $searchKey . '%');
                        })
                        ->orWhereHas('weight', function ($weightQuery) use ($searchKey) {
                            $weightQuery->where('name', 'like', '%' . $searchKey . '%');
                        });
                });
            })
            ->when($selectedZoneId, function ($query) use ($selectedZoneId) {
                $query->where('shipping_zone_id', $selectedZoneId);
            })
            ->orderBy('shipping_zone_id')
            ->orderBy('weight_id')
            ->paginate(20)
            ->withQueryString();

        $data = [
            'pageTitle' => 'Shipping Rates',
            'zones' => $zones,
            'weights' => $weights,
            'rates' => $rates,
            'searchKey' => $searchKey,
            'selectedZoneId' => $selectedZoneId,
            'canCreateRate' => $zones->isNotEmpty() && $weights->isNotEmpty(),
        ];

        return view('users.admin.shipping.shippingConfig.rates.shippingRates', compact('data'));
    }
    public function createNewshippingRate(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $validated = $request->validate([
            'shipping_zone_id' => ['required', 'exists:shipping_zones,id'],
            'weight_id' => ['required', 'exists:weights,id'],
            'base_fee' => ['required', 'numeric', 'min:0'],
            'per_kg_fee' => ['required', 'numeric', 'min:0'],
            'estimated_days_min' => ['required', 'integer', 'min:0'],
            'estimated_days_max' => ['required', 'integer', 'gte:estimated_days_min'],
        ]);

        $exists = ShippingRate::where('shipping_zone_id', $validated['shipping_zone_id'])
            ->where('weight_id', $validated['weight_id'])
            ->exists();

        if ($exists) {
            return redirect()
                ->route('shippingRates')
                ->with('error', 'A shipping rate already exists for this zone and weight.');
        }

        ShippingRate::create([
            'shipping_zone_id' => $validated['shipping_zone_id'],
            'weight_id' => $validated['weight_id'],
            'base_fee' => $validated['base_fee'],
            'per_kg_fee' => $validated['per_kg_fee'],
            'estimated_days_min' => $validated['estimated_days_min'],
            'estimated_days_max' => $validated['estimated_days_max'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Shipping rate created successfully.');
    }

    public function updateShippingRates($id, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $validated = $request->validate([
            'shipping_zone_id' => ['required', 'exists:shipping_zones,id'],
            'weight_id' => ['required', 'exists:weights,id'],
            'base_fee' => ['required', 'numeric', 'min:0'],
            'per_kg_fee' => ['required', 'numeric', 'min:0'],
            'estimated_days_min' => ['required', 'integer', 'min:0'],
            'estimated_days_max' => ['required', 'integer', 'gte:estimated_days_min'],
        ]);

        $shippingRate = ShippingRate::where('id', $id)->first();
        if (!$shippingRate) {
            return redirect()->back()->with('error', 'Shipping rate not found.');
        }

        $shippingRate->update([
            'shipping_zone_id' => $validated['shipping_zone_id'],
            'weight_id' => $validated['weight_id'],
            'base_fee' => $validated['base_fee'],
            'per_kg_fee' => $validated['per_kg_fee'],
            'estimated_days_min' => $validated['estimated_days_min'],
            'estimated_days_max' => $validated['estimated_days_max'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Shipping rate updated successfully.');
    }
    public function deleteSshippingRate($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );
        $shippingRate = ShippingRate::where('id', $id)->first();
        if (!$shippingRate) {
            return redirect()->back()->with('error', 'Shipping rate not found.');
        }

        $shippingRate->delete();

        return redirect()
            ->back()
            ->with('success', 'Shipping rate deleted successfully.');
    }
}
