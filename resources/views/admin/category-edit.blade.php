@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex flex-wrap items-center justify-between gap20 mb-27">
                <h3>Infomation sur la catégorie</h3>
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
                        <a href="{{ route('admin.categories') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Modifier la catégorie</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.category.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- champ caché car c'est rempli automatiquement par la BD --}}
                    <input type="hidden" name="id" value="{{ $category->id }}">

                    {{-- Brand Name --}}
                    <fieldset class="name">
                        <div class="body-title">Nom de la catégorie <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" name="name" tabindex="0" value="{{ $category->name }}" aria-required="false">
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                    {{-- Brand Slug --}}
                    <fieldset class="name">
                        <div class="body-title">Slug de la catégorie <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" name="slug" tabindex="0" value="{{ $category->slug }}" aria-required="false">
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Upload images --}}
                    <fieldset>
                        <div class="body-title">Télécharger des images<span class="tf-color-1">*</span>
                        </div>
                        <div class="flex-grow upload-image">
                            @if ($category->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ asset('uploads/categories') }}/{{ $category->image }}" class="effect8"
                                        alt="">
                                </div>6
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Déposez vos images ici ou sélectionnez <span
                                            class="tf-color">cliquez pour parcourir</span></span>
                                    <!-- accept="image/*" cet attribut est utilisé uniquement sur le champ -->
                                    <!-- de type 'file' et la valeur image/* veut dire tous les types de fichiers images -->
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Mettre a jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- La directive push dans le moteur de template Blade permet de remplir la pile
@stack('nom_de_la_pile') avec du code (souvent CSS ou JavaScript), afin qu’il soit
affiché à un endroit précis du layout. --}}
@push('scripts')
    <script>
        // Le code est exécuté après le chargement complet de la page HTML
        $(function() {
            /*
             .on("change", function(e)) : ajoute un écouteur d’événement change
              qui s’active quand l’utilisateur sélectionne un fichier.
            */
            $("#myFile").on("change", function(e) {
                // stocke l'element avec l'id="myFile" dans cette constante
                const photoInp = $("#myFile");

                // this : fait reference à l'element selectionné(#myFile)

                // files est une propriété de la classe HTMLInputElement du DOM
                // (héritée de HTMLElement du DOM).
                // ,elle est disponible uniquement si l'élément est de type <input type="file">.
                // et retourne un objet FileList, qui contient tous les fichiers sélectionnés
                // par l'utilisateur.

                // [file] : destructuration du tableau this.files ce qui veut dire
                // qu'on récupère le premier élément du tableau this.files et ça retourne un
                // objet de type 'File'
                // const[file] = this.files; peut s'ecrire const file = this.files[0];
                const [file] = this.files;

                // Vérifie si file existe (c’est-à-dire qu’un fichier a été sélectionné)
                if (file) {
                    // $("#imgpreview img") utilise jQuery pour sélectionner l’élément <img>
                    // à l’intérieur de l’élément avec l’id="imgpreview".
                    // .attr('src', ...) : modifie l’attribut src de la balise <img>.
                    // URL : Classe globale (native) du navigateur.
                    // createObjectURL(...) : methode statique qui Crée une URL temporaire vers un fichier(de type File)
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            // this : l’élément natif du DOM et fait référence à l’élément qui a déclenché l’événement
            // $(this) : convertit cet élément en un objet jQuery pour pouvoir utiliser les méthodes jQuery.
            // $(this).val() : récupère la valeur actuelle du champ input avec attribut name="name"
            // StringToSlug($(this).val()) : Appelle la fonction JavaScript StringToSlug en lui passant la valeur du champ name.
            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            function StringToSlug(Text) {
                return Text.toLowerCase()
                    // supprime tous les caractères non alphanumériques et les remplace par rien
                    .replace(/[^\w]+/g, "-")
                    // remplace les "+" par des "-"
                    .replace(/\+/g, "-")
            }
        })
    </script>
@endpush
