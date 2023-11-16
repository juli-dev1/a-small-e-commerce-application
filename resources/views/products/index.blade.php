@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3>Best Sellers</h3>
                        <a class="btn btn-success" href="{{ route('cart') }}">Cart</a>
                    </div>
                </div>
                <section style="background-color: #eee;">
                    <div class="container py-5">
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                                <div class="card mb-5">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/5.webp" class="card-img-top" alt="Laptop" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <p class="small"><a href="#!" class="text-muted">Laptops</a></p>
                                            <p class="small text-danger"><s>$1099</s></p>
                                        </div>

                                        <div class="d-flex justify-content-between mb-3">
                                            <h5 class="mb-0">{{ $product->title }}</h5>
                                            <h5 class="text-dark mb-0">${{ $product->price }}</h5>
                                        </div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="text-muted mb-0">Available: <span class="fw-bold">{{ $product->quantity }}</span></p>
                        
                                        </div>
                                        <div class="btn w-100 px-4 mx-auto">
                                        @if ($product->quantity > 0)
                                            <a href="{{ route('add.to.cart', $product->id) }}" class="btn btn-dark btn-lg w-100" role="button">Buy Now</a>
                                        @else
                                            <div  class="btn btn-secondary btn-lg w-100" role="button">Out Of Stock</div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>






@endsection