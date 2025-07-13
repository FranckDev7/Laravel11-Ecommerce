<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier.
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }


    /**
     * Ajoute un article au panier.
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function add_to_cart(Request $request)
    {
        /**
         * associate('App\Models\Product') permet de lier l’article dans le panier
         * à un modèle Eloquent, ici App\Models\Product.
         * Grâce à cela, tu pourras faire par exemple : $item->model->image ou $item->model->description
        */

        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        Cart::instance('cart')->add(
            $request->input('id'),
            $request->input('name'),
            $request->input('quantity'),
            $request->input('price')
        )->associate('App\Models\Product');

        return redirect()->back();
    }


    /**
     * Augmente la quantité d'un article dans le panier.
     * @param mixed $rowId
     * @return void
     */
    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        if ($product) {
            Cart::instance('cart')->update($rowId, $product->qty + 1);
        }
        return redirect()->back();
    }


    /**
     * Diminue la quantité d'un article dans le panier.
     * @param mixed $rowId
     * @return void
     */
    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        if ($product && $product->qty > 1) {
            Cart::instance('cart')->update($rowId, $product->qty - 1);
        }
        return redirect()->back();
    }


    /**
     * Supprime l'article dans le panier('cart')
     * @param mixed $rowId
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    /**
     * Vide le panier ('cart')
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }



}
