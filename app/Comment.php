<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	//*Indicamos con que tabla va a trabajar el modelo */
	protected $table = 'comments';

	//* Muchas comentarios puede ser de un unico user N:1 [Many to One]*/ 
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

	//* N:1 [Many to One]*/  */
	public function image() {
		return $this->belongsTo('App\Image', 'image_id');
	}

}
