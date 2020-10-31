<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // cargamos storage para almacenar la imagen
use Illuminate\Support\Facades\File; // cargamos File para obtener la imagen en su guardado
use Illuminate\Http\Response; // cargamos para devolver la imagen a cargar como avatar como response
use App\User;
use App\Image;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Auth

class UserController extends Controller {

	//Control acceso solo ususarios identificados
	public function __construct() {
		$this->middleware('auth');
	}

	//Listado de usuarios de la aplicacion + Buscador
	public function index() {

		// Obtener todos los usuarios
		$users = User::orderBy('id', 'desc')->paginate(5);

		return view('user.index', [
			'users' => $users
		]);
	}

	//* carga vista con el form de modif datos personales
	public function config() {
		return view('user.config');
	}

	//* actualizar datos del usuario
	public function update(Request $request) {

		//$method = $request->method(); //POST

		if ($request->isMethod('POST')) {

			//* conseguir usuario identificado
			$user = \Auth::user();
			//$id = \Auth::user()->id; 
			$id = $user->id;


			//* Validacion de campos
			$validate = $this->validate($request, [
				'name' => 'required|string|max:255',
				'surname' => 'required|string|max:255',
				'nick' => 'required|string|max:255|unique:users,nick,' . $id,
				'email' => 'required|string|email|max:255|unique:users,email,' . $id,
				'image' => 'mimes:jpeg,jpg,png,gif',
			]);


			//* Recogemos datos del form
			// si no usamos \Auth::user() con la barra error no encuentra la clase a no ser que carguemos
			// la clase
			$name = $request->input('name');
			$surname = $request->input('surname');
			$nick = $request->input('nick');
			$email = $request->input('email');

			//var_dump($id, $name);die();
			//* Asignar nuevos valores al objeto del usuario, al ser propiedades publicas
			//*  podemos asignarles directamente el valor.
			$user->name = $name;
			$user->surname = $surname;
			$user->nick = $nick;
			$user->email = $email;

			//** ALMACENAR IMAGEN AVATAR
			//Comprobamos que llega la imagen en formato file
			if ($request->hasFile('image')) { //check file is getting or not..
				// Almacenamos la imagen
				$image = $request->file('image');

				//comprobamos que el objeto image no es null
				if ($image) {

					// Obtenemos un nombre de imagen unico
					$image_path_unique = time() . "_" . $image->getClientOriginalName();

					//Obtenemos la imagen con el metodo estatico get() de la clase File
					$image_to_save = File::get($image);

					//Usamos la clase storage y su metodo estatico disk para almacenar la imagen 
					// con el metodo put en storage/users/avatar
					Storage::disk('users')->put($image_path_unique, File::get($image));

					//Setear imagen para el update con el nombre unico
					// Auth::user()->image = $user SIMILAR $user->image
					$user->image = $image_path_unique;
				}
			}
			//* ejecutar consulta y cambios en la BD
			$update = $user->update();

			if ($update) {
				return redirect()->route('config')
								->with(['message-ok' => 'Usuario actualizado correctamente']);
			} else {
				return redirect()->route('config')
								->with(['message-error' => ' Error. No se actualizaron '
									. 'tus datos por favor vuelve a intentarlo']);
			}
		} else {

			return redirect()->route('config')
							->with(['message-error' => ' Error. No se actualizaron tus datos por favor vuelve a intentarlo']);
		}
	}

	//* Obtener la imagen del usuario(usada para avatar)
	public function getImage($filename) {

		//* obtenememos la imagen del disco storage
		$file = Storage::disk('users')->get($filename);

		// devolvemos el resultado en una response
		return new Response($file, 200);
	}

	//Perfil de usuario
	public function profile($id) {

		$id = (int) $id;

		$user = User::find($id);
		$images = DB::table('images')->where('user_id', '=', $id)
				->orderBy('id', 'desc')
				->get();

		//var_dump($images);die();

		return view('user.profile', [
			'user' => $user,
			'images' => $images
		]);
	}

	//buscador de usuarios
	public function search(Request $request) {

		$search = $request->input('search');
//		var_dump($search);
//		die();

		// CON LA VALIDACION TENEMOS ERROR AL NO INTRODUCIR NADA MEJOR SIN ELLA
//		//* Validacion de campos
//		$validate = $this->validate($request, [
//			'search' => 'string|max:255',
//		]);

		if (!empty($search)) {
			
			$users = User::where('nick', 'LIKE', '%' . $search . '%')
					->orWhere('name', 'LIKE', '%' . $search . '%')
					->orWhere('surname', 'LIKE', '%' . $search . '%')
					->orderBy('id', 'desc')
					->paginate(5);
		}else{
			$users = User::orderBy('id', 'desc')->paginate(5);
		}

		

		return view('user.search', [
			'users' => $users
		]);
	}

}
