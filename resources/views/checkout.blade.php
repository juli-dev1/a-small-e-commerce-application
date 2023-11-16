@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Checkout Page</h1>
    <div class="row mt-5">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3 sticky-top">
                @if(session('cart'))
                @foreach(session('cart') as $id => $details)

                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{ $details['title'] }}</h6>
                        <small class="text-muted">Quantity:{{ $details['quantity'] }}</small>
                    </div>
                    <span class="text-muted">{{ $details['price'] }}</span>
                </li>
                @endforeach
                @endif

                <li id="coupon-section" class="list-group-item d-flex justify-content-between bg-light" style="display:none !important">
                    <div class="text-success">
                        <h6 class="my-0">Promo code</h6>
                        <small id="coupon-name">EXAMPLECODE</small>
                    </div>
                    <span id="coupon-price" class="text-success">-$5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong id="total-price">${{ $totalPrice }}</strong>
                </li>
            </ul>
            <form id="coupon-form" action="{{ route('apply-coupon') }}" method="POST" role="form" class="card p-2">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" name="coupon" placeholder="Promo code">
                    <div class="input-group-append">
                        <button id="coupon-form-btn" type="submit" class="btn btn-secondary">Apply Coupon</button>
                    </div>
                </div>
            </form>
            <div>
                <p id="coupon-error" class="text-danger"></p>
            </div>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" action="{{ route('checkout.place.order') }}" method="POST" role="form">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="{{ Auth::user()->name }}" placeholder="Username" required="">
                        <div class="invalid-feedback" style="width: 100%;"> Your username is required. </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" value="{{ Auth::user()->email }}">
                        <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" value="{{ Auth::user()->userProfile->address ?? ''}}" placeholder="1234 Main St" required="">
                    <div class="invalid-feedback"> Please enter your shipping address. </div>
                </div>
                <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" name="address2" id="address2" value="{{ Auth::user()->userProfile->address2 ?? ''}}" placeholder="Apartment or suite">
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" name="country" id="country" value="{{ Auth::user()->userProfile->country ?? ''}}" placeholder="Country" required="">
                        <div class="invalid-feedback"> Please select a valid country. </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" id="city" value="{{ Auth::user()->userProfile->city ?? ''}}" placeholder="City" required="">
                        <div class="invalid-feedback"> Please provide a valid City. </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="postcode">Postcode</label>
                        <input type="text" class="form-control" name="postcode" id="postcode" value="{{ Auth::user()->userProfile->postcode ?? ''}}" placeholder="" required="">
                        <div class="invalid-feedback"> Postcode code required. </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="mobile">Mobile</label>
                        <input type="text" class="form-control" name="mobile" id="mobile" value="{{ Auth::user()->userProfile->mobile ?? ''}}" placeholder="" required="">
                        <div class="invalid-feedback"> Mobile code required. </div>
                    </div>
                </div>
                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                </div>
                <hr class="mb-4">
                <h4 class="mb-3">Payment</h4>
                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked="" required="">
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required="">
                        <label class="custom-control-label" for="paypal">PayPal</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="">
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback"> Name on card is required </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="">
                        <div class="invalid-feedback"> Credit card number is required </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="">
                        <div class="invalid-feedback"> Expiration date required </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="">
                        <div class="invalid-feedback"> Security code required </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#coupon-form').submit(function(event) {
            event.preventDefault();

            $('#coupon-form-btn').attr("disabled", true);
            $("#coupon-form-btn").html('Apply Coupon <div id="spinner" class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>');
            $.ajax({
                type: "POST",
                url: "{{ route('apply-coupon') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    coupon: $('input[name="coupon"]').val()
                },
                success: function(response) {
                    console.log(response);
                    if(response.discountPrice){
                        $("#total-price").text(`$${response.totalPrice}`);
                        $("#coupon-name").text(response.discountName);
                        $("#coupon-price").text(`-$${response.discountPrice}`);
                        $('#coupon-section').show();
                        $("#coupon-error").hide();
                    }

                    if(response.message){
                        $("#coupon-error").text(response.message);
                    }
                },
                error: function(response) {
                    console.log(response.responseJSON.message);
                    $("#coupon-error").text(response.responseJSON.message);
                },
                complete: function() {
                    $('#coupon-form-btn').attr("disabled", false);
                    $("#spinner").remove();
                }
            });
        });
    });
</script>
@endsection