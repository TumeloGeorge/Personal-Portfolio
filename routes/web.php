<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminHeroController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\Admin\AdminExperienceController;
use App\Http\Controllers\Admin\AdminCertificationController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminMessagesController;

// ──────────────────────────────────────────────────────────────
// PUBLIC PORTFOLIO
// ──────────────────────────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ──────────────────────────────────────────────────────────────
// ADMIN CMS
// ──────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth routes — no middleware, controller handles own redirects
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout',[AdminAuthController::class, 'logout'])->name('logout');

    // All CMS routes — protected by our custom admin.auth middleware
    Route::middleware('admin.auth')->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Settings (single record)
        Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        // Hero (single record)
        Route::get('/hero', [AdminHeroController::class, 'edit'])->name('hero.edit');
        Route::put('/hero', [AdminHeroController::class, 'update'])->name('hero.update');

        // Skill categories
        Route::get('/skills/categories/create',         [AdminSkillController::class, 'createCategory'])->name('skills.categories.create');
        Route::post('/skills/categories',               [AdminSkillController::class, 'storeCategory'])->name('skills.categories.store');
        Route::get('/skills/categories/{category}/edit',[AdminSkillController::class, 'editCategory'])->name('skills.categories.edit');
        Route::put('/skills/categories/{category}',     [AdminSkillController::class, 'updateCategory'])->name('skills.categories.update');
        Route::delete('/skills/categories/{category}',  [AdminSkillController::class, 'destroyCategory'])->name('skills.categories.destroy');

        // Skills
        Route::get('/skills',              [AdminSkillController::class, 'index'])->name('skills.index');
        Route::get('/skills/create',       [AdminSkillController::class, 'create'])->name('skills.create');
        Route::post('/skills',             [AdminSkillController::class, 'store'])->name('skills.store');
        Route::get('/skills/{skill}/edit', [AdminSkillController::class, 'edit'])->name('skills.edit');
        Route::put('/skills/{skill}',      [AdminSkillController::class, 'update'])->name('skills.update');
        Route::delete('/skills/{skill}',   [AdminSkillController::class, 'destroy'])->name('skills.destroy');

        // Experiences
        Route::resource('experiences', AdminExperienceController::class)->except(['show']);

        // Certifications
        Route::resource('certifications', AdminCertificationController::class)->except(['show']);

        // Projects
        Route::resource('projects', AdminProjectController::class)->except(['show']);

        // Messages
        Route::get('/messages',             [AdminMessagesController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}',   [AdminMessagesController::class, 'show'])->name('messages.show');
        Route::delete('/messages/{message}',[AdminMessagesController::class, 'destroy'])->name('messages.destroy');
    });
});