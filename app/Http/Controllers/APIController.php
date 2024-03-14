<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors])->setStatusCode(422);
        }

        $user = User::updateOrCreate([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'api_token' => Str::random(60)
        ]);

        if ($user) {
			$message = array();
            $message['message'] = 'User registered successfully';
            $message['user'] = $user;

            return response()->json($message)->setStatusCode(201);
		} else {

			$message = array();
            $message['message'] = 'User failed to save';

            return response()->json($message)->setStatusCode(400);
		}

    }

    public function login(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $message = array();
            $user = User::where('email', $credentials['email'])->first();
            $message['message'] = 'User logged in successfully';
            $message['user'] = $user;

            return response()->json($message)->setStatusCode(200);
        } else {

			$message = array();
            $message['message'] = 'User failed to login';

            return response()->json($message)->setStatusCode(400);
		}

    }

    public function users(){
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json($users);

    }

    public function user($id){
        $user = User::where('id', $id)->first();
        return response()->json($user);

    }

    public function newProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => 'Validation failed', 'errors' => $errors])->setStatusCode(422);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();
        $products = Product::orderBy('created_at', 'desc')->get();
        if ($products) {
			$message = array();
            $message['message'] = 'Product added successfully';
            $message['product'] = $product;

            return response()->json($message)->setStatusCode(201);
		} else {

			$message = array();
            $message['message'] = 'Product failed to save';

            return response()->json($message)->setStatusCode(400);
		}

    }

    public function product($id){
        $product = Product::where('id', $id)->first();
        return response()->json($product);

    }
}
