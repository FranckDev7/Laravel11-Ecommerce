@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Ajouter un Produit</h3>
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
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Produits</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Ajouter un produit</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.product.store') }}">
                @csrf
                <div class="wg-box">
                    {{-- Nom du produit --}}
                    <fieldset class="name">
                        <div class="body-title mb-10">Nom du produit <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Nom..." name="name" tabindex="0" value="{{ old('name') }}" aria-required="false">
                        <div class="text-tiny">Ne pas dépasser 100 caractères lors de la saisie du nom du produit.</div>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Slug du produit --}}
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Slug..." name="slug" tabindex="0" value="{{ old('slug') }}" aria-required="false">
                        <div class="text-tiny">Ne pas dépasser 100 caractères lors de la saisie de slug du nom du produit.</div>
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="gap22 cols">
                        {{-- Catégorie --}}
                        <select name="category_id" class="form-control">
                            <option value="">Choisir une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror

                        <fieldset class="brand">
                            <div class="body-title mb-10">Marque <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="brand_id">
                                    <option value="">Choisir la marque</option>
                                    @foreach ($brands as $brand )
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('brand_id')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Courte desciption --}}
                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Courte description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Courte description" tabindex="0" aria-required="false">{{ old('short_description') }}</textarea>
                        <div class="text-tiny">Ne pas dépasser 25 caractères lors de la saisie du nom du produit.</div>
                    </fieldset>
                    @error('short_description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Desciption --}}
                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="false">{{ old('description') }}</textarea>
                        <div class="text-tiny">Ne pas dépasser 100 caractères lors de la saisie du nom du produit.</div>
                    </fieldset>
                    @error('description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </div>
                <div class="wg-box">

                    {{-- Image --}}
                    <fieldset>
                        <div class="body-title mb-2">Téléverser une image<span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="../../../localhost_8000/images/upload/upload-1.png" class="effect8" alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Déposez l'image du produit<span class="tf-color">cliquez pour parcourir</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    {{-- Images de la galerie --}}
                    <fieldset>
                        <div class="body-title mb-10">Téléverser des images de galerie</div>
                        <div class="upload-image mb-16">
                            <!-- <div class="item">
            <img src="images/upload/upload-1.png" alt="">
        </div>                                                 -->
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Déposez vos images ici ou sélectionnez<span
                                            class="tf-color">cliquez pour parcourir</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple="">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('images')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="cols gap22">
                        {{-- Prix régulier --}}
                        <fieldset class="name">
                            <div class="body-title mb-10">Prix régulier <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Entrer le prix régulier" name="regular_price" tabindex="0" value="{{ old('regular_price') }}" aria-required="false">
                        </fieldset>
                        @error('regular_price')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror

                        {{-- Prix de vente --}}
                        <fieldset class="name">
                            <div class="body-title mb-10">Prix de vente <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Prix..." name="sale_price" tabindex="0" value="{{ old('sale_price') }}" aria-required="false">
                        </fieldset>
                        @error('sale_price')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="cols gap22">
                        {{-- SKU --}}
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="SKU..." name="SKU" tabindex="0" value="{{ old('SKU') }}" aria-required="false">
                        </fieldset>
                        @error('SKU')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror

                        {{-- Quantité --}}
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantite <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Quantité..." name="quantity" tabindex="0" value="{{ old('quantity') }}" aria-required="true">
                        </fieldset>
                        @error('quantity')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        {{-- stock --}}
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="">Selectionner si c'est en stock</option>
                                    <option value="instock" {{ old('stock_status') == 'instock' ? 'selected' : '' }}>En stock</option>
                                    <option value="outofstock" {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>En rupture de stock</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror

                        {{-- En vedette --}}
                        <fieldset class="name">
                            <div class="body-title mb-10">En vedette</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="">Validez si c'est en vedette</option>
                                    <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>Non</option>
                                    <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Oui</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('featured')
                            <span class="alert alert-danger text-center w-full">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Ajouter Produit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function (){
            $("#myFile").on("change", function(e){
                const photoInp = $("#myFile");
                const[file] = this.files;
                if(file)
                {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });

            $("#gFile").on("change", function(e){
                const photoInp = $("#gFile");
                const gphotos= this.files; // this.files : tableau des fichiers de type (UploadedFile)

                // $.each(...) : méthode jQuery pour parcourir un tableau ou un objet.
                // key : l’index dans le tableau (0, 1, 2, etc.),
                // val : l’objet File (de type UploadedFile)
                // la méthode URL.createObjectURL() : génère une URL temporaire permettant d’afficher le fichier image
                // dans le navigateur, sans l’avoir téléversé (uploadé) sur le serveur.
                $.each(gphotos, function(key, val){
                    $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" /></div>`)
                });
            });

            $("input[name='name']").on("change", function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            function StringToSlug(Text) {
                return Text.toLowerCase()
                    .replace(/[^\w]+/g, "-")   // supprime tous les caractères non alphanumériques et les remplace par trait d'union
                    .replace(/\+/g, "-") // remplace les "+" par des "-"
            }
        })
    </script>
@endpush

