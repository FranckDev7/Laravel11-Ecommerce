<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

        // 🔁 Recalcul des remises si un coupon existe
        if (Session::has('coupon')) {
            $this->calculateDiscount();
        }

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

            if (Session::has('coupon')) {
                $this->calculateDiscount();
            }
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

            if (Session::has('coupon')) {
                $this->calculateDiscount();
            }
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
        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back();
    }


    public function apply_coupon_code(Request $request)
    {

        $coupon_code = $request->coupon_code;
        if(isset($coupon_code))
        {
            // Carbon::now()	Date et heure actuelles	2025-07-15 13:49:21
            // Carbon::today()	Date du jour à 00:00:00 (minuit) 2025-07-15 00:00:00
            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', Cart::instance('cart')->subtotal())->first();

                if(!$coupon){
                    return redirect()->back()->with('error', 'code de coupon invalide');
                }else{
                    // Session::put() Enregistre une donnée dans la session
                    // (persistante tant que l’utilisateur est connecté ou que la session n’expire pas).
                    Session::put('coupon', [
                        'code' => $coupon->code,
                        'type' => $coupon->type,
                        'value' => $coupon->value,
                        'cart_code' => $coupon->cart_value,
                    ]);
                    $this->calculateDiscount();
                    return redirect()->back()->with('success', 'coupon a bien été appliqué');
                }
        }else{
            return redirect()->back()->with('error', 'code de coupon invalide');
        }
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if(Session::has('coupon'))
        {
            if(Session::get('coupon')['type'] == 'fixed')
            {
                $discount = Session::get('coupon')['value'];
            }else{
                $discount = (Cart::instance('cart')->subtotal() * Session::get('coupon')['value'])/100;
            }

            $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts', [
                'discount' => round($discount, 2),
                'subtotal_after_discount' => round($subtotalAfterDiscount, 2),
                'tax_after_discount' => round($taxAfterDiscount, 2),
                'total_after_discount' => round($totalAfterDiscount, 2),
            ]);

        }
    }

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return back()->with('success', 'coupon a bien été supprimé');
    }

    public function checkout()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', Auth::user()->id)->where('isdefault',1)->first();
        return view('checkout', compact('address'));
    }

    public function place_an_order(Request $request)
    {
        //dd($request->all());

        // Récupère l'utilisateur actuellement authentifién et son addresse par défaut.
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        // Si aucune adresse par défaut n'existe, On crée une nouvelle à partir des données du formulaire
        if(!$address)
        {
            $validated = $request->validate([
                'name'         => 'required|string|max:100',
                'phone'        => 'required|string|min:6|max:20',
                'district'     => 'required|string|max:100', // <- il doit exister dans la requête
                'address'      => 'required|string|max:255',
                'code_postal'  => 'required|string|max:10',
                'city'         => 'required|string|max:100',
                'country'      => 'required|string|max:100',
                'landmark'     => 'nullable|string|max:150',
                'type'         => 'nullable|in:home,office,other',
                'isdefault'    => 'sometimes|boolean',
            ]);

            $address = new Address(array_merge($validated, [
                'user_id' => $user_id,
                'country' => 'RDC',
                'isdefault' => $request->boolean('isdefault', true),
            ]));

            $address->save();
        }

        $this->setAmountForCheckout();

        // Evite l'erreur de type 'NULL' ou undefined 'index' si la clé de session 'checkout' est vide
        $checkout = Session::get('checkout', []);

        //dd($checkout);


        $order = Order::create([
            'user_id'   => $user_id,
            'subtotal'  => floatval($checkout['subtotal'] ?? 0),
            'discount'  => floatval($checkout['discount'] ?? 0),
            'tax'       => floatval($checkout['tax'] ?? 0),
            'total'     => floatval($checkout['total'] ?? 0),
            'name'      => $address->name,
            'phone'     => $address->phone,
            'district'  => $address->district,
            'city'      => $address->city,
            'country'   => $address->country,
            'landmark'  => $address->landmark,
            'code_postal' => $address->code_postal,
        ]);

        foreach (Cart::instance('cart')->content() as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->id,
                'price'      => $item->price,
                'quantity'   => $item->qty,
            ]);
        }

        if($request->mode =="card")
        {
            //
        }
        else if($request->mode =="paypal") {

            //
        }
        else if($request->mode == "cod")
        {
            $transaction = Transaction::create([
                'user_id' => $user_id,
                'order_id' => $order->id,
                'mode' => $request->mode,
                'status' => 'pending',
            ]);
        }


        // vide le panier pour éviter que l'utilisateur ne valide la même commande deux fois.
        Cart::instance('cart')->destroy();

        // Nettoie la session pour éviter la réutilisation d'anciennes données de commande, de coupon ou de réduction
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);

        return redirect()->route('cart.order.confirmation');

    }


    public function setAmountForCheckout()
    {
        if(!Cart::instance('cart')->content()->count() > 0)
        {
            Session::forget('checkout');
            return;
        }

        if(Session::has('coupon'))
        {
            Session::put('checkout', [
                'discount' => floatval(Session::get('discounts')['discount']),
                'subtotal' => floatval(Session::get('discounts')['subtotal_after_discount']),
                'tax' => floatval(Session::get('discounts')['tax_after_discount']),
                'total' => floatval(Session::get('discounts')['total_after_discount'])
            ]);
        }
        else
        {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => floatval(Cart::instance('cart')->subtotal()),
                'tax' => floatval(Cart::instance('cart')->tax()),
                'total' => floatval(Cart::instance('cart')->total())
            ]);
        }
    }


    /**
     * Affiche la page de confirmation de commande.
     *
     * Cette méthode vérifie si un ID de commande est présent dans la session.
     * Si oui, elle récupère la commande associée et renvoie la vue de confirmation.
     * Sinon, elle redirige l'utilisateur vers le panier.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function order_confirmation()
    {
        // Vérifie si un ID de commande est stocké en session
        if (Session::has('order_id')) {
            // Récupère la commande avec l'ID en session, ou échoue si elle n'existe pas
            $order = Order::findOrFail(Session::get('order_id'));

            // Affiche la page de confirmation avec les données de la commande
            return view('order-confirmation', compact('order'));
        }

        // Si aucun ID de commande en session, redirige vers le panier
        return redirect()->route('cart.index');
    }




}
