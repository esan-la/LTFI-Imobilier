<?php


use Illuminate\Support\Facades\Route;
use App\Models\Article;
use App\Models\Client;
use App\Models\Duree_location;
use App\Models\Location;
use App\Models\Paiement;
use App\Models\Propriete_article;
use App\Models\Statut_location;
use App\Models\Tarification;
use App\Models\Type_article;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Utilisateurs;
use App\Http\livewire\TypeArticleComp;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Le route des groupes relative à l'administrateur
Route::group([
    "middlewere" => ["auth", "auth.admin"],
    "as" => "admin.",
], function(){

    // Gestion des habilitations
    Route::group([
        "prefix" => "habilitations",
        "as" => "habilitations."
    ], function(){
        Route::get("/utilisateurs", Utilisateurs::class)->name("users.index");

        //admin.habilitations.users.index
    });

    //Gestion d'article
    Route::group([
        "prefix" => "gestarticles",
        "as" => "gestarticles."
    ], function(){
        Route::get("/gestarticles", TypeArticleComp::class)->name("typearticles");

    });
});

//Route::get('/habilitations/utilisateurs', [App\Http\Controllers\UserController::class, 'index'])
//->name('utilisateurs')
//->middleware("auth.admin");
