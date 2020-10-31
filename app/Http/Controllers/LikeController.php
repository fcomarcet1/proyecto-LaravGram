<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;

class LikeController extends Controller {
	/*
	 * Control acceso solo ususarios identificados
	 */

	public function __construct() {
		$this->middleware('auth');
	}

	/*
	 * OBTENER LISTADO PUBLICACIONES QUE LE DIMOS LIKE
	 */

	public function index() {

		$user = \Auth::user();
		$user_id = $user-> id;
		
		// obtener todos los likes del usuario identificado
		$likes = Like::where('user_id', $user_id)
					    ->orderBy('id', 'desc')
						->paginate(4);

		//renderizamos vista
		return view('like.index', [
			'likes' => $likes
		]);
	}

	/*
	 * METODOS FUNCIONALIDAD PULSAR BOTON LIKE like($image_id), dislike($image_id)
	 */

	public function like($image_id) {

		//*Obtener datos del usuario
		$user = \Auth::user();
		$user_id = $user->id;

		//*Validar que el like no existe en la BD.
		//* Consulta tbl likes where id_user=$id_user AND image_id=$image_id
		$isset_like = Like::where('user_id', '=', $user_id)
				->where('image_id', '=', $image_id)
				->count();

		if ($isset_like == 0) {

			//Setear valores obj
			$like = new Like();
			$like->user_id = $user_id;
			$like->image_id = (int) $image_id;


			//guardar datos
			$save = $like->save();
			//var_dump($like); die();

			if ($save) {
				// insert Ok devolvemos Json para manipularlo con AJAX
				return response()->json([
							'like' => $like,
							'message' => 'Has dado like!!'
				]);
			} else {
				//error al guardar datos en la bd
				return redirect()->route('image.detail', ['id' => $image_id]);
			}
		} else {
			//Ya existe el like en la BD devolvemos Json 
			return response()->json([
						'message' => 'El like ya existe!!'
			]);
		}
	}

	public function dislike($image_id) {

		//*Obtener datos del usuario
		$user = \Auth::user();
		$user_id = $user->id;

		//Obtener registro del like
		$like = Like::where('user_id', '=', $user_id)
				->where('image_id', '=', $image_id)
				->first();

		if ($like) {
			//eliminamos registro like de la BD
			$delete = $like->delete();

			if ($delete) {
				//Delete OK
				return response()->json([
							'like' => $like,
							'message' => 'Has dado dislike!!!'
				]);
			} else {
				// Error al efectuar delete() en la BD
				return redirect()->route('image.detail', ['id' => $image_id]);

				$image->likes;
			}
		} else {
			//No exixte registro en la BD
			return response()->json([
						'message' => 'El like no existe'
			]);
		}
	}

}
