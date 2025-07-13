@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Wishlist</h2>
            <div class="shopping-cart">
                @if(Cart::instance('wishlist')->count() > 0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th class="text-center">Produit</th>
                                <th></th>
                                <th class="text-center">Prix</th>
                                <th class="text-center">Quantité</th>
                                <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>
                                        <div class="shopping-cart__product-item">
                                            <img loading="lazy" src="{{ asset('uploads/products/thumbnails') }}/{{ $item->model->image }}" width="120" height="120" alt="{{ $item->name }}" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="shopping-cart__product-item__detail">
                                            <h4>{{ $item->name }}</h4>
                                            {{-- <ul class="shopping-cart__product-item__options">
                                            <li>Color: Yellow</li>
                                            <li>Size: L</li>
                                            </ul> --}}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="shopping-cart__product-price">${{ $item->price }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="text-center">
                                        <form  method="POST" action="{{ route('wishlist.item.remove', ['rowId' => $item->rowId]) }}" id="remove-item-{{ $item->rowId }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)" class="remove-cart" data-rowid="{{ $item->rowId }}">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                                <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                                </svg>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="cart-table-footer">
                        <form method="POST" action="{{ route('wishlist.items.clear') }}" id="clear-wishlist-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light" id="clear-wishlist">Vider la liste</button>
                        </form>
                    </div>
                </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <p>Aucun article trouvé dans votre liste de souhaits</p>
                            <a href="{{ route('shop.index') }}" class="w-100 btn btn-info d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2 fw-semibold">
                                <i class="bi bi-heart-fill text-danger"></i>
                                Liste de souhaits
                            </a>

                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection

@include('modal-wishlist')

@push('scripts')
    <script>
        let formToDelete = null; // formulaire ciblé à soumettre (soit 1 article, soit tous)

        /**
         * Cas : suppression d’un seul article
         *
         * querySelectorAll : sélectionne tous les éléments HTML qui ont la classe '.remove-cart'
         * forEach : pour chaque élément trouvé
         * function(element){} : fonction exécutée pour chaque element trouvé (appelé ici button).
         * const rowId : variable qui contiendra l'identifiant du produit.
        */
        document.querySelectorAll('.remove-cart').forEach(function(element) {
            element.addEventListener('click', function () {
                const rowId = this.getAttribute('data-rowid');
                formToDelete = document.getElementById('remove-item-' + rowId);

                // Message modale spécifique
                document.getElementById('modalDeleteMessage').textContent = "Voulez-vous vraiment supprimer cet article de cette liste ?";

                // crée une instance de la modale Bootstrap.
                const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));

                //  affiche la modale (ouvre la boîte de confirmation).
                modal.show();
            });
        });

        // Cas : vider toute la liste
        document.getElementById('clear-wishlist').addEventListener('click', function () {
            formToDelete = document.getElementById('clear-wishlist-form');

            // Message modale pour suppression globale
            document.getElementById('modalDeleteMessage').textContent = "Êtes-vous sûr de vouloir supprimer tous les articles de votre liste de souhaits ?";

            const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            modal.show();
        });

        // Confirmer la suppression (un seul ou tous)
        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (formToDelete) {
                this.disabled = true; // désactive le bouton pour éviter un double clic
                formToDelete.submit();
            }
        });
    </script>
@endpush
