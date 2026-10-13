@extends('layouts.dash-layout')

@section('title', 'Settings')

@section('content')

@php
$admin = auth()->user();
@endphp

<div class="mb-4">
    <h4 class="page-title mb-0">Settings</h4>
    <div class="page-sub">Manage your account and store preferences</div>
</div>

<div class="row g-3">

    {{-- Admin Profile Card --}}
    <div class="col-lg-4">
        <div class="ok-card text-center">
            <div class="card-body">

                <img src="https://placehold.co/120x120/1F3D2E/ffffff?text={{ urlencode(strtoupper(substr($admin->name ?? 'A', 0, 1))) }}"
                    class="rounded-circle mb-3" width="100" height="100" alt="Admin Profile">

                <h6 class="mb-0">
                    {{ $admin->name ?? 'N/A' }}
                </h6>

                <div class="text-muted mb-3" style="font-size:.85rem;">
                    {{ $admin->email ?? 'N/A' }}
                </div>

            </div>
        </div>
    </div>

    {{-- Profile Information --}}
    <div class="col-lg-8">
        <div class="ok-card">

            <div class="card-header">Profile Information</div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Full Name
                        </label>

                        <input type="text" class="form-control" value="{{ $admin->name ?? '' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Email
                        </label>

                        <input type="email" class="form-control" value="{{ $admin->email ?? '' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Phone
                        </label>

                        <input type="text" class="form-control" value="{{ $admin->phone ?? '' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Role
                        </label>

                        <input type="text" class="form-control" value="{{ $admin->role ?? 'Admin' }}" disabled>
                    </div>

                </div>
            </div>
        </div>

        {{-- Store Settings --}}
        <div class="ok-card mt-3">

            <div class="card-header">Store Settings</div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Store Name
                        </label>

                        <input type="text" class="form-control" value="Little Pause">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Store Tagline
                        </label>

                        <input type="text" class="form-control" value="a moment worth pausing for">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Currency
                        </label>

                        <select class="form-select">
                            <option>INR (₹)</option>
                            <option>USD ($)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small text-muted">
                            Delivery Radius (km)
                        </label>

                        <input type="number" class="form-control" value="8">
                    </div>

                </div>

                <button type="button" class="btn btn-lp-primary mt-4 px-4">
                    Save Store Settings
                </button>
            </div>
        </div>

        {{-- Notification Preferences --}}
        <div class="ok-card mt-3">

            <div class="card-header">Notification Preferences</div>

            <div class="card-body">

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" checked>

                    <label class="form-check-label">
                        Email notifications for new orders
                    </label>
                </div>

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" checked>

                    <label class="form-check-label">
                        SMS alerts for cancelled orders
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox">

                    <label class="form-check-label">
                        Weekly sales report
                    </label>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection