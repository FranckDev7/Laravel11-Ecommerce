<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // INDEX
    public function index(Request $request)
    {

        // Récupère la taille de pagination depuis la requête, ou utilise 12 par defaut
        // query : méthode de l’objet $request qui sert à récupérer un paramètre dans l’URL
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $f_brands = $request->query('brands');
        $f_categories = $request->query('categories');
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 500;
        $order = $request->query('order') ? $request->query('order') : -1;
        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
        }

        $brands = Brand::orderBy('name', 'ASC')->get(); // récupère toutes les marques triées par nom
        $categories =  Category::with('products')->orderBy('name', 'ASC')->get();

        /**
         * when() : méthode de la classe  Illuminate\Database\Eloquent\Builder et aussi Illuminate\Database\Query\Builder
         * qui permet d'ajouter une condition seulement si une valeur est présente
         * filtre les produits dont le brand_id est dans la liste contenue dans $f_brands (après transformation en tableau)
         * Le suffixe Raw signifie que tu écris la condition en SQL "brut" (non protégé par l’ORM)
         * Le ? est un paramètre lié qui sera remplacé par la valeur fournie dans le tableau
         * orWhere : cette methode (ou clause) utilise la syntaxe Eloquent/Query Builder
         * et Protège automatiquement contre les injections SQL.
         */
        $products = Product::when($f_brands, function ($query, $f_brands) {
            $brandIds = explode(',', $f_brands);
            return $query->whereIn('brand_id', $brandIds);
        })
        ->when($f_categories, function($query, $f_categories){
            $categoryId = explode(',', $f_categories);
            return $query->whereIn('category_id', $categoryId);
        })
        ->where(function($query) use ($min_price, $max_price){
            $query->whereBetween('regular_price', [$min_price, $max_price])
                    ->orWhereBetween('sale_price', [$min_price, $max_price]);
        })
        ->orderBy($o_column, $o_order)
        ->paginate($size);

        return view('shop', compact(
            'products',
            'size',
            'order',
            'brands',
            'f_brands',
            'categories',
            'f_categories',
            'min_price',
            'max_price'
        ));
    }


    // PRODUCT_DETAILS
    /**
     * ->firstOrFail() : récupère le premier résultat trouvé ou génère une erreur 404 si aucun produit n’est trouvé.
     * ->where('category_id', $product->category_id) : Lance une requête pour récupérer tous les produits dont
     * category_id est égal à la category_id du produit actuel
     * ->where('id', '<>', $product->id) : (clause) pour exclure le produit courant de la liste des produits liés.
     * ->take(8) : limite le nombre de produits liés à 8.
     * ->get(); : exécute la requête et récupère les résultats sous forme de collection d’objets Product.
     * @param mixed $product_slug
     * @return \Illuminate\Contracts\View\View
     */
    public function product_details($product_slug)
    {
        $product = Product::where('slug', $product_slug)->firstOrFail();

        // Récupérer les produits liés de la même catégorie, sauf le produit courant
        $rproducts = Product::where('category_id', $product->category_id)
                        ->where('id', '<>', $product->id)
                        ->get();
        return view('details', compact('product', 'rproducts'));
    }

}
