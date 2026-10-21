@extends('layouts.dash-layout')

@section('title', 'Contact Messages')

@section('content')
<div class="container-fluid py-3">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="mb-1">Contact Messages</h3>
            <p class="text-muted mb-0">Website users ke contact form messages</p>
        </div>
        <span class="badge bg-dark px-3 py-2">
            Total: {{ $contacts->total() }}
        </span>
    </div>

    @if($contacts->count())
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                        <td>{{ $contacts->firstItem() + $loop->index }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>
                            <a href="mailto:{{ $contact->email }}">
                                {{ $contact->email }}
                            </a>
                        </td>
                        <td>{{ $contact->phone ?: '—' }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td style="min-width:220px; max-width:350px; white-space:normal;">
                            {{ $contact->message }}
                        </td>
                        <td>
                            {{ $contact->created_at
                            ? \Illuminate\Support\Carbon::parse($contact->created_at)->format('d M Y, h:i A')
                            : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $contacts->links() }}
    </div>
    @else
    <div class="card border-0 shadow-sm p-5 text-center">
        <h5>No Contact Messages Yet</h5>
        <p class="text-muted mb-0">
            Jab koi user Contact Us form submit karega, message yahan dikhega.
        </p>
    </div>
    @endif

</div>
@endsection