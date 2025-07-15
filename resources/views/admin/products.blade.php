@extends('layouts.admin')
@section('content')
    @push('styles')
        <style>
            .swal-wide {
                width: 480px !important;
                max-width: 90%;
                font-size: 15px; /* taille du texte plus grande */
            }
            .swal-text-rouge {
                color: red;
            }
        </style>
    @endpush
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Tous les produits</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Tableau de bord</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Tous les produits</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}"><i
                            class="icon-plus"></i>Ajouetr un nouveau</a>
                </div>
                <div class="table-responsive">

                    @if (Session::has('status'))
                        <p id="flash-message" class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center fs-4">N°</th>
                                <th class="text-center fs-4" style="padding: 5px !important;">Nom du produit</th>
                                <th class="text-center fs-4">Prix regulier</th>
                                <th class="text-center fs-4">Prix de vente</th>
                                <th class="text-center fs-4">SKU</th>
                                <th class="text-center fs-4">Categorie</th>
                                <th class="text-center fs-4">Marque</th>
                                <th class="text-center fs-4">En vedette</th>
                                <th class="text-center fs-4">Stock</th>
                                <th class="text-center fs-4">Quantité</th>
                                <th class="text-center fs-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- isEmpty() : méthode de la classe Illuminate\Support\Collection dans Laravel.
                            verifie si si une collection Laravel contient des éléments ou non --}}
                            @if ($products->isEmpty())
                                <tr><td colspan="11" class="text-center">aucun produit enregistré pour l'instant</td></tr>
                            @endif
                            @foreach ($products as $product)
                                <tr>
                                    <td class="text-center fs-4">{{ $loop->iteration }}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $product->image }}" alt="{{ $product->name }}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{ $product->name }}</a>
                                            <div class="text-tiny mt-3">{{ $product->slug }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center fs-5">{{ $product->regular_price }}</td>
                                    <td class="text-center fs-5">{{ $product->sale_price }}</td>
                                    <td class="text-center fs-5">{{ $product->SKU }}</td>
                                    <td class="text-center fs-5">{{ $product->category->name }}</td>
                                    <td class="text-center fs-5">{{ $product->brand->name }}</td>
                                    <td class="text-center fs-5">{{ $product->featured === 0 ? "No" : "Yes" }}</td>
                                    <td class="text-center fs-5">{{ $product->stock_status }}</td>
                                    <td class="text-center fs-5">{{ $product->quantity }}</td>
                                    <td class="text-center fs-5">
                                        <div class="list-icon-function">
                                            <a href="#" target="_blank">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </a>
                                            <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{route('admin.product.delete', ['id' => $product->id])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="mt-5 flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        /**
         * closest : methode jQuery qui renvoie le premier parent
         * .parents : mthode jQuery qui renvoie tous les parents
         * (dans un tableau jQuery), du plus proche au plus lointain.
         * */
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form'); // let form : stocke ce formulaire.
                Swal.fire({
                    title: "Êtes-vous sûr?",
                    text: "Vous ne pourrez plus revenir en arrière !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#686868",
                    confirmButtonText: "Oui, supprimer!",
                    cancelButtonText: "Annuler",
                    customClass: {
                        popup: 'swal-wide', // clé qui cible tout le conteneur principal de la popup SweetAlert2.
                        htmlContainer: 'swal-text-rouge' // clé utilisée pour styliser le contenu de text dans une alerte SweetAlert2.
                    }
                }).then((result) => {
                    // .then(...) : cette fonction est appelée lorsque l’utilisateur clique sur un des boutons
                    // ou ferme la boîte de dialogue. Le paramètre 'result' est un objet.
                    // Pour savoir si l'utilisateur a confirmé l'action, on teste 'result.isConfirmed'.
                    // Si 'result.isConfirmed' vaut true, cela signifie que l'utilisateur a cliqué sur "Oui, supprimer !"
                    if (result.isConfirmed) {
                        form.submit(); // soumet le formulaire
                    }
                });
            });
        });
    </script>
    <script>
        /**
         * document : (objet js) fait référence à toute la page HTML.
         * addEventListener : méthode pour écouter un événement.
         * DOMContentLoaded : événement déclenché lorsque le HTML
         * est entièrement chargé (mais pas forcément les images ou autres ressources).
         * unction() { ... } : fonction anonyme qui sera exécutée quand l'événement (DOMContentLoaded) se produit.
         * if(flash) : vérifie si l'élément existe (n’est pas null).
         * setTimeout : exécute une fonction après un certain délai.
        */
        document.addEventListener('DOMContentLoaded', function() {
            let flash = document.getElementById('flash-message');
            if(flash){
                setTimeout(function(){
                    // Animation : disparition progressive
                    flash.style.transition = 'opacity 0.5s';
                    flash.style.opacity = '0';
                    setTimeout(function(){
                        flash.style.display = 'none';
                    }, 500);
                }, 3000); // 3000ms = 3 secondes avant de disparaître
            }
        });
    </script>
@endpush

