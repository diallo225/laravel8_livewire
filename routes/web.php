<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ConversationController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobs',[JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}',[JobController::class, 'show'])->name('jobs.show');



Route::group(['middleware'=> ['auth']], function(){
    Route::get('/home', function(){ return view('home'); } )->name('home');
    Route::get('/comfirmProposal/{proposal}', [ ProposalController::class, 'comfirm'])->name('confirm.proposal');
    Route::get('/conversations', [ ConversationController::class, 'index'])->name('conversation.index');
    Route::get('/conversations/{conversation}', [ ConversationController::class, 'show'])->name('conversation.show');

});



Route::group(['middleware'=> ['auth','proposal']], function(){
    Route::post('/submit/{job}', [ProposalController::class, 'store'])->name('proposals.store');

});
