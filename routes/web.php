<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/',  [GuestHomeController::class, 'index']);

Route::get('/home', [ProjectController::class, 'index'])->middleware('auth')->name('home');

Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(
        function() {       
            //L'ordine delle Route qui è importante   

            //soft deletes e trash per projects resource
            Route::get('/projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
            Route::put('/projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
            Route::delete('/projects/{project}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.force-delete');
            
            //projects resource
            Route::resource('projects', ProjectController::class)
                ->parameters(['projects' => 'project:slug']); //così per tutta la risorsa si usa slug al posto dell' id (va bene solo se slug è unico). Per risorsa projects usi slug di project(singolare)

            //types resource
            Route::resource('types', TypeController::class)->except(['show']);
        }
    );

Route::middleware('auth')
    ->prefix('profile') //tutti gli url hanno il prefisso /profile
    ->name('profile.') //tutti i nomi delle rotte hanno il prefisso profile. (profile.edit, profile.update, profile.destroy)
    ->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';