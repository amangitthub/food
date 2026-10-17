@extends('layouts.site-layout')

@section('title', 'Order Confirmation | Food Website')

@section('content')
<style>
/* Uses your website variables (--theme, --theme3, --bg ...) with safe fallbacks */
.food-order-success{--g:var(--theme,#00813d);--gl:#2fb36b;--y:var(--theme3,#ffb936);--dark:var(--header,#212121);--txt:var(--text,#5c5c5b);--ln:var(--border,#d9d9d9);--cream:var(--bg,#f4f1ea);--soft:#e6f4ec;min-height:75vh;padding:75px 15px;background:radial-gradient(ellipse at 10% 0%,rgba(0,129,61,.1),transparent 40%),radial-gradient(ellipse at 95% 90%,rgba(255,185,54,.14),transparent 40%),var(--cream)}
.food-order-success *{box-sizing:border-box}
.food-success-container{max-width:850px;margin:0 auto}

/* ---------- Card ---------- */
.food-success-card{position:relative;overflow:hidden;padding:45px 40px;background:#fff;border-radius:24px;box-shadow:0 18px 50px rgba(33,33,33,.1);animation:foodRise .6s ease both}
.food-success-card::before{content:"";position:absolute;left:0;right:0;top:0;height:6px;background:linear-gradient(90deg,var(--g),var(--gl),var(--y))}
@keyframes foodRise{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}
@keyframes foodPop{0%{transform:scale(.4);opacity:0}70%{transform:scale(1.1)}100%{transform:scale(1);opacity:1}}
@keyframes foodRing{0%{box-shadow:0 0 0 0 rgba(0,129,61,.35)}100%{box-shadow:0 0 0 22px rgba(0,129,61,0)}}

/* ---------- Header ---------- */
.food-success-header{padding-bottom:30px;text-align:center;border-bottom:1px dashed var(--ln)}
.food-success-icon{width:88px;height:88px;margin:0 auto 22px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:linear-gradient(140deg,var(--gl),var(--g));color:#fff;font-size:42px;font-weight:700;box-shadow:0 10px 26px rgba(0,129,61,.3);animation:foodPop .6s .15s ease both,foodRing 2s 1s ease-out 2}
.food-success-header h1{margin:0 0 12px;color:var(--dark);font-size:clamp(26px,4vw,34px);font-weight:800;line-height:1.3}
.food-success-header p{margin:0;color:var(--txt);font-size:15px;line-height:1.7}

/* Order number */
.food-order-number{display:flex;align-items:center;justify-content:space-between;gap:15px;margin-top:28px;padding:18px 20px;text-align:left;background:#f7fbf8;border:2px dashed #9ccfb3;border-radius:16px}
.food-order-number small{display:block;margin-bottom:6px;color:var(--txt);font-size:12px;font-weight:700;letter-spacing:1px}
.food-order-number strong{display:block;color:var(--dark);font-size:18px;font-weight:800;word-break:break-word}
.food-copy-btn{flex-shrink:0;padding:10px 16px;background:#fff;border:2px solid var(--g);border-radius:10px;color:var(--g);font-size:13px;font-weight:700;cursor:pointer;transition:.25s}
.food-copy-btn:hover{background:var(--g);color:#fff}

/* ---------- Summary boxes ---------- */
.food-order-summary{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin:28px 0 34px}
.food-summary-box{padding:22px;background:var(--cream);border-radius:16px}
.food-summary-box span{display:block;margin-bottom:8px;color:var(--txt);font-size:13px}
.food-summary-box strong{display:block;color:var(--dark);font-size:21px;font-weight:800}
.food-summary-box .food-payment-status{color:var(--g);font-size:17px}

/* ---------- Ordered items ---------- */
.food-section-heading{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px}
.food-section-heading h3{margin:0;color:var(--dark);font-size:21px;font-weight:800}
.food-items-count{padding:4px 14px;background:var(--soft);border-radius:99px;color:var(--g);font-size:13px;font-weight:700}
.food-ordered-items{overflow:hidden;border:1px solid #ece8de;border-radius:16px}
.food-ordered-item{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:18px 20px;border-bottom:1px dashed var(--ln);transition:background .2s}
.food-ordered-item:hover{background:#fafdfb}
.food-ordered-item:last-child{border-bottom:0}
.food-item-info{min-width:0}
.food-item-info h4{margin:0 0 6px;color:var(--dark);font-size:15.5px;font-weight:700;line-height:1.5;overflow-wrap:anywhere}
.food-item-info p{margin:0;color:var(--txt);font-size:13px}
.food-item-price{color:var(--dark);font-size:16px;font-weight:800;white-space:nowrap}

/* Total */
.food-total-row{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-top:18px;padding:20px 22px;background:var(--g);border-bottom:4px solid var(--y);border-radius:16px;color:#fff;box-shadow:0 10px 24px rgba(0,129,61,.22)}
.food-total-row span{font-size:15px;font-weight:600}
.food-total-row strong{color:#fff;font-size:26px;font-weight:800}

/* ---------- Buttons ---------- */
.food-success-actions{display:flex;justify-content:center;flex-wrap:wrap;gap:14px;margin-top:32px}
.food-action-btn{display:inline-flex;align-items:center;justify-content:center;min-height:50px;padding:13px 26px;border-radius:12px;font-size:14px;font-weight:700;text-decoration:none!important;transition:.25s}
.food-btn-primary{background:var(--g);border:2px solid var(--g);color:#fff!important}
.food-btn-primary:hover{background:var(--dark);border-color:var(--dark);color:#fff!important;transform:translateY(-2px);box-shadow:0 10px 22px rgba(33,33,33,.2)}
.food-btn-secondary{background:#fff;border:2px solid var(--ln);color:var(--dark)!important}
.food-btn-secondary:hover{border-color:var(--g);color:var(--g)!important;transform:translateY(-2px)}
.food-delivery-note{margin:26px 0 0;text-align:center;color:var(--txt);font-size:13.5px;line-height:1.8}

@media(prefers-reduced-motion:reduce){.food-success-card,.food-success-icon{animation:none}}

/* ---------- Mobile ---------- */
@media(max-width:600px){
    .food-order-success{padding:35px 12px}
    .food-success-card{padding:30px 18px;border-radius:18px}
    .food-success-icon{width:72px;height:72px;font-size:34px}
    .food-order-number{padding:15px 12px;gap:8px}
    .food-order-number strong{font-size:14px}
    .food-copy-btn{padding:8px 10px;font-size:12px}
    .food-order-summary{gap:10px;margin:22px 0 28px}
    .food-summary-box{padding:15px 12px}
    .food-summary-box strong{font-size:17px}
    .food-summary-box .food-payment-status{font-size:14px}
    .food-section-heading h3{font-size:18px}
    .food-ordered-item{padding:15px 12px;gap:10px}
    .food-item-info h4{font-size:14px}
    .food-item-price{font-size:14px}
    .food-total-row{padding:17px 14px}
    .food-total-row strong{font-size:21px}
    .food-success-actions{flex-direction:column}
    .food-action-btn{width:100%}
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

                    <button type="button" class="food-copy-btn" id="foodCopyOrder">
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
                <a href="{{ route('site.products') }}" class="food-action-btn food-btn-primary">
                    Continue Shopping &rarr;
                </a>

                <a href="{{ route('orders.receipt.download', $order->order_no) }}"
                    class="food-action-btn food-btn-primary">
                    <i class="fas fa-file-pdf" style="margin-right:8px;"></i>
                    Download Receipt PDF
                </a>

                <a href="{{ route('orders.my') }}" class="food-action-btn food-btn-secondary">
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