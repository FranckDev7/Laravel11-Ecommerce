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
            <div class="flex flex-wrap items-center justify-between gap20 mb-27">
                <h3>Categories</h3>
                <ul class="flex flex-wrap items-center justify-start breadcrumbs gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Tableau de bord</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Categories</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex flex-wrap items-center justify-between gap10">
                    <div class="flex-grow wg-filter">
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
                    <a class="tf-button style-1 w208" href="{{ route('admin.category.add') }}"><i
                            class="icon-plus"></i>Nouvelle marque</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">

                        @if (Session::has('status'))
                            <p id="flash-message" class="alert alert-success">{{ Session::get('status') }}</p>
                        @endif

                        @push('styles')
                            <style>
                                table thead tr th {
                                    padding: 5px !important;
                                }
                                .text-center-custorm {
                                    text-align: center !important;
                                }
                            </style>
                        @endpush
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 5% !important;">N°</th>
                                    <th style="width: 25% !important;">Nom de la catégorie</th>
                                    <th class="text-center">Slug</th>
                                    <th class="text-center" style="width: 15% !important;">Produits</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- isEmpty() : méthode de la classe Illuminate\Support\Collection dans Laravel.
                                verifie si si une collection Laravel contient des éléments ou non --}}
                                @if ($categories->isEmpty())
                                    <tr><td colspan="5" class="text-center">aucune donnée enregistrée pour l'instant</td></tr>
                                @endif
                                @foreach ($categories as $category)
                                    <tr>
                                        <td style="width: 5% !important;">{{ $loop->iteration }}</td>
                                        <td class="pname" style="width: 100% !important;">
                                            <div class="image">
                                                <img src="{{ asset('uploads/categories/' . $category->image) }}" alt="{{ $category->name }}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="#" class="body-title-2">{{ $category->name }}</a>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $category->slug }}</td>
                                        <td class="text-center"><a href="#" target="_blank">0</a></td>
                                        <td>
                                            <div class="list-icon-function d-flex justify-content-center">
                                                <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <form action="{{ route('admin.category.delete', ['id' => $category->id]) }}" method="POST">
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
                    <div class="mt-5 flex flex-wrap items-center justify-between gap10 wgp-pagination">
                        {{ $categories->links('pagination::bootstrap-5') }}
                    </div>
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

