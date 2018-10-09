<?php

namespace App\Http\Controllers\Favorites;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sites = Product::whereLikedBy(auth()->user()->id);

        return response()->json( [
            'favorites' => $sites->paginate(12),
            'status'  => 'Retrieved favorites',
            'success' => true
        ], 200 );
    }


    public function favorite(Product $product)
    {
        $product->likeBy();
        return response()->json( [
            'product' => $product,
            'favorited' => $product->isLikedBy(),
            'status'  => 'Produsul '.$product->external_id.' a fost adaugat la favorite',
            'success' => true
        ], 200 );
    }


    public function unfavorite(Product $product)
    {
        $product->unlikeBy();
        return response()->json( [
            'product' => $product,
            'favorited' => $product->isLikedBy(),
            'status'  => 'Produsul '.$product->external_id.' a fost sters de la favorite',
            'success' => true
        ], 200 );
    }
}
