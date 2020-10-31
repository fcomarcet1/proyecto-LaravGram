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
//use App\Image;

Route::get('/', function () {
    
    /*
    //*OBTENER TODAS LAS IMAGENES
    $images = Image::all();
    foreach ($images as $image) {

        //var_dump($image);
        echo "<h3>Nombre: $image->image_path</h3>";
        echo "<h3>Descripcion: $image->description</h3>";
        //*OBTENER USUARIO QUE HA CREADO LA FOTO(Nos valemos de las relaciones que implementamos 
        //* en el ORM).Los metodos que hemos creado en las relaciones ahora podemos acceder como    propiedades del objeto $image->user->name
        //* 
        //var_dump($image->user);
        echo "<h3>Creada por:".$image->user->name." ".$image->user->surname. "</h3>";
        //*OBTENER LOS COMENTARIOS D CADA IMAGEN 
        if( sizeof($image->comments) >= 1 ){
            $comentarios = $image->comments;
            echo "<strong>Comentarios</strong></br>";
            foreach ($comentarios as $comment) {
                echo $comment->content ."</br>";
                //* OBTENER QUE USUARIO HIZO EL COMENTARIO
                echo "<h3>comentado por:".$comment->user->name." ".$comment->user->surname. "</h3>";
            }
        }

        echo"LIKES:".count($image->likes);
        echo "<hr/>";
    }
    die();
    */
    

    return view('welcome');
});

//RUTAS GENERALES
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');


//* USUARIO
// muestra form de actualizar usuario
Route::get('/configuracion','UserController@config')->name('config');
// enviar datos update user
Route::post('/user/update','UserController@update')->name('user.update');
// perfil
Route::get('/profile/{id}','UserController@profile')->name('profile');
// listado de usuarios de la aplicacion
Route::get('/gente/{search?}', 'UserController@index')->name('user.index');

//listado busqueda usuarios
Route::post('/user/search','UserController@search')->name('user.search');


//* IMAGEN
// Obtener imagen avatar
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
//form añadir imagen
Route::get('/image-upload','ImageController@create')->name('image.create');
// enviar datos form añadir nueva imagen
Route::post('/image/save','ImageController@save')->name('image.save');
// Obtener listado imagenes en home 
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
// Obtener detalle imagen
Route::get('/imagen/{id}', 'ImageController@detail')->name('image.detail');
//Eliminar imagen
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');
//Editar imagen
Route::get('/image/edit/{id}', 'ImageController@edit')->name('image.edit');
//Actualizar publicacion/Imagen
Route::post('/image/update','ImageController@update')->name('image.update');


//* COMENTARIOS
// Enviar nuevo comentario
Route::post('/comment/save','CommentController@save')->name('comment.save');
// Eliminar comentario
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');


//* LIKES
// Almacenar nuevo like
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
//Dislike
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');
// listado de las publicaciones que he dado like
Route::get('/likes', 'LikeController@index')->name('like.likes');
