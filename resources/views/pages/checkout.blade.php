@extends('layout.master')
@section('css')

    <script src="https://js.stripe.com/v3/"></script>

@endsection
@section('content')
    @include('alerts')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Check Out Product</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="checkout-accordion-wrap">
                    <div class="accordion" id="accordionExample">
{{--                        <div class="card single-accordion">--}}
{{--                            <div class="card-header" id="headingOne">--}}
{{--                                <h5 class="mb-0">--}}
{{--                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
{{--                                        Billing Address--}}
{{--                                    </button>--}}
{{--                                </h5>--}}
{{--                            </div>--}}

{{--                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="billing-address-form">--}}
{{--                                        <form action="index.html">--}}
{{--                                            <p><input type="text" placeholder="Name"></p>--}}
{{--                                            <p><input type="email" placeholder="Email"></p>--}}
{{--                                            <p><input type="text" placeholder="Address"></p>--}}
{{--                                            <p><input type="tel" placeholder="Phone"></p>--}}
{{--                                            <p><textarea name="bill" id="bill" cols="30" rows="10" placeholder="Say Something"></textarea></p>--}}
{{--                                        </form>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card single-accordion">--}}
{{--                            <div class="card-header" id="headingTwo">--}}
{{--                                <h5 class="mb-0">--}}
{{--                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">--}}
{{--                                        Shipping Address--}}
{{--                                    </button>--}}
{{--                                </h5>--}}
{{--                            </div>--}}
{{--                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="shipping-address-form">--}}
{{--                                        <p>Your shipping address form is here.</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="card single-accordion">
                            <div class="card-header" id="headingThree">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Card Details
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="card-details">
                                        <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name_on_card">Name on Card</label>
                                                <input type="text" class="form-control" id="name_on_card" name="name" value="{{old('name')}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_on_card">email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_on_card">phone</label>
                                                <input type="number" class="form-control" id="phone" name="phone" value="{{old('phone')}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_on_card">address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_on_card">city</label>
                                                <input type="text" class="form-control" id="city" name="city" value="{{old('city')}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_on_card">province</label>
                                                <input type="text" class="form-control" id="province" name="province" value="{{old('province')}}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_on_card">postalcode</label>
                                                <input type="number" class="form-control" id="postalcode" name="postalcode" value="{{old('postalcode')}}" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="card-element">
                                                    Credit or debit card
                                                </label>
                                                <div id="card-element">
                                                    <!-- a Stripe Element will be inserted here. -->
                                                </div>

                                                <!-- Used to display form errors -->
                                                <div id="card-errors" role="alert"></div>
                                            </div>
                                            <div class="spacer"></div>

                                            <button type="submit" id="complete-order" class="button-primary full-width">Complete Order</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-details-wrap">
{{--                    <table class="order-details">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th>Your order Details</th>--}}
{{--                            <th></th>--}}
{{--                            <th></th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody class="order-details-body">--}}


{{--                            <tr>--}}
{{--                            <td>Product</td>--}}
{{--                            <td>quantity</td>--}}
{{--                                <td>Total</td>--}}


{{--                            </tr>--}}
{{--                            @foreach(\Darryldecode\Cart\Facades\CartFacade::getContent() as $item)--}}
{{--                        <tr>--}}
{{--                            <td>{{$item->name}}</td>--}}
{{--                            <td>{{$item->quantity}}</td>--}}
{{--                            <td>{{$item->price * $item->quantity}}</td>--}}


{{--                        </tr>--}}
{{--                        @endforeach--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                    <form action="{{ route('process.payment') }}" method="POST" id="payment-form">--}}
{{--                        @csrf--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="card-element">--}}
{{--                                Credit or debit card--}}
{{--                            </label>--}}
{{--                            <div id="card-element">--}}
{{--                                <!-- A Stripe Element will be inserted here. -->--}}
{{--                            </div>--}}
{{--                            <!-- Used to display form errors. -->--}}
{{--                            <div id="card-errors" role="alert"></div>--}}
{{--                        </div>--}}
{{--                        <input type="hidden" name="amount" value="{{ \Darryldecode\Cart\Facades\CartFacade::getSubTotal()}}">--}}
{{--                        <button type="submit">Submit Payment</button>--}}
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end check out section -->
@endsection

@section('script')
    <script>
        (function(){
            // Create a Stripe client
            var stripe = Stripe('pk_test_51LfoaFBty4XhX3XqaiOQsPP8btdzXxy9UlRgJNo8TwRu7AyziytJctA2GFdghZNRaUQDJchfaB3ZH5YKcTboRIEe00YKEzIWjk');

            // Create an instance of Elements
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });

            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                // Disable the submit button to prevent repeated clicks
                document.getElementById('complete-order').disabled = true;

                var options = {
                    name: document.getElementById('name_on_card').value,
                    address_line1: document.getElementById('address').value,
                    address_city: document.getElementById('city').value,
                    address_state: document.getElementById('province').value,
                    address_zip: document.getElementById('postalcode').value,
                    email: document.getElementById('email').value,
                    phone: document.getElementById('phone').value,
                }

                stripe.createToken(card, options).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;

                        // Enable the submit button
                        document.getElementById('complete-order').disabled = false;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            });

        // -------------

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }


        })();
    </script>


@endsection
