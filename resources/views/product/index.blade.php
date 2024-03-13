@extends('product.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Products</div>
            <div class="card-body">  
                <div class="mt-4">
                    <h4>Add Product</h4>
                    <form action="{{ route('product.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Available Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Unit Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </form>
                </div>
                <div class="mt-4">
                    <h4>Products</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>             
            </div>
        </div>
    </div>    
</div>
    
@endsection