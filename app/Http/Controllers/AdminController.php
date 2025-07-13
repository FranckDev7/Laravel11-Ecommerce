<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{

    // INDEX
    public function index()
    {
        return view('admin.index');
    }


    // BRANDS
    public function brands()
    {
        $brands = Brand::orderBy('id', direction: 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }


    // ADD_BRAND
    public function add_brand()
    {
        return view('admin.brand-add');
    }


    // BRAND_STORE
    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'required|mimes:png,jpg,jpeg,webp,svg|max:2048'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;

        /**
         * slug() : méthode statique de la classe Illuminate\Support\Str de Laravel,
         * qui contient des fonctions utilitaires pour les chaînes de caractères.
         *
         * slug() : cette methode génère un « slug » convivial pour l'URL à partir d'une chaîne donnée.
         */
        $brand->slug = Str::slug($request->name);

        /**
         * file('image') : méthode de  Illuminate\Http\Request qui hérite de
         * Symfony\Component\HttpFoundation\Request pour récupérer un fichier téléchargé (uploadé).
         * et retourne un objet de type UploadedFile
         */
        $image = $request->file('image');

        // Récupère l'extention du fichier uploadé
        $file_extention = $request->file('image')->extension();

        /**
         * Carbon::now() : retourne un objet Carbon représentant la date et l'heure actuelles. (Résultat: 2025-06-26 15:23:45)
         * Carbon::now()->timestamp : appelle la propriété timestamp de l’objet Carbon retourné. (Résultat : 1724708625)
         */
        $file_name = Carbon::now()->timestamp . '.' . $file_extention;

        $this->GenerateBrandThumbailsImage($image, $file_name);

        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'La marque a été ajoutée avec succès!');

    }


    // BRAND_EDIT
    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }


    // BRAND_UPDATE
    public function brand_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'. $request->id,
            'image' => 'mimes:png,jpg,jpeg,webp,svg|max:2048'
        ]);

        $brand = Brand::find($request->id);

        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);

        if($request->hasFile('image')){ // vérifie si la requête HTTP contient un fichier avec le champ image
            // vérifie si un fichier image existe dans le dossier public/uploads/brands correspondant à $category->image.
            if(File::exists(public_path('uploads/brands').'/'.$brand->image)){
                // Si le fichier existe, on le supprime du disque.
                File::delete(public_path('uploads/brands').'/'.$brand->image);
            }
            $image = $request->file('image');
            // la methode extension de l'objet 'UploadedFile' retourne l’extension devinée
            // automatiquement par Laravel, basée sur le type MIME réel du fichier.
            // Même si le fichier s’appelle 'photo.JPEG', mais qu’il contient
            // en fait des données PNG (trafiqué ou renommé), cette méthode retournera : png
            // Elle est beaucoup plus fiable et sécurisée que getClientOriginalExtension,
            // car Laravel inspecte le contenu du fichier via PHP ou la bibliothèque FileInfo.
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;

            $this->GenerateBrandThumbailsImage($image, $file_name);
            $brand->image = $file_name;
        }

        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'La marque a été mise à jour avec succès!');
    }


    // GenerateBrandThumbailsImage
    public function GenerateBrandThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/brands');

        // Image::make() : méthode de la classe Intervention\Image\ImageManager
        // qui charge ou fabrique une image depuis un chemin donné et retourne
        // une instance de (Intervention\Image\Image),
        // path() : méthode de la classe UploadedFile et retourne le chemin temporaire
        // du fichier image sur le serveur.
        // function ($constraint) { $constraint->upsize(); } : fonction callback anonyme qui permet de contraindre le redimensionnement.
        // Ici on mpêche l'image d’être agrandie si elle est plus petite que 200x200.
        $img = Image::make($image->path());
        $img->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        }, 'top')->save($destinationPath . '/' . $imageName);
    }


   // BRAND_DELETE
    public function brand_delete($id)
    {
        $brand = Brand::find($id); // récupère la marque à supprimer via son identifiant


        if(File::exists(public_path('uploads/brands').'/'. $brand->image))
        {
            // Si un fichier image est associé à cette marque et qu'il existe physiquement
            // dans le dossier public/uploads/brands, alors on le supprime du disque pour
            // éviter les fichiers orphelins
            File::delete(public_path('uploads/brands').'/'.$brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status', 'La marque a été supprimée avec succès!');
    }



    // CATEGORIES
    public function categories()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function category_add()
    {
        return view('admin.category-add');
    }


    // CATEGORIE_STORE
    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'required|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

    $category = new Category();
    $category->name = $request->name;
    $category->slug = Str::slug($request->name);

    $image = $request->file('image');

    // Récupère dynamiquement l'extension du fichier uploadé
    $file_extension = $image->extension();

    // Génère un nom de fichier unique avec timestamp + chaîne aléatoire pour eviter le conflit si plusieurs images sont uploadées au même moment
    $file_name = Carbon::now()->timestamp . '-' . Str::random(5) . '.' . $file_extension;

    // Crée l'image et la sauvegarde dans le dossier uploads/categories
    $this->GenerateCategoryThumbailsImage($image, $file_name);

    // Sauvegarde uniquement le nom du fichier (sans 'uploads/categories/') pour garder cohérence avec ta gestion des images
    $category->image = $file_name;

    $category->save();

    return redirect()->route('admin.categories')->with('status', 'La catégorie a été ajoutée avec succès!');
}

    public function GenerateCategoryThumbailsImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/categories');
        $img = Image::make($image->path());
        $img->fit(200, 200, function ($constraint) {
            $constraint->upsize();
        }, 'top')->save($destinationPath . '/' . $imageName);

    }


    // CATEGORY_EDIT
    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'. $request->id, //, $request->id fait ensorte que laravel ignore la rêgle de validation sur ce champs ayant l'id ($request->$id) lors de update pour eviter l'erreur (slug existe déjà) au cas où on ne modifie pas ce champ lors de update
            'image' => 'mimes:png,jpg,jpeg,webp,svg|max:2048'
        ]);

        $category = Category::find($request->id);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);

        if($request->hasFile('image')){ // vérifie si la requête HTTP contient un fichier avec le champ image
            // vérifie si un fichier image existe dans le dossier public/uploads/brands correspondant à $category->image.
            if(File::exists(public_path('uploads/categories').'/'.$category->image)){
                // Si le fichier existe, on le supprime du disque.
                File::delete(public_path('uploads/categories').'/'.$category->image);
            }
            $image = $request->file('image');
            $file_extention = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;

            $this->GenerateCategoryThumbailsImage($image, $file_name);
            $category->image = $file_name;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('status', 'catégorie mise à jour avec succès!');
    }



    // CATEGORY_DELETE
    public function category_delete($id)
    {
        $category = Category::find($id); // récupère la marque à supprimer via son identifiant
        if(File::exists(public_path('uploads/categories').'/'.$category->image))
        {
            // Si un fichier image est associé à cette marque et qu'il existe physiquement
            // dans le dossier public/uploads/brands, alors on le supprime du disque pour
            // éviter les fichiers orphelins
            File::delete(public_path('uploads/categories').'/'.$category->image);
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('status', 'catégorie supprimée avec succès!');
    }



    // PRODUCTS
    public function products()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.products', compact('products'));
    }


    // PRODUCT_ADD
    public function product_add()
    {
        $categories = Category::select(['id', 'name'])->orderBy('name')->get();
        $brands = Brand::select(['id', 'name'])->orderBy('name')->get();

        return view('admin.product-add', compact('categories', 'brands'));
    }


    // PRODUCT_STORE
    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg,webp|max:2080',
            //'images' => 'required|array',
           // 'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        /**
         * Carbon::now() : une instance de la classe Carbon
         * On peut ensuite chaîner toutes les méthodes (ou accéder aux propriétés) de cette classe.
         * Carbon::now()->timestamp : Propriété : retourne l'horodatage Unix (ex : 1724580732)
         * Carbon::now()->toDateString() : méthode qui retourne la date au format YYYY-MM-DD
         * Carbon::now()->format('d/m/Y H:i') : méthode de formatage personnalisé
         * Carbon::now()->addDays() : méthode qui permet d'ajouter le nombre de jours
         * Carbon::now()->subMonth() : méthode qui permet de soustraire le nombre de jours
         *
         */
        // $current_timestamp = Carbon::now()->timestamp; // risque de collision si plusieurs utilisateurs téléverse la même image au même momement
        $current_timestamp = Carbon::now()->format('YmdHisv'); // risque de collision quasi impossible


        // une méthode de l’objet $request qui vérifie si un champ fichier (type="file") est présent
        // ET contient un fichier valide dans la requête HTTP envoyée.
        if($request->hasFile('image'))
        {
            // file : methode qui sert à récupérer le fichier uploadé(qui sera de type UploadedFile)
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = [];
        $gallery_images = "";
        $counter = 1;

        if($request->hasFile('images')) // Vérifie si la requête contient des fichiers sous le champ 'images'
        {
            $allowedFileExtension = ['jpg', 'png', 'jpeg'];  // Extensions autorisées pour l'upload
            $files = $request->file('images');   // Récupère tous les fichiers téléversés (uploadés)
            foreach($files as $file) // Parcours chaque fichier uploadé (téléversé)
            {
                // getClientOriginalExtension : methode de l'objet 'UploadedFile'
                // qui retourne l'extension du fichier telle que fournie par l’utilisateur dans son navigateur
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedFileExtension); // Vérifie si l’extension du fichier est autorisée
                if($gcheck)
                {
                    // Génère un nom de fichier unique avec un timestamp, un compteur et l’extension
                    $gfileName = $current_timestamp . "-" . $counter . "." . $gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName); // Génère la miniature du fichier image (fonction personnalisée)
                    array_push($gallery_arr, $gfileName); // Ajoute le nom du fichier à la liste
                    $counter += 1;  // Incrémente le compteur pour le prochain fichier
                }
            }
            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images; // Attribue les noms des images à la propriété 'images' du produit
        }
        $product->save();
        return redirect()->route('admin.products')->with('status', 'Produit ajouté avec succès!');
    }


    // GenerateProductThumbnailImage
    public function GenerateProductThumbnailImage($image, $imageName)
    {
        $destinationPathTumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');

        // true : permet à Laravel de créer automatiquement les dossiers parents
        // manquants si le chemin est profond.
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        if (!File::exists($destinationPathTumbnail)) {
            File::makeDirectory($destinationPathTumbnail, 0755, true);
        }

        $img = Image::make($image->path());

        $img->fit(540, 689, function ($constraint) {
            $constraint->upsize();
        }, 'top')->save($destinationPath . '/' . $imageName);

        $img->fit(104, 104, function ($constraint) {
            $constraint->upsize();
        }, 'top')->save($destinationPathTumbnail . '/' . $imageName); // 'top' : position de recadrage de l'image
    }

    // PRODUCT_EDIT
    public function product_edit($id)
    {
        $product = Product::find($id);
        $categories = Category::select(['id', 'name'])->orderBy('name')->get();
        $brands = Brand::select(['id', 'name'])->orderBy('name')->get();
        return view('admin.product-edit', compact('product', 'categories', 'brands'));
    }

    // PRODUCT_UPDATE
    public function product_update(Request $request)
    {
            $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,'.$request->id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sale_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => 'mimes:png,jpg,jpeg,webp|max:2080',
            //'images' => 'required|array',
           // 'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id' => 'required',
            'brand_id' => 'required'
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        // $current_timestamp = Carbon::now()->timestamp; // risque de collision si plusieurs utilisateurs téléverse la même image au même momement
        $current_timestamp = Carbon::now()->format('YmdHisv'); // risque de collision quasi impossible

        if($request->hasFile('image'))
        {
            if(File::exists(public_path('uploads/products').'/'.$product->image)) {
                File::delete(public_path('uploads/products').'/'.$product->image);
            }

            if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)) {
                File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
            }
            $image = $request->file('image');
            $imageName = $current_timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->image = $imageName;
        }

        $gallery_arr = [];
        $gallery_images = "";
        $counter = 1;

        if($request->hasFile('images'))
        {
            foreach(explode(',', $product->images) as $ofile)
            {
                if(File::exists(public_path('uploads/products').'/'.$ofile)) {
                    File::delete(public_path('uploads/products').'/'.$ofile);
                }

                if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile)) {
                    File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
                }
            }

            $allowedFileExtension = ['jpg', 'png', 'jpeg'];
            $files = $request->file('images');
            foreach($files as $file)
            {
                $gextension = $file->getClientOriginalExtension();
                $gcheck = in_array($gextension, $allowedFileExtension);
                if($gcheck)
                {
                    $gfileName = $current_timestamp . "-" . $counter . "." . $gextension;
                    $this->GenerateProductThumbnailImage($file, $gfileName);
                    array_push($gallery_arr, $gfileName);
                }
            }
            $gallery_images = implode(',', $gallery_arr);
            $product->images = $gallery_images;
        }
        $product->save();
        return redirect()->route('admin.products')->with('status', 'Produit mise à jour avec succès');
    }


    public function product_delete($id)
    {
        $product = Product::find($id);

        if(File::exists(public_path('uploads/products').'/'.$product->image)) {
            File::delete(public_path('uploads/products').'/'.$product->image);
        }

        if(File::exists(public_path('uploads/products/thumbnails').'/'.$product->image)) {
            File::delete(public_path('uploads/products/thumbnails').'/'.$product->image);
        }

        foreach(explode(',', $product->images) as $ofile)
        {
            if(File::exists(public_path('uploads/products').'/'.$ofile)) {
                File::delete(public_path('uploads/products').'/'.$ofile);
            }

            if(File::exists(public_path('uploads/products/thumbnails').'/'.$ofile)) {
                File::delete(public_path('uploads/products/thumbnails').'/'.$ofile);
            }
        }

        $product->delete();
        return redirect()->route('admin.products')->with('status', 'Produit supprimé avec succès');
    }

}
