<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $products = Product::with([
            'category',
            'images'
        ])->latest()->get();

        return view('products.index', compact('products'));
    }


    /*
    |--------------------------------------------------------------------------
    | Add Product Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();

        $products = Product::orderBy('name')
            ->get();

        return view('products.add-product-form', compact(
            'categories',
            'products'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Store Product
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',

            'name' => 'required|string|max:255',

            'product_type' => 'required|in:single,combo',

            'combo_product_ids' => 'nullable|array',
            'combo_product_ids.*' => 'integer|exists:products,id',

            'short_description' => 'nullable|string',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'status' => 'nullable|in:Active,Inactive',

            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);


        /*
        |--------------------------------------------------------------------------
        | Combo Product IDs
        |--------------------------------------------------------------------------
        */

        $comboProductIds = null;

        if ($request->product_type === 'combo') {

            $comboProductIds = $request->combo_product_ids ?: null;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Product
        |--------------------------------------------------------------------------
        */

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'product_type' => $request->product_type,
            'combo_product_ids' => $comboProductIds,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status ?? 'Active',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Product Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            $uploadPath = public_path('uploads/products');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {

                $imageName = time()
                    . '_'
                    . uniqid()
                    . '.'
                    . $image->getClientOriginalExtension();

                $image->move($uploadPath, $imageName);

                $imagePath = 'uploads/products/' . $imageName;


                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'alt_text' => $request->name,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Product Details
    |--------------------------------------------------------------------------
    */

    public function show(Product $product)
    {
        $product->load([
            'category',
            'images'
        ]);

        return view('products.show', compact('product'));
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Product Form
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Active Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::where('status', 'active')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Products For Combo
        |--------------------------------------------------------------------------
        | Current product ko combo list se remove kar rahe hain.
        |--------------------------------------------------------------------------
        */

        $products = Product::where('id', '!=', $product->id)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Load Images
        |--------------------------------------------------------------------------
        */

        $product->load('images');


        return view('products.edit', compact(
            'product',
            'categories',
            'products'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',

            'name' => 'required|string|max:255',

            'product_type' => 'required|in:single,combo',

            'combo_product_ids' => 'nullable|array',
            'combo_product_ids.*' => 'integer|exists:products,id',

            'short_description' => 'nullable|string',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'status' => 'nullable|in:Active,Inactive',

            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);


        /*
        |--------------------------------------------------------------------------
        | Combo Product IDs
        |--------------------------------------------------------------------------
        */

        $comboProductIds = null;

        if ($request->product_type === 'combo') {

            $comboProductIds = $request->combo_product_ids ?: null;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'product_type' => $request->product_type,
            'combo_product_ids' => $comboProductIds,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'status' => $request->status ?? 'Active',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Add New Product Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            $uploadPath = public_path('uploads/products');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {

                $imageName = time()
                    . '_'
                    . uniqid()
                    . '.'
                    . $image->getClientOriginalExtension();

                $image->move($uploadPath, $imageName);

                $imagePath = 'uploads/products/' . $imageName;


                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'alt_text' => $request->name,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        /*
        |--------------------------------------------------------------------------
        | Load Product Images
        |--------------------------------------------------------------------------
        */

        $product->load('images');


        /*
        |--------------------------------------------------------------------------
        | Delete Images From Public Folder
        |--------------------------------------------------------------------------
        */

        foreach ($product->images as $image) {

            if ($image->image_path) {

                $imageFile = public_path($image->image_path);

                if (file_exists($imageFile)) {
                    unlink($imageFile);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Delete Product Image Record
            |--------------------------------------------------------------------------
            */

            $image->delete();
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Product
        |--------------------------------------------------------------------------
        */

        $product->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}