@extends('product.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Product: {{ $product->name }}</div>
            <div class="card-body">  
                <div class="mt-4">
                    <h5>Details</h5>
                    <p>Name: {{ $product->name }} </p>
                    <p>Quantity: {{ $product->quantity }} </p>
                    <p>Price: {{ $product->price }} </p>
                </div>             
            </div>
        </div>
    </div>    
</div>
    
@endsection