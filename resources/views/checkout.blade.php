{{-- @var \App\Models\Address|null $address --}}

@extends('layouts.app')
@section('content')
    <main class="pt-90">

        {{-- Affiche n'importe quelle erreur --}}
        <div class="mb-3">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Expédition et paiement</h2>
            <div class="checkout-steps">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Voir le panier</span>
                    <em>Gérez votre liste d'articles</em>
                </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Expédition et paiement</span>
                    <em>Consultez votre liste d'articles</em>
                </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Vérifiez et soumettez votre commande</em>
                </span>
                </a>
            </div>
            <form name="checkout-form" action="{{ route('cart.place.an.order') }}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>DÉTAILS D'EXPÉDITION</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>

                        @if($address)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-primary text-white fw-semibold">
                                            Détails de l'expédition
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-sm-4 fw-semibold">Nom :</div>
                                                <div class="col-sm-8">{{ $address->name }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-4 fw-semibold">Adresse :</div>
                                                <div class="col-sm-8">{{ $address->address }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-4 fw-semibold">Point de repère :</div>
                                                <div class="col-sm-8">{{ $address->landmark ?? 'N/A' }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-sm-4 fw-semibold">Code postal :</div>
                                                <div class="col-sm-8">{{ $address->code_postal }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 fw-semibold">Téléphone :</div>
                                                <div class="col-sm-8">{{ $address->phone }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @else
                            <div class="row mt-5">
                                {{-- name OK--}}
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        <label for="name">Nom complet *</label>
                                        @error('name') <span class="text-danger">{{ $message }}</span> @endif
                                    </div>
                                </div>
                                {{-- phone OK--}}
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                        <label for="phone">Numero de telephone *</label>
                                        @error('phone') <span class="text-danger">{{ $message }}</span> @endif
                                    </div>
                                </div>
                                {{-- code_postal OK--}}
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="code_postal" value="{{ old('code_postal') }}">
                                        <label for="code_postal">Code Postal *</label>
                                        @error('code_postal') <span class="text-danger">{{ $message }}</span> @endif
                                    </div>
                                </div>
                                {{-- city OK--}}
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                                        <label for="city">Ville *</label>
                                        @error('city') <span class="text-danger">{{ $message }}</span> @endif
                                    </div>
                                </div>
                                {{-- country OK--}}
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="country" value="RDC">
                                        <label for="state">Pays</label>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                {{-- address OK--}}
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                        <label for="address">Adresse de livraison *</label>
                                        @error('address') <span class="text-danger">{{ $message }}</span> @endif
                                    </div>
                                </div>
                                {{-- district OK--}}
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="district" value="{{ old('district') }}">
                                        <label for="district">District *</label>
                                        @error('district') <span class="text-danger">{{ $message }}</span> @endif
                                    </div>
                                </div>
                                {{-- landmark OK--}}
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="landmark" value="{{ old('landmark') }}">
                                        <label for="landmark">Point de repère *</label>
                                        @error('landmark') <span class="text-danger">{{ $message }}</span> @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                        <div class="checkout__totals">
                            <h3>Votre commande</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUIT</th>
                                        <th class="text-right">SOUS-TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::instance('cart') as $item)
                                        <tr>
                                            <td>
                                                {{ $item->name }} x {{ $item->qty }}
                                            </td>
                                            <td class="text-right">
                                                ${{ $item->subtotal() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(Session::has('discounts'))
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>Sous-total</th>
                                            <td class="text-right">${{ Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                            <th>Code Promo : @if (Session::has('coupon')) {{ Session::get('coupon')['code'] }} @endif</th>
                                            <td class="text-right">${{ Session::get('discounts')['discount'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sous total après rabais</th>
                                            <td class="text-right">${{ Session::get('discounts')['subtotal_after_discount'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Expedition</th>
                                            <td class="text-right">gratuite</td>
                                        </tr>
                                        <tr>
                                            <th>TVA</th>
                                            <td class="text-right">${{ Session::get('discounts')['tax_after_discount'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td class="text-right">${{ Session::get('discounts')['total_after_discount']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <table class="checkout-totals">
                                    <tbody>
                                        <tr>
                                            <th>SOUS-TOTAL</th>
                                            <td class="text-right">${{ Cart::instance('cart')->subtotal() }}</td>
                                        </tr>
                                        <tr>
                                            <th>EXPEDITION</th>
                                            <td class="text-right">gratuite</td>
                                        </tr>
                                        <tr>
                                            <th>TVA</th>
                                            <td class="text-right">${{ Cart::instance('cart')->tax() }}</td>
                                        </tr>
                                        <tr>
                                            <th>TOTAL</th>
                                            <td class="text-right">${{ Cart::instance('cart')->total() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div class="checkout__payment-methods">

                            {{--  Debit or Credit Card --}}
                            <div class="form-check">
                                <input
                                    class="form-check-input form-check-input_fill"
                                    type="radio"
                                    name="mode"
                                    id="mode1"
                                    value="card">
                                <label class="form-check-label" for="mode1">
                                    Debit or Credit Card
                                </label>
                            </div>

                            {{-- paypal --}}
                            <div class="form-check">
                                <input
                                    class="form-check-input form-check-input_fill"
                                    type="radio"
                                    name="mode"
                                    id="mode3"
                                    value="paypal">
                                <label class="form-check-label" for="mode3">
                                    Paypal
                                </label>
                            </div>

                            {{-- Cash on delivery --}}
                            <div class="form-check">
                                <input
                                    class="form-check-input form-check-input_fill"
                                    type="radio"
                                    name="mode"
                                    id="mode2"
                                    value="cod">
                                <label class="form-check-label" for="mode2">
                                    Paiement à la livraison
                                </label>
                            </div>

                            <div class="policy-text">
                                Vos données personnelles seront utilisées pour traiter votre commande,
                                améliorer votre expérience sur ce site Web et à d'autres fins décrites dans notre
                                <a href="terms.html" target="_blank">politique de confidentialité</a>.
                            </div>
                        </div>
                        <button class="btn btn-primary btn-checkout">PASSER LA COMMANDE</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
