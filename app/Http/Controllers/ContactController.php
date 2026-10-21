<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:191',
            'email'   => 'required|email|max:191',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:191',
            'message' => 'required|string|max:5000',
        ]);

        DB::table('contacts')->insert([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'subject'    => $validated['subject'],
            'message'    => $validated['message'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with(
            'success',
            'Your message has been submitted successfully!'
        );
    }
    public function index()
{
    $contacts = \Illuminate\Support\Facades\DB::table('contacts')
        ->latest('created_at')
        ->paginate(15);

    return view('dash.contacts', compact('contacts'));
}
}
