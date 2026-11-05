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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ShippingConfigController extends Controller
{
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

    public function shippingRates(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless(
            $user->hasPermission('shipping_config.manage'),
            403
        );

        $selectedZoneId = $request->get('zone');

        $zones = ShippingZone::orderBy('name')->get();

        $weights = Weight::orderBy('name')->get();

        $surcharges = ShippingSurcharge::where('is_active', true)
            ->orderBy('name')
            ->get();

        $rates = ShippingRate::query()
            ->with(['shippingZone', 'weight', 'surcharges'])
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
            'surcharges' => $surcharges,
            'rates' => $rates,
            'selectedZoneId' => $selectedZoneId,
        ];

        return view('users.admin.shipping.shippingConfig.rates.shippingRates', compact('data'));
    }
}
