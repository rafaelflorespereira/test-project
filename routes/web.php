<?php
use App\Mail\SubjectMessage;
use Illuminate\Support\Facades\Route;

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
    return view('project');
});

Route::post('/test-table', 'CSVFileController@storeFile')->name('storeFile');

// Route for e-mail
Route::get('send-mail/{subject}/{message}/{email}', function($subject, $message, $email) {
    // ADD specific e-mail
    Mail::to($email)->send(new SubjectMessage($subject, $message));
    return redirect('/')->with(['email' => 'e-mail sent']);
});