<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Category List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $categories = Category::latest()->get();

        return view('categories.index', compact('categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | Add Category Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('categories.add-category-form');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Category
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'short_description' => 'nullable|string',

            'description' => 'nullable|string',

            'status' => 'nullable|in:active,inactive',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);


        /*
        |--------------------------------------------------------------------------
        | Category Image
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time()
                . '_'
                . uniqid()
                . '.'
                . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/categories');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image->move($uploadPath, $imageName);

            $imagePath = 'uploads/categories/' . $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Category
        |--------------------------------------------------------------------------
        */

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status ?? 'active',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category added successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | View Category
    |--------------------------------------------------------------------------
    */

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Category Form
    |--------------------------------------------------------------------------
    */

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }


    /*
    |--------------------------------------------------------------------------
    | Update Category
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'short_description' => 'nullable|string',

            'description' => 'nullable|string',

            'status' => 'nullable|in:active,inactive',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate New Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);


        /*
        |--------------------------------------------------------------------------
        | Keep Existing Image
        |--------------------------------------------------------------------------
        */

        $imagePath = $category->image;


        /*
        |--------------------------------------------------------------------------
        | Upload New Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            /*
            |--------------------------------------------------------------------------
            | Delete Old Image
            |--------------------------------------------------------------------------
            */

            if ($category->image) {

                $oldImage = public_path($category->image);

                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }


            /*
            |--------------------------------------------------------------------------
            | New Image Upload
            |--------------------------------------------------------------------------
            */

            $image = $request->file('image');

            $imageName = time()
                . '_'
                . uniqid()
                . '.'
                . $image->getClientOriginalExtension();

            $uploadPath = public_path('uploads/categories');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image->move($uploadPath, $imageName);

            $imagePath = 'uploads/categories/' . $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Category
        |--------------------------------------------------------------------------
        */

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status ?? 'active',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Category
    |--------------------------------------------------------------------------
    */

    public function destroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Category Image From Public Folder
        |--------------------------------------------------------------------------
        */

        if ($category->image) {

            $imageFile = public_path($category->image);

            if (file_exists($imageFile)) {
                unlink($imageFile);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Category
        |--------------------------------------------------------------------------
        */

        $category->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}