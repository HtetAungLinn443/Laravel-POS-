<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // product list page
    function list() {
        $pizzas = Product::select('products.*', 'categories.name as category_name')
            ->when(request('searchMainData'), function ($query) {
                $query->where('products.name', 'like', '%' . request('searchMainData') . '%');
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.created_at', 'desc')
            ->paginate(3);
        $pizzas->appends(request()->all());
        return view('admin.product.pizzaList', compact('pizzas'));
    }

    // direct pizza Create page
    public function createPage()
    {
        $categories = Category::select('id', 'name')->get();

        return view('admin.product.create', compact('categories'));
    }

    // create product
    public function create(Request $request)
    {
        $this->productValidationCheck($request, 'create');
        $data = $this->requestProductInfo($request);

        $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public', $fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('product#list');

    }

    // delete product
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Product Delete Success...']);
    }

    // Edit Product Page
    public function editPage($id)
    {
        $pizza = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        return view('admin.product.edit', compact('pizza'));
    }

    // Update Page
    public function updatePage($id)
    {
        $pizza = Product::where('id', $id)->first();
        $category = Category::get();
        return view('admin.product.update', compact('pizza', 'category'));
    }

    // Product Update
    public function update(Request $request)
    {
        $this->productValidationCheck($request, 'update');
        $data = $this->requestProductInfo($request);

        if ($request->hasFile('pizzaImage')) {
            $oldImageName = Product::where('id', $request->pizzaId)->first();
            $oldImageName = $oldImageName->image;

            if ($oldImageName != null) {
                Storage::delete('public' . $oldImageName);
            }

            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public', $fileName);
            $date['image'] = $fileName;
        }

        Product::where('id', $request->pizzaId)->update($data);

        return redirect()->route('product#list');
    }

    //request product info
    private function requestProductInfo($request)
    {
        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'waiting_time' => $request->pizzaWaitingTime,
            'price' => $request->pizzaPrice,
        ];
    }

    // Product Validation Check
    private function productValidationCheck($request, $action)
    {
        $validationRules = [
            'pizzaName' => 'required|min:5|unique:products,name,' . $request->pizzaId,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required|min:10',
            'pizzaWaitingTime' => 'required',
            'pizzaPrice' => 'required',
        ];

        $validationRules['pizzaImage'] = $action == 'create' ? 'required|mimes:jpg,png,jpeg,webp' : 'mimes:jpg,png,jpeg,webp';
        Validator::make($request->all(), $validationRules)->validate();
    }

}