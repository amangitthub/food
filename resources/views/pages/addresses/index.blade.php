
@extends('layouts.site-layout')

@section('title', 'My Addresses | Food Website')

@section('content')

<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<style>
.food-address-page {
    --orange: #ff6b35;
    --navy: #321710;
    --muted: #82736b;
    --border: #f2dfd5;
    min-height: 75vh;
    padding: 45px 0 70px;
    background:
        radial-gradient(ellipse at 5% 10%, rgba(255,107,53,.10), transparent 32%),
        #fffaf7;
    color: var(--navy);
    font-family: "Plus Jakarta Sans", "Inter", sans-serif;
}
.food-address-page *,
.food-address-page *::before,
.food-address-page *::after {
    box-sizing: border-box;
}
.food-address-page .page-heading {
    padding: 34px;
    margin-bottom: 25px;
    border-radius: 22px;
    background: linear-gradient(115deg,#fa6028,#fc7e3a 65%,#ffc857);
    color: #fff;
    box-shadow: 0 15px 35px rgba(194,65,12,.17);
}
.food-address-page .page-heading h2 {
    margin: 0 0 10px;
    font-size: clamp(28px,4vw,40px);
    font-weight: 850;
}
.food-address-page .page-heading p {
    margin: 0;
    color: #fff0e5;
    line-height: 1.8;
}
.food-address-card {
    height: 100%;
    padding: 25px;
    margin-bottom: 22px;
    border: 1px solid var(--border);
    border-radius: 19px;
    background: #fff;
    box-shadow: 0 10px 30px rgba(100,49,20,.05);
}
.food-address-card h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 23px;
    color: var(--navy);
    font-size: 20px;
    font-weight: 850;
}
.food-address-page .form-label {
    margin-bottom: 8px;
    color: #493326;
    font-size: 13px;
    font-weight: 800;
}
.food-address-page .form-control {
    width: 100%;
    min-height: 49px;
    padding: 12px 14px;
    border: 1px solid #ebddd3;
    border-radius: 11px;
    background: #fffdfa;
    color: #352016;
    font-size: 14px;
    box-shadow: none;
}
.food-address-page .form-control:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 4px rgba(255,107,53,.12);
}
.food-address-page textarea.form-control {
    min-height: 95px;
    resize: vertical;
}
.food-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 43px;
    padding: 10px 17px;
    border: 1px solid transparent;
    border-radius: 10px;
    background: linear-gradient(110deg,#ff6b35,#fc7e3a);
    color: #fff !important;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none !important;
    cursor: pointer;
    transition: transform .2s ease, box-shadow .2s ease;
}
.food-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 7px 17px rgba(255,107,53,.22);
}
.food-btn-secondary {
    background: #fff0e7;
    border-color: #ffd4c1;
    color: #b84219 !important;
}
.food-address-map-wrap {
    margin: 20px 0;
}
.food-address-map-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
    margin-bottom: 12px;
}
.food-address-map {
    width: 100%;
    height: 330px;
    border: 1px solid #ebddd3;
    border-radius: 13px;
    overflow: hidden;
    background: #f5f1ec;
    z-index: 1;
}
.food-map-help {
    margin: 9px 0 12px;
    color: #82736b;
    font-size: 12px;
    line-height: 1.7;
}
.food-address-coordinates {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.food-address-coordinates .form-control {
    min-height: 42px;
    background: #fff7f1;
}
.address-item {
    padding: 20px;
    margin-bottom: 15px;
    border: 1px solid #eee3d9;
    border-radius: 15px;
    background: #fff;
    overflow-wrap: anywhere;
}
.address-item.default-address {
    border-color: var(--orange);
    background: #fff5ed;
}
.address-name {
    color: #321710;
    font-size: 17px;
    font-weight: 850;
}
.address-details {
    color: #82736b;
    font-size: 13px;
    line-height: 1.9;
}
.default-badge {
    display: inline-block;
    padding: 5px 10px;
    margin-bottom: 8px;
    border-radius: 20px;
    background: #ffe8dc;
    color: #b84219;
    font-size: 11px;
    font-weight: 850;
}
.address-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 9px;
}
.address-actions form {
    margin: 0;
}
.empty-address {
    padding: 35px 15px;
    border: 1px dashed #e8cfc0;
    border-radius: 15px;
    color: #82736b;
    text-align: center;
}
@media(max-width:767px) {
    .food-address-page { padding: 25px 0 40px; }
    .food-address-page .page-heading { padding: 25px 20px; }
    .food-address-card { padding: 18px; }
    .food-address-map { height: 290px; }
    .food-address-coordinates { grid-template-columns: 1fr; }
    .address-actions { width: 100%; }
    .address-actions form,
    .address-actions form button,
    .address-actions > button { width: 100%; }
}
@media(prefers-reduced-motion:reduce) {
    .food-address-page *,
    .food-address-page *::before,
    .food-address-page *::after {
        animation: none !important;
        transition: none !important;
    }
}
</style>

<section class="food-address-page">
    <div class="container">

        <div class="page-heading">
            <h2>My Addresses</h2>
            <p>Save your delivery addresses and select your exact location on the map.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please correct these errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">

            {{-- ADD / EDIT ADDRESS --}}
            <div class="col-lg-5">
                <div class="food-address-card" id="addressFormCard">

                    <h4 id="addressFormHeading">
                        <i class="fas fa-map-marker-alt" style="color:#ff6b35"></i>
                        Add New Address
                    </h4>

                    <form id="addressForm"
                          action="{{ route('addresses.store') }}"
                          method="POST">
                        @csrf

                        <input type="hidden" name="_method" id="addressMethod"
                               value="PUT" disabled>

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" name="name" id="name"
                                   class="form-control"
                                   value="{{ old('name') }}"
                                   maxlength="255" autocomplete="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number *</label>
                            <input type="tel" name="mobile" id="mobile"
                                   class="form-control"
                                   value="{{ old('mobile') }}"
                                   maxlength="20" autocomplete="tel" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Complete Address *</label>
                            <textarea name="address" id="address"
                                      class="form-control" rows="3"
                                      maxlength="2000"
                                      autocomplete="street-address"
                                      required>{{ old('address') }}</textarea>
                        </div>

                        {{-- MAP PICKER --}}
                        <div class="food-address-map-wrap">
                            <label class="form-label">
                                <i class="fas fa-map-marked-alt"></i>
                                Select Delivery Location
                            </label>

                            <div class="food-address-map-toolbar">
                                <button type="button" id="useMyLocationBtn"
                                        class="food-btn food-btn-secondary">
                                    <i class="fas fa-location-arrow"></i>
                                    Use My Location
                                </button>

                                <button type="button" id="resetMapBtn"
                                        class="food-btn food-btn-secondary">
                                    <i class="fas fa-undo"></i>
                                    Reset Map
                                </button>
                            </div>

                            <div id="addressMap" class="food-address-map"></div>

                            <p id="mapStatus" class="food-map-help" aria-live="polite">
                                Click on the map or drag the pin to select your delivery location.
                            </p>

                            <div class="food-address-coordinates">
                                <div>
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude"
                                           class="form-control"
                                           value="{{ old('latitude') }}" readonly>
                                </div>
                                <div>
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude"
                                           class="form-control"
                                           value="{{ old('longitude') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city"
                                       class="form-control"
                                       value="{{ old('city') }}"
                                       maxlength="100" autocomplete="address-level2">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" name="state" id="state"
                                       class="form-control"
                                       value="{{ old('state') }}"
                                       maxlength="100" autocomplete="address-level1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pincode" class="form-label">PIN Code</label>
                            <input type="text" name="pincode" id="pincode"
                                   class="form-control"
                                   value="{{ old('pincode') }}"
                                   maxlength="20" autocomplete="postal-code">
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Country *</label>
                            <input type="text" name="country" id="country"
                                   class="form-control"
                                   value="{{ old('country', 'India') }}"
                                   maxlength="100" autocomplete="country-name" required>
                        </div>

                        <button type="submit" id="addressSubmitButton"
                                class="food-btn w-100">
                            <i class="fas fa-plus"></i> Save Address
                        </button>

                        <button type="button" id="cancelAddressEdit"
                                class="food-btn food-btn-secondary w-100 mt-2"
                                style="display:none">
                            <i class="fas fa-times"></i> Cancel Edit
                        </button>
                    </form>
                </div>
            </div>

            {{-- SAVED ADDRESSES --}}
            <div class="col-lg-7">
                <div class="food-address-card">
                    <h4>
                        <i class="fas fa-bookmark" style="color:#ff6b35"></i>
                        Saved Addresses
                        <span class="text-muted">({{ $addresses->count() }})</span>
                    </h4>

                    @forelse($addresses as $address)
                        <div class="address-item {{ $address->is_default === 'Yes' ? 'default-address' : '' }}">

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                                <div class="address-name">{{ $address->name }}</div>

                                @if($address->is_default === 'Yes')
                                    <span class="default-badge">
                                        <i class="fas fa-check-circle"></i> Default Address
                                    </span>
                                @endif
                            </div>

                            <div class="address-details">
                                <div><i class="fas fa-phone me-2"></i>{{ $address->mobile }}</div>
                                <div><i class="fas fa-map-marker-alt me-2"></i>{{ $address->address }}</div>

                                <div>
                                    {{ collect([
                                        $address->city,
                                        $address->state,
                                        $address->pincode
                                    ])->filter()->implode(', ') }}
                                </div>

                                <div>{{ $address->country }}</div>

                                @if($address->latitude !== null && $address->longitude !== null)
                                    <div>
                                        <i class="fas fa-location-arrow me-1"></i>
                                        Map location saved
                                    </div>
                                @endif
                            </div>

                            <div class="address-actions mt-3">

                                <button type="button"
                                        class="food-btn edit-address-btn"
                                        data-update-url="{{ route('addresses.update', $address->id) }}"
                                        data-name="{{ $address->name }}"
                                        data-mobile="{{ $address->mobile }}"
                                        data-address="{{ $address->address }}"
                                        data-city="{{ $address->city }}"
                                        data-state="{{ $address->state }}"
                                        data-pincode="{{ $address->pincode }}"
                                        data-country="{{ $address->country }}"
                                        data-latitude="{{ $address->latitude }}"
                                        data-longitude="{{ $address->longitude }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                @if($address->is_default !== 'Yes')
                                    <form action="{{ route('addresses.default', $address->id) }}"
                                          method="POST">
                                        @csrf
                                        <button type="submit" class="food-btn food-btn-secondary">
                                            <i class="fas fa-check"></i> Set Default
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('addresses.destroy', $address->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this address?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="food-btn"
                                            style="background:#e52c2c">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="empty-address">
                            <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                            <h5>No addresses saved yet</h5>
                            <p class="mb-0">Add your first delivery address using the form.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('profile') }}" class="food-btn food-btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to My Profile
            </a>
        </div>

    </div>
</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addressForm');
    const methodField = document.getElementById('addressMethod');
    const heading = document.getElementById('addressFormHeading');
    const submitButton = document.getElementById('addressSubmitButton');
    const cancelButton = document.getElementById('cancelAddressEdit');

    const fields = {
        name: document.getElementById('name'),
        mobile: document.getElementById('mobile'),
        address: document.getElementById('address'),
        city: document.getElementById('city'),
        state: document.getElementById('state'),
        pincode: document.getElementById('pincode'),
        country: document.getElementById('country'),
        latitude: document.getElementById('latitude'),
        longitude: document.getElementById('longitude')
    };

    const storeUrl = @json(route('addresses.store'));
    const defaultCenter = [20.5937, 78.9629];

    let map = null;
    let marker = null;
    let reverseTimer = null;
    let reverseRequestId = 0;

    function validCoordinates(lat, lng) {
        return lat !== '' && lng !== '' &&
            Number.isFinite(Number(lat)) &&
            Number.isFinite(Number(lng)) &&
            Math.abs(Number(lat)) <= 90 &&
            Math.abs(Number(lng)) <= 180;
    }

    function setStatus(message) {
        document.getElementById('mapStatus').textContent = message;
    }

    function setCoordinates(lat, lng, lookupAddress) {
        fields.latitude.value = Number(lat).toFixed(7);
        fields.longitude.value = Number(lng).toFixed(7);

        const point = [Number(lat), Number(lng)];

        if (!marker) {
            marker = L.marker(point, {draggable: true}).addTo(map);

            marker.on('dragend', function () {
                const p = marker.getLatLng();
                setCoordinates(p.lat, p.lng, true);
            });
        } else {
            marker.setLatLng(point);
        }

        if (lookupAddress) {
            reverseGeocode(lat, lng);
        } else {
            setStatus('Saved map location loaded.');
        }
    }

    async function reverseGeocode(lat, lng) {
        clearTimeout(reverseTimer);

        reverseTimer = setTimeout(async function () {
            const requestId = ++reverseRequestId;
            setStatus('Looking up address details...');

            try {
                const url = new URL('https://nominatim.openstreetmap.org/reverse');
                url.searchParams.set('format', 'jsonv2');
                url.searchParams.set('lat', lat);
                url.searchParams.set('lon', lng);
                url.searchParams.set('addressdetails', '1');

                const response = await fetch(url.toString(), {
                    headers: {'Accept': 'application/json'}
                });

                if (!response.ok) throw new Error('Lookup failed');

                const result = await response.json();
                if (requestId !== reverseRequestId) return;

                const a = result.address || {};

                if (result.display_name) fields.address.value = result.display_name;

                fields.city.value =
                    a.city || a.town || a.village ||
                    a.municipality || a.county || fields.city.value;

                fields.state.value = a.state || fields.state.value;
                fields.pincode.value = a.postcode || fields.pincode.value;
                fields.country.value = a.country || fields.country.value || 'India';

                setStatus('Location selected. Please verify the address details.');
            } catch (error) {
                setStatus('Coordinates selected. Enter or verify the address details manually.');
            }
        }, 1100);
    }

    function clearLocation() {
        clearTimeout(reverseTimer);
        reverseRequestId++;

        fields.latitude.value = '';
        fields.longitude.value = '';

        if (marker) {
            map.removeLayer(marker);
            marker = null;
        }

        setStatus('Click the map to select a location.');
    }

    function initializeMap() {
        if (map || typeof L === 'undefined') return;

        map = L.map('addressMap').setView(defaultCenter, 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        map.on('click', function (event) {
            setCoordinates(event.latlng.lat, event.latlng.lng, true);
        });

        if (validCoordinates(fields.latitude.value, fields.longitude.value)) {
            map.setView([Number(fields.latitude.value), Number(fields.longitude.value)], 16);
            setCoordinates(fields.latitude.value, fields.longitude.value, false);
        }

        setTimeout(function () {
            map.invalidateSize();
        }, 250);
    }

    function resetForm() {
        form.action = storeUrl;
        methodField.disabled = true;
        methodField.value = 'PUT';
        form.reset();

        fields.country.value = 'India';
        clearLocation();
        map.setView(defaultCenter, 5);

        heading.innerHTML = '<i class="fas fa-map-marker-alt" style="color:#ff6b35"></i> Add New Address';
        submitButton.innerHTML = '<i class="fas fa-plus"></i> Save Address';
        cancelButton.style.display = 'none';

        document.querySelectorAll('.edit-address-btn').forEach(function (button) {
            button.innerHTML = '<i class="fas fa-edit"></i> Edit';
        });
    }

    document.querySelectorAll('.edit-address-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const d = this.dataset;

            form.action = d.updateUrl;
            methodField.disabled = false;
            methodField.value = 'PUT';

            fields.name.value = d.name || '';
            fields.mobile.value = d.mobile || '';
            fields.address.value = d.address || '';
            fields.city.value = d.city || '';
            fields.state.value = d.state || '';
            fields.pincode.value = d.pincode || '';
            fields.country.value = d.country || 'India';

            if (validCoordinates(d.latitude, d.longitude)) {
                map.setView([Number(d.latitude), Number(d.longitude)], 16);
                setCoordinates(d.latitude, d.longitude, false);
            } else {
                clearLocation();
                map.setView(defaultCenter, 5);
            }

            heading.innerHTML = '<i class="fas fa-edit" style="color:#ff6b35"></i> Edit Address';
            submitButton.innerHTML = '<i class="fas fa-save"></i> Update Address';
            cancelButton.style.display = 'inline-flex';

            document.querySelectorAll('.edit-address-btn').forEach(function (item) {
                item.innerHTML = '<i class="fas fa-edit"></i> Edit';
            });
            this.innerHTML = '<i class="fas fa-check"></i> Editing';

            map.invalidateSize();

            document.getElementById('addressFormCard').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    });

    cancelButton.addEventListener('click', resetForm);

    document.getElementById('useMyLocationBtn').addEventListener('click', function () {
        if (!navigator.geolocation) {
            setStatus('Geolocation is not supported by this browser.');
            return;
        }

        setStatus('Getting your current location...');

        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            map.setView([lat, lng], 17);
            setCoordinates(lat, lng, true);
        }, function (error) {
            const messages = {
                1: 'Location permission denied. Select your location manually on the map.',
                2: 'Location unavailable. Select your location manually on the map.',
                3: 'Location request timed out. Please try again.'
            };

            setStatus(messages[error.code] || 'Unable to get location.');
        }, {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 60000
        });
    });

    document.getElementById('resetMapBtn').addEventListener('click', function () {
        clearLocation();
        map.setView(defaultCenter, 5);
    });

    initializeMap();

    // Ensure the map fills its container after layout changes.
    window.addEventListener('resize', function () {
        if (map) map.invalidateSize();
    });
});
</script>

@endsection