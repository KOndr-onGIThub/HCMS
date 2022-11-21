<?php

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

//stránky vyžadující přihlášeného uživatele
Route::group(['middleware' => 'auth'], function () 
{


//stránka využadující ACL pojmenouvanou jako ...
Route::get('Hotcall', 'HotcallController@index')->middleware('can:see-anything');
Route::post('Hotcall', 'HotcallController@store')->middleware('can:send-hotcall');
Route::get('Hotcall/find/{id}', 'HotcallController@loadToUpdate')->middleware('can:send-hotcall');
Route::post('Hotcall/ajax-request', 'HotcallController@updateINFO')->middleware('can:send-hotcall');
Route::get('HotcallFinished/{id}/{time}', 'HotcallController@update')->middleware('can:send-hotcall');

Route::get('OrderSumm', 'SummaryController@index')->middleware('can:see-anything');

Route::post('History', 'HistoryController@index' )->name('HistoryPOST')->middleware('can:see-anything');
Route::get('History', 'HistoryController@index')->name('HistoryGET')->middleware('can:see-anything');
Route::get('divert', 'divertController@index')->middleware('can:see-anything');
Route::get('redpost', 'redpostController@index')->middleware('can:see-anything');
Route::get('getDockData', 'getDockDataController@getDockData')->middleware('can:see-anything');
Route::get('getModelToyota', 'getModelToyotaController@getModelToyota')->middleware('can:see-anything');
Route::get('reoccurHotcall/{kbn}', 'ReoccurHotcallController@reoccurHotcall')->middleware('can:see-anything');

});

Route::get('HotcallData', 'HotcallController@data');

Route::get('TabletScreen', 'TabletScreenController@tabletSelection');
Route::get('TabletScreen/{tabletName}', 'TabletScreenController@index');
Route::get('statusChange/{id}/{status}/{time}/{delivered}/{remaining}', 'TabletScreenController@status');

Route::get('csvDaico', 'daicoCsvController@store');
Route::get('getCsvDaicoData', 'getCsvDaicoDataController@getCsvDaicoData');
Route::get('csvPartrqdb', 'partrqdbCsvController@store');
Route::get('getCsvPartrqdbData/{pn12digit}', 'getCsvPartrqdbDataController@getCsvPartrqdbData');





Route::get('login', 'auth\LoginController@login')->name('login');
Route::get('logout', 'auth\LoginController@logout')->name('logout');
Route::post('authenticate', 'auth\LoginController@authenticate')->name('authenticate');