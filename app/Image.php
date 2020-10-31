<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

	//*Indicamos con que tabla va a trabajar el modelo */
	protected $table = 'images';

	//* Una imagen puede tener muchos comentarios 1:N [One To Many]*/ 
	//** Obtener todos los comentarios asociados a una imagen  */
	public function comments() {
		//** Median el id_image de comentario y va a obtener el array de los comentarios  */
		//** Haremos un comments(5) y obtendremos los comentarios cuyo id_image es 5 */
		return $this->hasMany('App\Comment')->orderBy('id', 'desc');
	}

	//* Una imagen puede tener muchos likes 1:N [One To Many]*/ 
	//** Obtener todos los likes asociados a una imagen id = image_id */
	public function likes() {
		return $this->hasMany('App\Like');
	}

	//* Muchas imagenes puede ser de un unico user N:1 [Many to One]*/
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	//delete publicacion, con sus likes y comments asociados
//	public static function boot() {
//		parent::boot();
//
//		static::deleting(function ($images) {
//			$images->likes()->each(function ($likes) {
//				$likes->delete();
//			});
//			$images->comments()->each(function ($comments) {
//				$comments->delete();
//			});
//			Storage::disk('images')->delete($image->image_path);
//		});
//	}

}
