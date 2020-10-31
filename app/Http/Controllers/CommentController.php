<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;


class CommentController extends Controller {
	/*
	 * Control acceso solo ususarios identificado
	 */

	public function __construct() {
		$this->middleware('auth');
	}

	/*
	 * Guardar nuevos comentarios
	 */
	public function save(Request $request) {
		
		$method = $request->method();
		$image_id = $request->input('image_id'); // cast to Int
	
		if ($request->isMethod('POST') && $method == 'POST') {

			// Validación de campos.
			$validate = $this->validate($request, [
				
				'image_id' => 'integer|required',
				'content' => 'required|string' 
			]);
			
			//recoger datos del form.
			$user = \Auth::user();
			$user_id = $user->id;
			$content = $request->input('content');
			$image_id =(int) $request->input('image_id');
			
			
			//instanciamos nuevo objeto.
			$comment = new Comment();
			
			// Set propiedades del objeto.
			$comment->user_id = $user_id;
			$comment->content = $content;
			$comment->image_id = $image_id;
			
			//var_dump($comment); die();
			
			$save = $comment->save();
			
			if ($save) {
				return redirect()->route('image.detail', ['id' => $image_id])
								 ->with([
									 'message' => 'Tu comentario se ha publicado correctamente'
								]);
			}
			else{
				// error al guardar comentario.
				return redirect()->route('image.detail', ['id' => $image_id])
								 ->with([
									 'message-error' => 'Error.Tu comentario no se ha publicado, por favor vuelve a intentarlo'
								]);
			}

		} 
		else {

			//no llegan parametros por post del form, error.redirecc al detalle de imagen.
			return redirect()->route('image.detail', ['id' => $image_id])
							->with(['message-error' => 'Error. No se pudo enviar el comentario, por favor vuelve a intentarlo']);
		}

		
	}
	
	
	/*
	 * Eliminar comentario si somos propietarios de la img publicada o si somos el propietario
	 * del comentario
	 */
	public function delete($id) {
		
		// Conseguir datos del usuario logueado
		$user = \Auth::user();
		$user_id = $user->id;
		
		// Conseguir objeto del comentario
		$comment = Comment::find($id);
		
		//var_dump($comment); die();
		//var_dump($comment->id); die();
		
		//var_dump($comment->user); die();
		//var_dump($comment->user->name); die();
		
		//var_dump($comment->image); die();
		//var_dump($comment->image->image_path); die();
		
		
		// Comprobar si estamos logueado y ademas (si soy el dueño del comentario o de la publicación)
		if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
			
			 $delete = $comment->delete();
			
			if ($delete) {
				return redirect()->route('image.detail', ['id' => $comment->image->id])
								 ->with(['message' => 'El comentario se ha eliminado correctamente ']);
				
			}else{
				// error delete
				return redirect()->route('image.detail', ['id' => $comment->image->id])
							 ->with(['message-error' => 'Error.El comentario no se pudo eliminar']);
			
			}
		}
		else {
			//el usuario no es dueño del comentario ni de la publicacion
			return redirect()->route('image.detail', ['id' => $comment->image->id])
							 ->with(['message-error' => 'Error.El comentario no se pudo eliminar debes ser el propietario del comentario o de la publicacion']);
			
		}
	
	}
}
