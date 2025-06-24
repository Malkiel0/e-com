<?php

use App\Livewire\Admin\Products;
use App\Livewire\Admin\Promotions;
use App\Livewire\Admin\Categories;
use App\Livewire\Client\Dashboar as ClientDashboar;
use App\Livewire\Admin\Dashboar as AdminDashboar;
use App\Livewire\Client\Parfums;
use App\Livewire\Client\ProduitsId;
use App\Livewire\Client\Panier;
use App\Livewire\Client\ProduitsDeBeauté;
use Illuminate\Support\Facades\Route;


Route::get('/', ClientDashboar::class);

Route::get('dashboard', AdminDashboar::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('products', Products::class)->name('createProduct');
Route::get('categories', Categories::class)->name('createCategory');
Route::get('promotions', Promotions::class)->name('promotions');
Route::get('parfums', Parfums::class)->name('parfums');
Route::get('produits/{id}', ProduitsId::class)->name('produitsId');
Route::get('panier', Panier::class)->name('panier');
Route::get('produitsDeBeauté', ProduitsDeBeauté::class)->name('produitsDeBeauté');
Route::get('tous les produits',ClientDashboar::class)->name('tous les produits');
require __DIR__.'/auth.php';
