<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'mobile' => [
                'nullable',
                'string',
                'max:20',
            ],
        ]);

        // Update profile details
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Save mobile only when the field is available in the request
        if (array_key_exists('mobile', $validated)) {
            $user->mobile = $validated['mobile'];
        }

        // Save changes in database
        $user->save();

        return redirect()
            ->route('profile')
            ->with('success', 'Profile updated successfully!');
    }
}
