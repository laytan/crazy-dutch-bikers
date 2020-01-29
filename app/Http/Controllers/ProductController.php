<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
use Storage;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:super-admin|admin')->except(['index', 'show']);
    }

    /**
     * Show all products
     */
    public function index(Request $request) {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show a creation form
     */
    public function create() {
        return view('products.create');
    }

    /**
     * Store new product in database
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'price'           => 'required|integer',
            'product_picture' => 'required|image',
        ]);

        $picture = $request->file('product_picture')->store('product-pictures', ['disk' => 'public']);

        $product                  = new Product;
        $product->title           = $validatedData['title'];
        $product->description     = $validatedData['description'];
        $product->price           = $validatedData['price'];
        $product->product_picture = $picture;
        $product->updated_by      = Auth::user()->id;

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product aangemaakt');
    }

    public function edit(Request $request, $product) {
        $product = Product::findOrFail($product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $product) {
        $validatedData = $request->validate([
            'title'           => 'nullable|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'nullable|integer',
            'product_picture' => 'nullable|image',
        ]);

        $product = Product::findOrFail($product);

        if($validatedData['title'] !== null) {
            $product->title = $validatedData['title'];
        }

        if($validatedData['description'] !== null) {
            $product->description = $validatedData['description'];
        }

        if($validatedData['price'] !== null) {
            $product->price = $validatedData['price'];
        }

        if(isset($validatedData['product_picture']) && $validatedData['product_picture'] !== null) {
            // Store picture
            $picture = $request->file('product_picture')->store('product-pictures', ['disk' => 'public']);
            // Remove old picture
            if($product->product_picture !== null) {
                Storage::disk('public')->delete($product->product_picture);
            }
            // Update path
            $product->product_picture = $picture;
        }

        $product->save();
        return redirect()->route('products.index')->with('success', 'Product bewerkt');
    }

    public function destroy(Request $request, $product) {
        $product = Product::findOrFail($product);

        // Remove picture
        if($product->product_picture !== null) {
            Storage::disk('public')->delete($product->product_picture);
        }

        $product->delete();
        return back()->with('success', 'Product verwijderd');
    }
}