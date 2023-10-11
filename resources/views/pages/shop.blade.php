@extends('layout.master')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Shop</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- products -->
<div class="product-section mt-150 mb-150">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="product-filters">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        @foreach($categories as $category)
                            @if($category->status == 'active')
                            <li data-filter=".{{ strtolower($category->name) }}">{{ $category->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row product-lists">
            @foreach($categories as $category)

                    @foreach($category->products as $product)
                        <div class="col-lg-4 col-md-6 text-center {{ strtolower($category->name) }}">
                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="{{route('product.show',$product->slug)}}"><img src="{{$product->image}}" alt=""></a>
                                </div>
                                <h3>{{ $product->name }}</h3>
                                <p class="product-price"><span>Per Kg</span> {{ $product->presentPrice() }} </p>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

            @endforeach
        </div>



        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="pagination-wrap">
                    <ul>
                        <li><a href="#">Prev</a></li>
                        <li><a href="#">1</a></li>
                        <li><a class="active" href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end products -->

<script>
    $(document).ready(function () {
        // Initialize Isotope
        var $grid = $('.product-lists').isotope({
            itemSelector: '.single-product-item',
            layoutMode: 'fitRows'
        });

        // Filter items on button click
        $('.product-filters ul').on('click', 'li', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
            $('.product-filters ul li').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
@endsection
