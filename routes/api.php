<?php
use Illuminate\Http\Request;
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
      'middleware' => ['auth:api']
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api', 'prefix' => '/'], function () {
  Route::post('/image/store', 'ImageController@store');
  Route::get('/translate', 'TranslatorController@translate');
  
  Route::resource('/word', 'WordController');
  Route::group(['prefix' => 'word'], function () {
    Route::get('/change-important/{wordId}', 'WordController@changeImportant');
    Route::post('/update-image/{wordId}', 'WordController@updateImage');
  });
  
  Route::get('/word-by-category/{id}', 'CategoryController@getAllWordsByCategory');
  
  Route::resource('category', 'CategoryController');
  Route::get('random-word', 'WordController@getRandomWord');
  Route::get('phrases', 'WordController@getAllPhrases');
});


Route::group(['middleware' => ['auth:api', 'isAdmin'], 'prefix' => 'admin'], function () {
      Route::get('/students', 'StudentController@getStudents');
      Route::get('student/{student}', 'StudentController@getOneStudent');
      Route::post('student', 'StudentController@storeStudent');
      Route::put('student/{student}', 'StudentController@updateStudent');
      Route::delete('student/{student}', 'StudentController@deleteOneStudent');
      Route::delete('many-students', 'StudentController@deleteManyStudent');
});

Route::group(['middleware' => ['auth:api', 'isAdminOrSelf'], 'prefix' => 'user'], function () {
      Route::get('/info', function() {
        return "hihi";
      });
});
