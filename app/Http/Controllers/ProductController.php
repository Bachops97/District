<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index(Request $request)
    {
         $selectedCategory = $request->input('category');
         $productsQuery = ProductModel::query();

         if (!empty($selectedCategory)) {
             $productsQuery->whereHas('categories', function ($query) use ($selectedCategory) {
                 $query->where('categories.id', $selectedCategory);
             });
         }

         $products = $productsQuery->paginate(4);
         $categories = CategoryModel::all();

         return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }


    public function userProducts()
    {
        $user = auth()->user();
        $products = ProductModel::where('user_id', $user->id)
            ->paginate(4);

        return view('products.my-listing', compact('products'));
    }



    public function create()
    {
        $categories = CategoryModel::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantities' => 'required|integer|min:0',
        ]);


        $user = auth()->user();
        $product = new ProductModel($validatedData);
        $user->products()->save($product);
        $product->categories()->sync($request->input('category'));

        return redirect()->route('products')->with('success', 'Product created successfully.');
    }

    public function edit(ProductModel $product)
    {
        $categories = CategoryModel::all();
        return view('products.edit', compact('product','categories'));
    }

    public function update(Request $request, ProductModel $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantities' => 'required|integer|min:0',
        ]);

        $product->update($validatedData);

        $product->categories()->sync($request->input('category'));

        return redirect()->route('userProducts')->with('success', 'Product updated successfully.');
    }


    public function destroy(ProductModel $product)
    {
        $product->delete();
        return redirect()->route('userProducts')->with('success', 'Product deleted successfully.');
    }
}
