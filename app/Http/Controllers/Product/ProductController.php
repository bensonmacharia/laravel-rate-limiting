<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            $products = Product::orderBy('created_at', 'desc')->get();
            return view('product.index', ['products' => $products]);
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
        
    }

    public function show(Product $product)
    {
        if(Auth::check())
        {
            return view('product.one', ['product' => $product]);
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    }

    public function store(Request $request)
    {
        if(Auth::check())
        {
            $request->validate([
                'name' => 'required|string',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
            ]);

            $product = new Product();
            $product->name = $request->name;
            $product->quantity = $request->quantity;
            $product->price = $request->price;
            $product->save();

            //return response()->json(['message' => 'Product created successfully', 'product' => $product]);
            $products = Product::orderBy('created_at', 'desc')->get();
            return view('auth.dashboard', ['products' => $products]);
        }
        
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    }
}
