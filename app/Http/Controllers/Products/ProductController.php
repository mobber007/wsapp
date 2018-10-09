<?php

namespace App\Http\Controllers\Products;

use App\Models\Product;
use App\Models\View;
use App\Http\Controllers\Controller;
use \App\Http\Requests\SearchProducts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use App\Jobs\ProcessProductView;

class ProductController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(SearchProducts $request)
  {
    return response()->json([
      'products' => Product::searchProducts($request)->paginate(12)
    ]);
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
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function get_similars($product)
  {
    switch (is_numeric($product)) {
      case true;
      $get_product = Product::where('id', '=', $product)->first();
      break;
      case false;
      $get_product = Product::where('slug', '=', $product)->first();
      break;
    }
    $similars = $get_product->similar($get_product);
    return response()->json([
      'similars' => $similars
    ]);

  }

  public function show($product)
  {
    switch (is_numeric($product)) {
      case true;
      $get_product = Product::where('id', '=', $product)->first();
      break;
      case false;
      $get_product = Product::where('slug', '=', $product)->first();
      break;
    }

    ProcessProductView::dispatch($get_product)->delay(now()->addMinutes(2));

    $images = $get_product->images;
    //$get_product->similars = $get_product->similar($get_product);
    return response()->json([
      'product' => $get_product
    ]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function edit(Product $product)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Product $product)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Product  $product
  * @return \Illuminate\Http\Response
  */
  public function destroy(Product $product)
  {
    //
  }
}
