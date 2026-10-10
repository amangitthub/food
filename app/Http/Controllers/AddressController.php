<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $isFirstAddress = !Address::where('user_id', Auth::id())->exists();
        $makeDefault = $request->boolean('is_default') || $isFirstAddress;

        $address = DB::transaction(function () use ($validated, $makeDefault) {
            if ($makeDefault) {
                Address::where('user_id', Auth::id())
                    ->update(['is_default' => 'No']);
            }

            return Address::create(array_merge($validated, [
                'user_id' => Auth::id(),
                'is_default' => $makeDefault ? 'Yes' : 'No',
            ]));
        });

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully.',
                'address' => $address,
            ]);
        }

        return redirect()->route('addresses.index')
            ->with('success', 'Address saved successfully.');
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $makeDefault = $request->boolean('is_default');

        DB::transaction(function () use ($address, $validated, $makeDefault) {
            if ($makeDefault) {
                Address::where('user_id', Auth::id())
                    ->update(['is_default' => 'No']);
            }

            $address->fill($validated);

            if ($makeDefault) {
                $address->is_default = 'Yes';
            }

            $address->save();
        });

        return redirect()->route('addresses.index')
            ->with('success', 'Address updated successfully.');
    }

    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        $wasDefault = $address->is_default === 'Yes';
        $address->delete();

        if ($wasDefault) {
            $nextAddress = Address::where('user_id', Auth::id())
                ->latest()
                ->first();

            if ($nextAddress) {
                $nextAddress->is_default = 'Yes';
                $nextAddress->save();
            }
        }

        return redirect()->route('addresses.index')
            ->with('success', 'Address deleted successfully.');
    }

    public function makeDefault($id)
    {
        $address = Address::where('user_id', Auth::id())
            ->findOrFail($id);

        DB::transaction(function () use ($address) {
            Address::where('user_id', Auth::id())
                ->update(['is_default' => 'No']);

            $address->is_default = 'Yes';
            $address->save();
        });

        return back()->with('success', 'Default address updated.');
    }
}
