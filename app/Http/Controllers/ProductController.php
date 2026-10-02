<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        ])
            ->latest()
            ->get();

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

        $products = Product::where('product_type', 'single')
            ->where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view(
            'products.add-product-form',
            compact('categories', 'products')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Store Product
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id'
            ],

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'product_type' => [
                'required',
                'in:single,combo'
            ],

            'combo_product_ids' => [
                'required_if:product_type,combo',
                'array',
                'min:1'
            ],

            'combo_product_ids.*' => [
                'integer',
                'distinct',
                'exists:products,id'
            ],

            'short_description' => [
                'nullable',
                'string'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'status' => [
                'nullable',
                'in:Active,Inactive'
            ],

            'images' => [
                'nullable',
                'array'
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

        ]);


        $slug = Str::slug($request->name);

        $comboProductIds = null;


        if ($request->product_type === 'combo') {

            $comboProductIds = $request->input(
                'combo_product_ids',
                []
            );

            $validProductCount = Product::whereIn(
                'id',
                $comboProductIds
            )
                ->where('product_type', 'single')
                ->where('status', 'Active')
                ->count();


            if (
                $validProductCount !==
                count($comboProductIds)
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'combo_product_ids' =>
                            'Please select valid active single products for the combo.'
                    ]);
            }
        }


        DB::transaction(function () use ($request, $slug, $comboProductIds) {

            $product = Product::create([

                'category_id' =>
                    $request->category_id,

                'name' =>
                    $request->name,

                'slug' =>
                    $slug,

                'product_type' =>
                    $request->product_type,

                'combo_product_ids' =>
                    $comboProductIds,

                'short_description' =>
                    $request->short_description,

                'description' =>
                    $request->description,

                'price' =>
                    $request->price,

                'status' =>
                    $request->status ?? 'Active',

            ]);


            if ($request->hasFile('images')) {

                $uploadPath =
                    public_path('uploads/products');


                if (!file_exists($uploadPath)) {

                    mkdir(
                        $uploadPath,
                        0755,
                        true
                    );
                }


                foreach (
                    $request->file('images')
                    as $image
                ) {

                    $imageName =
                        time()
                        . '_'
                        . uniqid()
                        . '.'
                        . $image->getClientOriginalExtension();


                    $image->move(
                        $uploadPath,
                        $imageName
                    );


                    ProductImage::create([

                        'product_id' =>
                            $product->id,

                        'image_path' =>
                            'uploads/products/'
                            . $imageName,

                        'alt_text' =>
                            $request->name,

                    ]);
                }
            }

        });


        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product added successfully.'
            );
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


        $comboProducts = collect();


        if (
            $product->product_type === 'combo' &&
            !empty($product->combo_product_ids)
        ) {

            $comboProducts = Product::whereIn(
                'id',
                $product->combo_product_ids
            )
                ->get();
        }


        return view(
            'products.show',
            compact(
                'product',
                'comboProducts'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Product Form
    |--------------------------------------------------------------------------
    */

    public function edit(Product $product)
    {
        $categories = Category::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Combo ke liye sirf Active Single Products
        |--------------------------------------------------------------------------
        | Current product ko exclude kiya gaya hai.
        |--------------------------------------------------------------------------
        */

        $products = Product::where(
            'id',
            '!=',
            $product->id
        )
            ->where(
                'product_type',
                'single'
            )
            ->where(
                'status',
                'Active'
            )
            ->orderBy('name')
            ->get();


        $product->load('images');


        return view(
            'products.edit',
            compact(
                'product',
                'categories',
                'products'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Product $product
    ) {

        $request->validate([

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id'
            ],

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'product_type' => [
                'required',
                'in:single,combo'
            ],

            'combo_product_ids' => [
                'required_if:product_type,combo',
                'array',
                'min:1'
            ],

            'combo_product_ids.*' => [
                'integer',
                'distinct',
                'exists:products,id'
            ],

            'short_description' => [
                'nullable',
                'string'
            ],

            'description' => [
                'nullable',
                'string'
            ],

            'price' => [
                'required',
                'numeric',
                'min:0'
            ],

            'status' => [
                'nullable',
                'in:Active,Inactive'
            ],

            'images' => [
                'nullable',
                'array'
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            /*
            |--------------------------------------------------------------------------
            | Existing Image Delete
            |--------------------------------------------------------------------------
            */

            'delete_images' => [
                'nullable',
                'array'
            ],

            'delete_images.*' => [
                'integer',
                'exists:product_images,id'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Combo Product IDs
        |--------------------------------------------------------------------------
        */

        $comboProductIds = null;


        if ($request->product_type === 'combo') {

            $comboProductIds = $request->input(
                'combo_product_ids',
                []
            );


            /*
            |--------------------------------------------------------------------------
            | Prevent Self Combo
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $product->id,
                    $comboProductIds
                )
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'combo_product_ids' =>
                            'A product cannot be included in its own combo.'
                    ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Verify Selected Products
            |--------------------------------------------------------------------------
            */

            $validProductCount = Product::whereIn(
                'id',
                $comboProductIds
            )
                ->where(
                    'product_type',
                    'single'
                )
                ->where(
                    'status',
                    'Active'
                )
                ->count();


            if (
                $validProductCount !==
                count($comboProductIds)
            ) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'combo_product_ids' =>
                            'Please select valid active single products for the combo.'
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Update Product
        |--------------------------------------------------------------------------
        */

        $product->update([

            'category_id' =>
                $request->category_id,

            'name' =>
                $request->name,

            'slug' =>
                Str::slug($request->name),

            'product_type' =>
                $request->product_type,

            'combo_product_ids' =>
                $comboProductIds,

            'short_description' =>
                $request->short_description,

            'description' =>
                $request->description,

            'price' =>
                $request->price,

            'status' =>
                $request->status ?? 'Active',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Delete Existing Images
        |--------------------------------------------------------------------------
        */

        if ($request->filled('delete_images')) {

            $deleteImages = $request->input(
                'delete_images',
                []
            );


            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            | Sirf isi product ki images delete hongi.
            |--------------------------------------------------------------------------
            */

            $imagesToDelete = ProductImage::whereIn(
                'id',
                $deleteImages
            )
                ->where(
                    'product_id',
                    $product->id
                )
                ->get();


            foreach ($imagesToDelete as $image) {

                /*
                |--------------------------------------------------------------------------
                | Delete Physical File
                |--------------------------------------------------------------------------
                */

                if ($image->image_path) {

                    $imageFile = public_path(
                        $image->image_path
                    );


                    if (file_exists($imageFile)) {

                        unlink($imageFile);
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Delete Database Record
                |--------------------------------------------------------------------------
                */

                $image->delete();
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Upload New Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('images')) {

            $uploadPath =
                public_path('uploads/products');


            if (!file_exists($uploadPath)) {

                mkdir(
                    $uploadPath,
                    0755,
                    true
                );
            }


            foreach (
                $request->file('images')
                as $image
            ) {

                $imageName =
                    time()
                    . '_'
                    . uniqid()
                    . '.'
                    . $image->getClientOriginalExtension();


                $image->move(
                    $uploadPath,
                    $imageName
                );


                ProductImage::create([

                    'product_id' =>
                        $product->id,

                    'image_path' =>
                        'uploads/products/'
                        . $imageName,

                    'alt_text' =>
                        $request->name,

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
            ->with(
                'success',
                'Product updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    public function destroy(Product $product)
    {
        $product->load('images');


        foreach (
            $product->images
            as $image
        ) {

            if ($image->image_path) {

                $imageFile =
                    public_path(
                        $image->image_path
                    );


                if (file_exists($imageFile)) {

                    unlink($imageFile);
                }
            }


            $image->delete();
        }


        $product->delete();


        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}

