@extends('layouts.site-layout')

@section('title', 'Order Confirmation | Food Website')

@section('content')

<style>
    .food-order-success {
        padding: 75px 15px;
        background: #f7f8fc;
        min-height: 75vh;
    }

    .food-order-success * {
        box-sizing: border-box;
    }

    .food-success-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .food-success-card {
        background: #ffffff;
        border-radius: 22px;
        padding: 45px 40px;
        box-shadow: 0 12px 45px rgba(7, 27, 44, 0.07);
        border: 1px solid #edf0f5;
    }

    .food-success-header {
        text-align: center;
        padding-bottom: 30px;
        border-bottom: 1px solid #edf0f5;
    }

    .food-success-icon {
        width: 86px;
        height: 86px;
        margin: 0 auto 22px;
        border-radius: 50%;
        background: #e7f9ee;
        color: #1b9c59;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 43px;
        font-weight: 700;
        box-shadow: 0 0 0 9px #f3fcf6;
    }

    .food-success-header h1 {
        color: #071b2c;
        font-size: 34px;
        font-weight: 800;
        line-height: 1.3;
        margin: 0 0 12px;
    }

    .food-success-header p {
        color: #697586;
        font-size: 15px;
        line-height: 1.7;
        margin: 0;
    }

    .food-order-number {
        margin-top: 28px;
        padding: 18px 20px;
        background: #fff8f0;
        border: 1px dashed #ffb66d;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        text-align: left;
    }

    .food-order-number small {
        display: block;
        color: #7c8795;
        font-size: 12px;
        margin-bottom: 6px;
    }

    .food-order-number strong {
        display: block;
        color: #071b2c;
        font-size: 17px;
        font-weight: 800;
        word-break: break-word;
    }

    .food-copy-btn {
        flex-shrink: 0;
        border: 1px solid #ff8c1a;
        background: #fff;
        color: #e87508;
        border-radius: 8px;
        padding: 9px 13px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: .25s;
    }

    .food-copy-btn:hover {
        background: #ff8c1a;
        color: #fff;
    }

    .food-order-summary {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin: 28px 0 35px;
    }

    .food-summary-box {
        padding: 22px;
        background: #f8fafc;
        border: 1px solid #edf0f5;
        border-radius: 14px;
    }

    .food-summary-box span {
        display: block;
        color: #788494;
        font-size: 13px;
        margin-bottom: 9px;
    }

    .food-summary-box strong {
        display: block;
        color: #071b2c;
        font-size: 21px;
        font-weight: 800;
    }

    .food-summary-box .food-payment-status {
        color: #b56a0a;
        font-size: 16px;
    }

    .food-section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .food-section-heading h3 {
        margin: 0;
        color: #071b2c;
        font-size: 21px;
        font-weight: 800;
    }

    .food-items-count {
        color: #737f8f;
        font-size: 13px;
    }

    .food-ordered-items {
        border: 1px solid #edf0f5;
        border-radius: 14px;
        overflow: hidden;
    }

    .food-ordered-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding: 20px;
        border-bottom: 1px solid #edf0f5;
    }

    .food-ordered-item:last-child {
        border-bottom: 0;
    }

    .food-item-info {
        min-width: 0;
    }

    .food-item-info h4 {
        color: #071b2c;
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 7px;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .food-item-info p {
        margin: 0;
        color: #7a8594;
        font-size: 13px;
    }

    .food-item-price {
        color: #071b2c;
        font-size: 16px;
        font-weight: 800;
        white-space: nowrap;
    }

    .food-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 18px;
        padding: 20px;
        background: #071b2c;
        color: #fff;
        border-radius: 13px;
    }

    .food-total-row span {
        font-size: 15px;
        font-weight: 500;
    }

    .food-total-row strong {
        color: #ffad55;
        font-size: 24px;
        font-weight: 800;
    }

    .food-success-actions {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 32px;
    }

    .food-action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 49px;
        padding: 13px 24px;
        border-radius: 9px;
        text-decoration: none !important;
        font-size: 14px;
        font-weight: 700;
        transition: .25s ease;
    }

    .food-btn-primary {
        background: #ff8c1a;
        color: #fff !important;
        border: 1px solid #ff8c1a;
    }

    .food-btn-primary:hover {
        background: #e87508;
        border-color: #e87508;
        color: #fff !important;
        transform: translateY(-2px);
    }

    .food-btn-secondary {
        background: #fff;
        color: #071b2c !important;
        border: 1px solid #dce2e9;
    }

    .food-btn-secondary:hover {
        border-color: #071b2c;
        background: #f8fafc;
        color: #071b2c !important;
    }

    .food-delivery-note {
        text-align: center;
        margin: 25px 0 0;
        color: #778292;
        font-size: 13px;
        line-height: 1.7;
    }

    @media (max-width: 600px) {
        .food-order-success {
            padding: 35px 12px;
        }

        .food-success-card {
            padding: 28px 18px;
            border-radius: 17px;
        }

        .food-success-icon {
            width: 72px;
            height: 72px;
            font-size: 36px;
        }

        .food-success-header h1 {
            font-size: 27px;
        }

        .food-order-number {
            padding: 15px 12px;
            gap: 8px;
        }

        .food-order-number strong {
            font-size: 13px;
        }

        .food-copy-btn {
            padding: 8px 10px;
            font-size: 12px;
        }

        .food-order-summary {
            gap: 10px;
            margin: 22px 0 28px;
        }

        .food-summary-box {
            padding: 15px 12px;
        }

        .food-summary-box strong {
            font-size: 17px;
        }

        .food-summary-box .food-payment-status {
            font-size: 14px;
        }

        .food-section-heading h3 {
            font-size: 18px;
        }

        .food-ordered-item {
            padding: 16px 12px;
            gap: 10px;
        }

        .food-item-info h4 {
            font-size: 14px;
        }

        .food-item-price {
            font-size: 14px;
        }

        .food-total-row {
            padding: 17px 14px;
        }

        .food-total-row strong {
            font-size: 20px;
        }

        .food-success-actions {
            flex-direction: column;
        }

        .food-action-btn {
            width: 100%;
        }
    }
</style>

<section class="food-order-success">
    <div class="food-success-container">
        <div class="food-success-card">

            {{-- SUCCESS HEADER --}}
            <div class="food-success-header">
                <div class="food-success-icon">
                    &#10003;
                </div>

                <h1>Thank You for Your Order!</h1>

                <p>
                    Your order has been placed successfully.
                    We're excited to prepare your delicious food.
                </p>

                {{-- ORDER NUMBER --}}
                <div class="food-order-number">
                    <div>
                        <small>YOUR ORDER NUMBER</small>
                        <strong id="foodOrderNumber">{{ $order->order_no }}</strong>
                    </div>

                    <button
                        type="button"
                        class="food-copy-btn"
                        id="foodCopyOrder"
                    >
                        Copy Order ID
                    </button>
                </div>
            </div>

            {{-- ORDER SUMMARY --}}
            <div class="food-order-summary">
                <div class="food-summary-box">
                    <span>Payment Method</span>
                    <strong class="food-payment-status">
                        Cash on Delivery
                    </strong>
                </div>

                <div class="food-summary-box">
                    <span>Order Total</span>
                    <strong>
                        ₹{{ number_format((float) $order->total, 2) }}
                    </strong>
                </div>
            </div>

            {{-- ORDERED PRODUCTS --}}
            <div class="food-section-heading">
                <h3>Ordered Products</h3>

                <span class="food-items-count">
                    {{ $order->items->sum('quantity') }}
                    {{ $order->items->sum('quantity') == 1 ? 'item' : 'items' }}
                </span>
            </div>

            <div class="food-ordered-items">
                @forelse ($order->items as $item)
                    <div class="food-ordered-item">
                        <div class="food-item-info">
                            <h4>{{ $item->product_name }}</h4>

                            <p>
                                Quantity: {{ $item->quantity }}
                                &nbsp;·&nbsp;
                                ₹{{ number_format((float) $item->price, 2) }} each
                            </p>
                        </div>

                        <div class="food-item-price">
                            ₹{{ number_format((float) $item->subtotal, 2) }}
                        </div>
                    </div>
                @empty
                    <div class="food-ordered-item">
                        <div class="food-item-info">
                            <h4>Order details</h4>
                            <p>Your order has been placed successfully.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- TOTAL --}}
            <div class="food-total-row">
                <span>Total Amount</span>

                <strong>
                    ₹{{ number_format((float) $order->total, 2) }}
                </strong>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="food-success-actions">
                <a
                    href="{{ route('site.products') }}"
                    class="food-action-btn food-btn-primary"
                >
                    Continue Shopping &rarr;
                </a>

                <a
                    href="{{ route('orders.my') }}"
                    class="food-action-btn food-btn-secondary"
                >
                    My Orders
                </a>
            </div>

            <p class="food-delivery-note">
                Thank you for choosing us! <br> {{-- ❤️ --}}
                Please keep your phone available for delivery updates.
            </p>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyButton = document.getElementById('foodCopyOrder');
        const orderNumber = document.getElementById('foodOrderNumber');

        if (!copyButton || !orderNumber) {
            return;
        }

        copyButton.addEventListener('click', async function () {
            const originalText = 'Copy Order ID';
            const text = orderNumber.textContent.trim();

            try {
                await navigator.clipboard.writeText(text);
                copyButton.textContent = 'Copied!';
            } catch (error) {
                const temporaryInput = document.createElement('textarea');
                temporaryInput.value = text;
                temporaryInput.style.position = 'fixed';
                temporaryInput.style.opacity = '0';

                document.body.appendChild(temporaryInput);
                temporaryInput.select();

                const copied = document.execCommand('copy');
                temporaryInput.remove();

                copyButton.textContent = copied ? 'Copied!' : 'Select Order ID';
            }

            setTimeout(function () {
                copyButton.textContent = originalText;
            }, 2000);
        });
    });
</script>

@endsection
