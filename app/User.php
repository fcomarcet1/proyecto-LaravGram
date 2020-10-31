<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'surname', 'nick', 'role', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	//** Obtener todas las imagenes de un usuario */
	public function images() {
		return $this->hasMany('App\Image');
	}
	
	/* PARA OBTENER nº likes y comments*/
	public function comments() {
		return $this->hasMany('App\Comment');
	}
	
	public function likes() {
		return $this->hasMany('App\Like');
	}

}
