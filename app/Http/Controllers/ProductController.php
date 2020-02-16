<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
use Storage;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use File;
use Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage')->except(['index', 'show', 'picture']);
    }

    /**
     * Show all products
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show a creation form
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store new product in database
     */
    public function store(CreateProductRequest $request)
    {
        $validatedData = $request->validated();

        $picture = $request->file('product_picture')->store('product-pictures', ['disk' => 'private']);

        $product                  = new Product;
        $product->title           = $validatedData['title'];
        $product->description     = $validatedData['description'];
        $product->price           = $validatedData['price'];
        $product->product_picture = $picture;
        $product->updated_by      = Auth::user()->id;

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product aangemaakt');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();
        
        if ($validatedData['title'] !== null) {
            $product->title = $validatedData['title'];
        }

        if ($validatedData['description'] !== null) {
            $product->description = $validatedData['description'];
        }

        if ($validatedData['price'] !== null) {
            $product->price = $validatedData['price'];
        }

        if (isset($validatedData['product_picture']) && $validatedData['product_picture'] !== null) {
            // Store picture
            $picture = $request->file('product_picture')->store('product-pictures', ['disk' => 'private']);
            // Remove old picture
            if ($product->product_picture !== null) {
                Storage::disk('private')->delete($product->product_picture);
            }
            // Update path
            $product->product_picture = $picture;
        }

        $product->save();
        return redirect()->route('products.index')->with('success', 'Product bewerkt');
    }

    public function destroy(Product $product)
    {
        // Remove picture
        if ($product->product_picture !== null) {
            Storage::disk('private')->delete($product->product_picture);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product verwijderd');
    }

    public function picture($product_picture)
    {
        $path = 'app/private/product-pictures/' . $product_picture;
        return file_response($path);
    }
}
