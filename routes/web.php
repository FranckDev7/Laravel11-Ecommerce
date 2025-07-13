<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * Une façade dans Laravel est une classe qui fournit un accès statique à une instance d’un service
 * enregistré dans le conteneur de services de Laravel.
 * Un accès statique, c’est quand on fait appelle à une méthode sans avoir besoin de créer
 * une instance (objet) de la classe.
 *
 * routes : méthode statique fournie par la façade Auth qui déclare automatiquement
 * toutes les routes nécessaires pour l’authentification utilisateur de base.
 *
 */
Auth::routes();

/**
 * Sans utilisation de la facade ('Auth'), on serai obliger de réécrire manuellement toutes ces routes ci-dessous
 *
 * // Routes de Connexion (Login/Logout)
 *
 * - Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
 * - Route::post('login', [LoginController::class, 'login']);
 * - Route::post('logout', [LoginController::class, 'logout'])->name('logout');
 *
 * // Routes d'Inscription (Register)
 *
 * Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
 * Route::post('register', [RegisterController::class, 'register']);
 *
 * // Routes de Réinitialisation de mot de passe
 *
 * Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
 * Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
 * Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
 * Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
 *
 *
 * // Routes de Confirmation du mot de passe
 *
 * Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
 * Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);
 *
 *
 * // Routes de Vérification d’adresse e-mail
 *
 * Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
 * Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify')->middleware(['signed']);
 * Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
 *
 *
 * // Route d'accueil (exemple)
 *
 * Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 *
 */




// Routes non sécurisées

// Route d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Route pour la boutique
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

// Routes d'instance ('cart') du panier
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');

// Route d'instance ('wishlist') du panier
Route::post('/wishlist/add', [WishListController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}', [WishListController::class, 'remove_item'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WishListController::class, 'empty_wishlist'])->name('wishlist.items.clear');
Route::post('/wishlist/move-to-cart/{rowId}', [WishListController::class, 'move_to_cart'])->name('wishlist.move.to.cart');

// Routes protegées par le middleware('auth') pour acceder au contrôleur 'UserController'
Route::middleware('auth')->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

// Routes protegées par le middleware('auth') pour acceder au contrôleur AdminController'
Route::middleware('auth')->group(function(){

    // Brands (marques)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');

    // Categories (Catégories)
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    // Products (Produits)
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/{id}/edit', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.product.delete');

});



