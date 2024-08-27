<?php

use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\MyOrdersDetailPage;
use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Models\Product;
use Illuminate\Support\Facades\Route;




Route::get('/', HomePage::class)->name('livewire.Home');

Route::get('/categories', CategoriesPage::class);

Route::get('/products', ProductsPage::class);

Route::get('/cart', CartPage::class);

Route::get('/products/{slug}', ProductDetailPage::class);//(slug === id) into page ProductDetailPage

Route::get('/checkout', CheckoutPage::class);

Route::get('/my-orders', MyOrdersPage::class);

Route::get('/my-orders/{order}', MyOrdersDetailPage::class);

Route::get('/login', LoginPage::class);

Route::get('/register', RegisterPage::class);

Route::get('/forgot', ForgotPasswordPage::class);

Route::get('/reset', ResetPasswordPage::class);

Route::get('/cancel', CancelPage::class);

Route::get('/Success', SuccessPage::class);

