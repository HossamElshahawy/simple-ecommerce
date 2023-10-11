@extends('layout.master')

@section('content')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Cart</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->
@include('alerts')
<!-- cart -->
<div class="cart-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead class="cart-table-head">
                        <tr class="table-head-row">
                            <th class="product-remove"></th>
                            <th class="product-image">Product Image</th>
                            <th class="product-name">Name</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-total">Total</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($items as $item)
                        <tr class="table-body-row">
                            <td class="product-remove">
                                <button class="remove-item" data-id="{{ $item->id }}">X</button>
                            </td>
                            <td class="product-image"><a href="{{route('product.show',$item->associatedModel->slug)}}"><img src="{{$item->associatedModel->image}}" alt=""></a> </td>
                            <td class="product-name"><a href="{{route('product.show',$item->associatedModel->slug)}}">{{$item->name}}</td>
                            <td class="product-price">${{$item->price}}</td>
                            <td class="product-quantity">
                                <input type="number"  name="quantity" min="1" max="{{$item->associatedModel->quantity}}" data-id="{{ $item->id }}" value="{{ $item->quantity }}">
                            </td>
                            <td class="product-total">{{$item->quantity}}</td>

                        </tr>
                        @endforeach
                        <div id="message-container" class="alert alert-success">
                            <!-- The success message will be displayed here -->
                        </div>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="total-section">
                    <table class="total-table">
                        <thead class="total-table-head">
                        <tr class="table-total-row">
                            <th>Total</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="total-data">
                            <td><strong>Subtotal: </strong></td>
                            <td>${{Cart::getSubTotal()}}</td>

                        </tr>
                        <tr class="total-data">
                            @if(session()->has('coupon'))
                            <td><strong>Discount ({{session()->get('coupon')['name']}})</strong>
                            <form action="{{route('coupon.delete')}}" method="post" style="display:inline">
                            @csrf
                                @method('delete')
                                <button type="submit" style="font-size:14px">Remove</button>
                            </form>
                            </td>

                            <td>$-{{session()->get('coupon')['discount']}}</td>

                        </tr>
                        <tr class="total-data">
                            <td><strong>new SubTotal: </strong></td>
                            <td>${{$newSubtotal}}</td>
                        </tr>
                        <tr class="total-data">
                            <td><strong>new tax: </strong></td>
                            <td>${{$newTax}}</td>
                        </tr>
                        <tr class="total-data">
                            <td><strong>new total: </strong></td>
                            <td>${{$newTotal}}</td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="cart-buttons">

                        <a href="{{route('checkout.index')}}" class="boxed-btn black">Check Out</a>
                    </div>
                </div>
                @if(! session()->has('coupon'))
                <div class="coupon-section">
                    <h3>Apply Coupon</h3>
                    <div class="coupon-form-wrap">
                        <form action="{{route('coupon.store')}}" method="post">
                            @csrf
                            <p><input type="text" placeholder="Coupon" name="coupon_code" id="coupon_code"></p>
                            <p><input type="submit" value="Apply"></p>
                        </form>
                    </div>
                </div>
                    @endif
            </div>
        </div>
    </div>
</div>


<!-- end cart -->

<script>
    // Add an event listener to handle removal of items
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-item')) {
            // Get the rowId from the data-id attribute
            const rowId = event.target.getAttribute('data-id');

            // Send an AJAX request to remove the item from the cart
            fetch('/cart/remove/' + rowId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Use the Laravel CSRF token
                },
            })
                .then(response => response.json())
                .then(data => {
                    // Update the cart display (e.g., remove the row)
                    if (data.success) {
                        // Find and remove the table row with the matching data-id
                        const rowToRemove = event.target.closest('tr');
                        const messageContainer = document.getElementById('message-container');
                        messageContainer.style.display = 'block';
                        if (rowToRemove) {
                            rowToRemove.remove();
                        }
                        if (messageContainer) {
                            messageContainer.textContent = data.message;
                             // Show the container

                        }
                    } else {
                        alert('Error removing item from cart.');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>

<script>
    // Add an event listener to handle quantity changes
    document.addEventListener('change', function (event) {
        if (event.target.getAttribute('name') === 'quantity') {
            const input = event.target;
            const rowId = input.getAttribute('data-id');
            const newQuantity = parseInt(input.value);

            // Send an AJAX request to update the cart item quantity
            fetch('/cart/update/' + rowId, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Use the Laravel CSRF token
                },
                body: JSON.stringify({ quantity: newQuantity }),
            })
                .then(response => response.json())
                .then(data => {
                    // Update the cart total for the corresponding item
                    // Inside the success callback of your AJAX request
                    if (data.success) {
                        const totalCell = input.closest('.table-body-row').querySelector('.product-total');
                        window.location.href = '{{route('cart')}}'

                        if (totalCell) {
                            totalCell.textContent = data.cart[0].subtotal; // Update with the new subtotal
                        }

                        // Update the item quantity in the same row
                        const quantityCell = input.closest('.table-body-row').querySelector('.product-quantity');
                        if (quantityCell) {
                            quantityCell.textContent = newQuantity;
                        }
                    } else {
                        alert('Error updating quantity.');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>


@endsection
