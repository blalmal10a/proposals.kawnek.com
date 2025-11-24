<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\UserController;
use App\Livewire\LandingPage;
use App\Livewire\Proposal;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPage::class);
Route::get('user-morph-one-image', [UserController::class, 'morph_one'])->name('demo.user.index');
Route::get('images/{id}', [ImageController::class, 'getMedia']);

Route::redirect('redirect-login', '/admin/login')->name('login');
Route::get('proposal/{project}', Proposal::class)->name('proposal');
Route::view('holiday-palace-proposal', 'holiday-palace-proposal');
