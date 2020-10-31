<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Image;
use App\Like;
use App\Comment;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller {
	/*
	 * Control acceso solo ususarios identificado
	 */

	public function __construct() {
		$this->middleware('auth');
	}

	/*
	 * Carga vista form añadir nueva imagen
	 */

	public function create() {
		return view('image.create');
	}

	/*
	 * Guardar nuevas imagenes
	 */

	public function save(Request $request) {

		$method = $request->method();

		if (($request->isMethod('POST')) && ($method == 'POST')) {

			//obtenemos id del usuario identidicado
			$user = Auth::user();
			$idUser = $user->id;

			//* VALIDACION DE CAMPOS
			//Validación
			$validate = $this->validate($request, [
				'description' => 'required',
				'filename' => 'required|image'
			]);

			//* OBTENER DATOS DEL FORM
			//$image_path = $request->file('filename');
			$description = $request->input('description');

			//* ASIGNAR VALORES AL NUEVO OBJETO IMAGE.
			$image = new Image();

			// Seteamos valores.
			$image->user_id = $idUser;
			$image->image_path = null;
			$image->description = $description;


			//* GUARDAR IMAGEN.
			if ($request->hasFile('filename')) { //* Validacion is_file.
				//* Recogemos datos del form
				$image_path = $request->file('filename');

				if ($image_path) {

					//* Nombre unico 
					$fileName_unique = time() . "_" . $image_path->getClientOriginalName();

					//* Almacenamos imagen en el servidor, 
					//* Obtenemos la imagen recogida del form con el metodo estatico get() 
					Storage::disk('images')->put($fileName_unique, File::get($image_path));

					//* Seteamos el objeto 
					$image->image_path = $fileName_unique;

					//var_dump($image); die();
					//almacenamos valores en la BD con el metodo save()
					$image->save();

					return redirect()->route('home')
									->with(['message' => 'Tu imagen se subio correctamente']);
				} else {
					//* Obj $imagen null
					return redirect()->route('image.create')
									->with(['message' => 'Error.No se pudo subir la nueva imagen, por favor vuelve a intentarlo']);
				}
			} else {
				// NOT TYPE FILE
				return redirect()->route('image.create')
								->with(['message' => 'Error.No se pudo subir la nueva imagen, revise el formato, por favor vuelve a intentarlo']);
			}
		} else {
			// no llegan parametros por POST
			return redirect()->route('image.create')
							->with(['message' => 'Error.No se pudo subir la nueva imagen, por favor vuelve a intentarlo']);
		}
	}

	//* Obtener la imagenes publicadss del usuario(usada para lista img home)
	public function getImage($filename) {

		//* obtenememos la imagen del disco storage
		$file = Storage::disk('images')->get($filename);

		// devolvemos el resultado en una response
		return new Response($file, 200);
	}

	/*
	 * Obtener detalle imagen
	 */

	public function detail($id) {

		$image = Image::find($id);

		return view('image.detail', [
			'image' => $image
		]);
	}

	/*
	 * Eliminar imagen o publicacion
	 */

	public function delete($id) {

		//Obtener registros
		$id = (int) $id;
		$user = \Auth::user();
		$user_id = $user->id;
		$image = Image::find($id);

		//1º MANERA -> No me funciona
//		$comments = Comment::where('image_id', $id)->get(); // No me funciona me saca un obj vacio
//		$likes = Like::where('image_id', $id)->get();
		//* Validamos que las variables no llegan empty y comprobamos que el usuario es el
		//* propietario de la publicacion
		if ($user && $image && ($image->user->id == $user_id )) {

			// ELIMINAR COMENTARIOS
			$matchTheseComments = ['image_id' => $id];
			$comments = DB::table('comments')->where($matchTheseComments)->count();

			//var_dump($comments); die();
			if ($comments && $comments >= 1) {
				$comments_delete = DB::table('comments')->where($matchTheseComments)->delete();
				
				if ($comments_delete == false) {

					//error al delete comments
					$message = array('message-error' => 'Error. Comments not delete.');
					
					return redirect()->route('home')->with($message);
				}
			}


			// ELIMINAR LIKES
			$matchTheseLikes = ['image_id' => $id];
			$likes = DB::table('likes')->where($matchTheseLikes)->count();

			if ($likes && $likes >= 1) {
				$likes_delete = DB::table('likes')->where($matchTheseComments)->delete();

				if ($likes_delete == false) {

					//error al delete likes
					$message = array('message-error' => 'Error.Likes not deleted.');
					return redirect()->route('home')->with($message);
				}
			}


			// Eliminar ficheros de imagen
			Storage::disk('images')->delete($image->image_path);

			// Eliminar registro imagen
			$delete = $image->delete();

			if ($delete) {
				// delete ok
				$message = array('message-ok' => 'La imagen se ha borrado correctamente.');
			} 
			else {
				// error al efectuar el delete
				$message = array('message-error' => 'Error.La imagen no se ha borrado, por favor vuelve a intentarlo.');
			}
		} else {
			$message = array('message-error' => 'La imagen no se ha borrado, por favor vuelve a intentarlo.');
		}


		return redirect()->route('home')->with($message);
	}

	//* EDITAR PUBLICACION
	public function edit($id) {

		//Usuario identificado
		$user = \Auth::user();
		$user_id = $user->id;

		//Obtener publicacion a editar
		$image = Image::find($id);

		// Validamos que existe el ususario identificado, la imagen buscada, y ademas
		// sea el propietario de la publicacion
		if ($user && $image && ($image->user->id == $user->id)) {

			return view('image.edit', [
				'image' => $image
			]);
		} 
		else {
			return redirect()->route('home');
		}
	}

	// ACTUALIZAR PUBLICACION
	public function update(Request $request) {

		$method = $request->method();
		if (($request->isMethod('POST')) && ($method == 'POST')) {

			//VALIDACION
			$validate = $this->validate($request, [
				'description' => 'required',
				'filename' => 'image'
			]);

			//* OBTENER DATOS DEL FORM
			$description = $request->input('description');
			$image_id = (int) $request->input('image_id');
			$image_path = $request->file('filename');


			//OBTENER IMAGEN PARA UPDATE
			$image = Image::find($image_id);
			$image->description = $description;

			// Subir fichero si la img nos llega not null
			if ($image_path) {

				//echo " image_path NOT NULL"; die();
				// eliminar imagen del storage
				Storage::disk('images')->delete($image->image_path);

				// nombre unico
				$image_path_name = time() . "_" . $image_path->getClientOriginalName();

				// almacenar storage
				Storage::disk('images')->put($image_path_name, File::get($image_path));

				// setear objeto con el nuevo path
				$image->image_path = $image_path_name;
			}


			// Actualizar registro
			$update = $image->update();

			//Validar update
			if ($update) {
				return redirect()->route('image.detail', ['id' => $image_id])
								->with(['message' => 'Publicacion actualizada con exito']);
			} 
			else {
				// error
				return redirect()->route('image.detail', ['id' => $image_id])
								->with(['message-error' => 'Error. La publicacion no pudo actualizarse, por favor vuelve a intentarlo ']);
			}
		} 
		else {
			// error al enviar form
			return redirect()->route('image.detail', ['id' => $image_id])
							->with(['message-error' => 'Error. La publicacion no pudo actualizarse, por favor vuelve a intentarlo ']);
		}
	}

}
