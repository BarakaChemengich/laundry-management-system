@extends('layouts.app')

@section('content')
@php
    $weight = max((int) $order->weight_quantity, 1);
    $total = (float) $order->total_price;
    $unitPrice = $weight > 0 ? $total / $weight : 0;
    $serviceCharge = max((int) round($total * 0.12), 0);
    $riderFee = 100;
    $savedPickupDate = old('pickup_date', $order->scheduled_pickup_at?->format('Y-m-d'));
    $savedPickupTime = old('pickup_time', $order->scheduled_pickup_at?->format('H:i'));
    $savedReturnDate = old('return_date', $order->return_date?->format('Y-m-d'));
    $savedReturnAddress = old('return_address', $order->return_address);
    $savedDeliveryOption = old('delivery_option', $order->delivery_option ?? 'Pickup & Return');
    $savedPhone = old('phone_number', $order->phone_number ?? auth()->user()->phone_number);
@endphp

<style>
    .pickup-page {
        padding: 34px;
    }

    .pickup-shell {
        max-width: 1020px;
        margin: 0 auto;
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        border: 1px solid #e9eef8;
    }

    .pickup-hero {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 24px;
        padding: 28px 34px 24px;
        color: #fff;
        background: linear-gradient(135deg, #1f47b7 0%, #2747a8 100%);
    }

    .pickup-hero-copy small {
        display: block;
        margin-bottom: 6px;
        color: #f7c948;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .pickup-hero-copy h2 {
        margin: 0 0 4px;
        font-size: 31px;
        font-weight: 700;
        line-height: 1.2;
    }

    .pickup-hero-copy p {
        margin: 0;
        color: rgba(255, 255, 255, 0.82);
        font-size: 13px;
    }

    .pickup-steps {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 4px;
    }

    .pickup-step-line {
        width: 36px;
        height: 2px;
        background: rgba(255, 255, 255, 0.32);
    }

    .pickup-step {
        width: 28px;
        height: 28px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        background: rgba(255, 255, 255, 0.22);
        border: 2px solid rgba(255, 255, 255, 0.14);
    }

    .pickup-step.done {
        background: #1fcb75;
        border-color: #1fcb75;
    }

    .pickup-step.active {
        color: #172554;
        background: #f7b500;
        border-color: #f7b500;
    }

    .pickup-form {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 28px;
        padding: 28px;
        background: #fff;
        align-items: start;
    }

    .pickup-main {
        grid-column: 1;
        padding: 0;
        order: 1;
    }

    .pickup-section-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .pickup-section-bar h3 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
    }

    .pickup-section-bar span {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }

    .pickup-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 16px;
    }

    .pickup-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .pickup-field.full {
        grid-column: 1 / -1;
    }

    .pickup-field label {
        font-size: 12px;
        font-weight: 600;
        color: #334155;
    }

    .pickup-field input,
    .pickup-field select,
    .pickup-field textarea {
        width: 100%;
        border: 1px solid #dbe3f0;
        border-radius: 12px;
        padding: 12px 14px;
        background: #fff;
        color: #0f172a;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .pickup-field textarea {
        min-height: 92px;
        resize: vertical;
    }

    .pickup-field input:focus,
    .pickup-field select:focus,
    .pickup-field textarea:focus {
        border-color: #2f5bea;
        box-shadow: 0 0 0 3px rgba(47, 91, 234, 0.12);
    }

    .pickup-note {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 16px 0 0;
        font-size: 11px;
        color: #64748b;
    }

    .pickup-note input {
        accent-color: #2f5bea;
    }

    .pickup-errors {
        margin-bottom: 16px;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #fecaca;
        background: #fef2f2;
        color: #b91c1c;
        font-size: 12px;
    }

    .pickup-errors ul {
        list-style: disc;
        margin-left: 18px;
    }

    .pickup-summary {
        grid-column: 2;
        order: 2;
        align-self: start;
        border: 1px solid #e6edf7;
        border-radius: 20px;
        padding: 22px 20px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
        position: sticky;
        top: 24px;
    }

    .pickup-success {
        margin-bottom: 16px;
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #bbf7d0;
        background: #f0fdf4;
        color: #166534;
        font-size: 12px;
        font-weight: 600;
    }

    .pickup-summary h4 {
        margin: 0 0 16px;
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: 0.04em;
    }

    .summary-block {
        margin-bottom: 16px;
    }

    .summary-label {
        display: block;
        margin-bottom: 2px;
        font-size: 11px;
        color: #64748b;
    }

    .summary-value {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.45;
    }

    .summary-divider {
        margin: 14px 0;
        border: 0;
        border-top: 1px solid #edf2f7;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin: 18px 0 14px;
        font-weight: 700;
        color: #0f172a;
    }

    .summary-total span:last-child {
        color: #1d4ed8;
    }

    .pickup-submit {
        width: 100%;
        border: 0;
        border-radius: 12px;
        padding: 13px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(90deg, #1f5eff 0%, #2357db 100%);
    }

    .pickup-cancel {
        display: block;
        width: 100%;
        margin-top: 10px;
        border-radius: 12px;
        padding: 12px 16px;
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        background: #eef2f7;
    }

    @media (max-width: 960px) {
        .pickup-form {
            grid-template-columns: 1fr;
        }

        .pickup-main,
        .pickup-summary {
            grid-column: 1;
        }

        .pickup-main {
            order: 1;
        }

        .pickup-summary {
            order: 2;
            position: static;
        }
    }

    @media (max-width: 720px) {
        .pickup-page {
            padding: 16px;
        }

        .pickup-hero,
        .pickup-form {
            padding: 18px;
        }

        .pickup-hero {
            flex-direction: column;
        }

        .pickup-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="pickup-page">
    <div class="pickup-shell">
        <div class="pickup-hero">
            <div class="pickup-hero-copy">
                <small>Kenya latest juu kali tech platform</small>
                <h2>Mowing Wash</h2>
                <p>Schedule your pickup, delivery, and logistics details.</p>
            </div>

            <div class="pickup-steps" aria-label="Booking progress">
                <span class="pickup-step done">✓</span>
                <span class="pickup-step-line"></span>
                <span class="pickup-step done">✓</span>
                <span class="pickup-step-line"></span>
                <span class="pickup-step active">3</span>
                <span class="pickup-step-line"></span>
                <span class="pickup-step">4</span>
            </div>
        </div>

        <form method="POST" action="{{ route('customer.save-pickup-details', $order->id) }}" class="pickup-form">
            @csrf

            <div class="pickup-main">
                <div class="pickup-section-bar">
                    <h3>3 Schedule & Logistics</h3>
                    <span>Step 3 of 4</span>
                </div>

                @if (session('success'))
                    <div class="pickup-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="pickup-errors">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="pickup-grid">
                    <div class="pickup-field">
                        <label for="pickup_date">Preferred Pick-up Slots</label>
                        <input
                            id="pickup_date"
                            type="date"
                            name="pickup_date"
                            value="{{ $savedPickupDate }}"
                            required>
                    </div>

                    <div class="pickup-field">
                        <label for="return_date">Est. Delivery Return Date</label>
                        <input
                            id="return_date"
                            type="date"
                            name="return_date"
                            value="{{ $savedReturnDate }}">
                    </div>

                    <div class="pickup-field">
                        <label for="pickup_time">Time Range</label>
                        <select id="pickup_time" name="pickup_time" required>
                            <option value="">Choose a time slot</option>
                            @foreach (['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'] as $slot)
                                <option value="{{ $slot }}" {{ $savedPickupTime === $slot ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromFormat('H:i', $slot)->format('h:i A') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="pickup-field">
                        <label for="delivery_option">Delivery Mode</label>
                        <select id="delivery_option" name="delivery_option">
                            <option value="Pickup & Return" {{ $savedDeliveryOption === 'Pickup & Return' ? 'selected' : '' }}>Pickup & Return</option>
                            <option value="Pickup Only" {{ $savedDeliveryOption === 'Pickup Only' ? 'selected' : '' }}>Pickup Only</option>
                            <option value="Drop Off Myself" {{ $savedDeliveryOption === 'Drop Off Myself' ? 'selected' : '' }}>Drop Off Myself</option>
                        </select>
                    </div>

                    <div class="pickup-field full">
                        <label for="collection_address">Addresses & Location Coordinates</label>
                        <textarea
                            id="collection_address"
                            name="collection_address"
                            placeholder="Collection address"
                            required>{{ old('collection_address', $order->collection_address) }}</textarea>
                    </div>

                    <div class="pickup-field">
                        <label for="return_address">Return Dropoff Address</label>
                        <input
                            id="return_address"
                            type="text"
                            name="return_address"
                            value="{{ $savedReturnAddress }}"
                            placeholder="Return address"
                            required>
                    </div>

                    <div class="pickup-field">
                        <label for="phone_number">Operational Phone Number</label>
                        <input
                            id="phone_number"
                            type="text"
                            name="phone_number"
                            value="{{ $savedPhone }}"
                            placeholder="e.g. 0712345678"
                            required>
                    </div>
                </div>

                <label class="pickup-note">
                    <input type="checkbox" name="policy_acknowledged" value="1" required>
                    <span>Secure use for SSL encrypted. I agree with platform data usage and terms.</span>
                </label>
            </div>

            <aside class="pickup-summary">
                <h4>INVOICE SUMMARY</h4>

                <div class="summary-block">
                    <span class="summary-label">Service Class</span>
                    <span class="summary-value">{{ $order->service_type ?: 'Wash & Fold' }}</span>
                </div>

                <div class="summary-block">
                    <span class="summary-label">Provider Selected</span>
                    <span class="summary-value">{{ $order->vendor->name }}</span>
                </div>

                <div class="summary-block">
                    <span class="summary-label">Quantities</span>
                    <span class="summary-value">{{ number_format($weight) }} kg</span>
                </div>

                <div class="summary-block">
                    <span class="summary-label">Unit Pricing</span>
                    <span class="summary-value">KSh {{ number_format($unitPrice, $unitPrice == floor($unitPrice) ? 0 : 2) }}/unit</span>
                </div>

                <hr class="summary-divider">

                <div class="summary-block">
                    <span class="summary-label">Service Charge</span>
                    <span class="summary-value">KSh {{ number_format($serviceCharge) }}</span>
                </div>

                <div class="summary-block">
                    <span class="summary-label">Logistics Rider</span>
                    <span class="summary-value">KSh {{ number_format($riderFee) }}</span>
                </div>

                <div class="summary-total">
                    <span>Grand Total:</span>
                    <span>KSh {{ number_format($total) }}</span>
                </div>

                <button type="submit" class="pickup-submit">Save & Continue to Next Step</button>
                <a href="{{ route('customer.dashboard') }}" class="pickup-cancel">Cancel Order</a>
            </aside>
        </form>
    </div>
</div>
@endsection