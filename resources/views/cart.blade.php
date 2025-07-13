
@extends('layouts.app')
@section('content')
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Panier</h2>
      <div class="checkout-steps">
        {{-- void en Js sert à ignorer le résultat d’une expression et à retourner undefined --}}
        {{-- Utilisé souvent dans des liens HTML pour empêcher leur comportement par défaut --}}
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Sac à provisions</span>
            <em>Gérez votre liste d'articles</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
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
      <div class="shopping-cart">
        @if($items->count() > 0)
            <div class="cart-table__wrapper">
            <table class="cart-table">
                <thead>
                <tr>
                    <th>Produit</th>
                    <th></th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Sous-total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>
                        <div class="shopping-cart__product-item">
                            <img
                                loading="lazy"
                                src="{{ asset('uploads/products/thumbnails') }}/{{ $item->model->image }}"
                                width="120"
                                height="120"
                                alt="{{ $item->name }}"
                            />
                        </div>
                    </td>
                    <td>
                        <div class="shopping-cart__product-item__detail">
                            <h4>{{ $item->name }}</h4>
                            <ul class="shopping-cart__product-item__options">
                            <li>Couleur: Yellow</li>
                            <li>Taille: L</li>
                            </ul>
                        </div>
                    </td>
                        <td>
                            <span class="shopping-cart__product-price">${{ $item->price }}</span>
                        </td>
                    <td>
                        <div class="qty-control position-relative">
                            <input type="number" name="quantity" value="{{ $item->qty }}" min="1" class="qty-control__number text-center">

                            {{-- Reduit la quantité de l'article --}}
                            <form method="POST" action="{{ route('cart.qty.decrease', $item->rowId) }}" >
                                @csrf
                                @method('PUT')
                                <div class="qty-control__reduce">-</div>
                            </form>

                            {{-- Augmente la quantité de l'article --}}
                            <form method="POST" action="{{ route('cart.qty.increase', $item->rowId) }}">
                                @csrf
                                @method('PUT')
                                <div class="qty-control__increase">+</div>
                            </form>

                        </div>
                    </td>
                    <td>
                    <span class="shopping-cart__subtotal">${{ $item->subTotal() }}</span>
                    </td>
                    <td>
                        {{-- Tous les attributs qui commencent par data- sont des attributs de données valides en HTML5.
                        utilisés souvent pour stocker des informations invisibles dans le DOM. --}}
                        <a href="#" class="remove-cart text-danger" data-rowid="{{ $item->rowId }}" title="Supprimer">
                            <span class="fs-5 text-muted">&times;</span>
                        </a>
                        {{-- Formulaire caché pour supprimer l'article du panier --}}
                        <form method="POST" action="{{ route('cart.item.remove', $item->rowId) }}" class="d-none delete-form-{{ $item->rowId }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="cart-table-footer">
                <form action="#" class="position-relative bg-body">
                <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit"
                    value="APPLY COUPON">
                </form>

                {{-- Vide le panier ('cart') --}}
                <form action="{{ route('cart.empty') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-light">VIDER LE PANIER</button>
                </form>

            </div>
            </div>
            <div class="shopping-cart__totals-wrapper">
            <div class="sticky-content">
                <div class="shopping-cart__totals">
                <h3>Total du panier</h3>
                <table class="cart-totals">
                    <tbody>
                    <tr>
                        <th>Sous-total</th>
                        <td>${{ Cart::instance('cart')->subtotal() }}</td>
                    </tr>
                    <tr>
                        <th>Expédition</th>
                        <td>Free</td>
                    </tr>
                    <tr>
                        <th>VAT</th>
                        <td>${{ Cart::instance('cart')->tax() }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>${{ Cart::instance('cart')->total() }}</td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <div class="mobile_fixed-btn_wrapper">
                <div class="button-wrapper container">
                    <a href="checkout.html" class="btn btn-primary btn-checkout">PASSER A LA CAISSE</a>
                </div>
                </div>
            </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12 text-center pt-5 bp-5">
                    <p>Aucun article trouvé dans votre panier</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-info text-white fw-bold px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="bi bi-eye"></i> Afficher maintenant
                    </a>

                </div>
            </div>
        @endif
        </div>
    </section>
    </main>
@endsection

@include('modal-cart')

@push('scripts')
    <script>
        $(function(){
            // Pour + et -
            $(".qty-control__increase, .qty-control__reduce").on('click', function(e){
                e.preventDefault();
                $(this).closest('form').submit();
            });

            // Logique pour suppression avec modal
            let formToSubmit = null;

            $(".remove-cart").on('click', function(e){
                e.preventDefault();

                // Récupère le rowId pour identifier le bon formulaire
                // .data() : méthode jQuery permettant de lire ou écrire
                // une valeur venant d’un attribut HTML data-*
                // Tout ce qui suit 'data-' devient le nom de l'attribut
                // de données dans JavaScript ou jQuery.
                let rowId = $(this).data('rowid');

                // Sélectionne le formulaire caché associé à l'élément cliqué
                formToSubmit = $('.delete-form-' + rowId);

                // Initialise une modale Bootstrap basée sur l’élément HTML avec l’id #confirmDeleteModal.
                let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

                // Affiche la modale
                modal.show();
            });

            $("#confirmDeleteBtn").on('click', function(){
                if(formToSubmit) { // Vérifie qu’un formulaire a bien été stocké.
                    formToSubmit.submit();
                }
            });
        });
    </script>
@endpush

