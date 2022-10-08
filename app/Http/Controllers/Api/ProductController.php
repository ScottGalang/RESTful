<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateproductRequest;
use App\Http\Controllers\Controller;
use App\Models\Product;

// v1 edited
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Filters\ProductQuery;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ProductQuery();
        $itemQuery = $filter->transform($request);

        if (count($itemQuery) == 0)
            return new ProductCollection(Product::all());
        else
            return new ProductCollection(Product::where($itemQuery)->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreproductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'required|max:191',
            'currency' => 'required|max:191',
            'price' => 'required|max:191',
            'brand' => 'required|max:191',
            'category' => 'required|max:191',
        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->currency = $request->currency;
        $product->price = $request->price;
        $product->brand = $request->brand;
        $product->category = $request->category;
        $product->image = $request->image;
        $product->save();
        return response()->json(['message' => 'product added', 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = new ProductResource(Product::findOrfail($id));
        return response()->json([
            $response
        ]);
    }

    public function search($title)
    {
        $result = Product::where('title', 'LIKE', '%'. $title. '%')->get();
        if(count($result)){
         return Response()->json($result);
        }
        else
        {
        return response()->json(['Result' => 'No Data not found'], 404);
      }
    }

    public function category($category)
    {
        $result = Product::where('category', '=', $category)->get();
        if(count($result)){
         return Response()->json($result);
        }
        else
        {
        return response()->json(['Result' => 'No Data not found'], 404);
      }
    }

    public function showCategories()
    {
        $response = Product::select('category')->distinct()->get();
        return response()->json(['Categories' => $response], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateproductRequest  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:191',
            'description' => 'required|max:191',
            'currency' => 'required|max:191',
            'price' => 'required|max:191',
            'brand' => 'required|max:191',
            'category' => 'required|max:191',
        ]);

        $product = Product::find($id);

        if($product) {
            $product->title = $request->title;
            $product->description = $request->description;
            $product->currency = $request->currency;
            $product->price = $request->price;
            $product->brand = $request->brand;
            $product->category = $request->category;
            $product->image = $request->image;
            $product->update();

            return response()->json(['message' => 'product updated', 200]);
        
        } else {
            return response()->json(['message' => 'failed to update', 404]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Product::destroy($id);
        return response()->json(['message' => 'product deleted', 200]);
    }
}
