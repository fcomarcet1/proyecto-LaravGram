@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

			@include('includes.messageOk')
			@include('includes.messageOkError')

			<!--			 card you are logged-in
						<div class="card">
							<div class="card-header">Dashboard</div>
							<div class="card-body">
								@if (session('status'))
								<div class="alert alert-success" role="alert">
									{{ session('status') }}
								</div>
								@endif
								You are logged in!
							</div>º
						</div>-->
			<!-- end card you are logged-in -->

			<!--	 Image list -->
			<div class="card promoting-card">
				<div class="card-header d-flex flex-row">

					@if($image->user->image)
						<img src="{{route('user.avatar',['filename'=>$image->user->image])}}"
							 id="preview" class="rounded-circle mr-3" height="50px" width="50px" alt="avatar"/>
						<div class="mask rgba-white-slight"></div>
					@endif
					<div>
						<a href="{{route('profile',[$image->user->id])}}" class="card-title font-weight-bold mb-2">
							{{$image->user->name." ".$image->user->surname." | @".$image->user->nick}}
						</a>				
						<p class="card-text">Posted:{{ \FormatTime::LongTimeFilter($image->created_at) }} </p>

					</div>
				</div>
				<div class="card-body">

					<!-- Card image -->
					<div class="image-container">
						<img class="card-img-top rounded-0" src="{{ route('image.file',['filename' => $image->image_path]) }}"  alt="Card image cap">
						<a href="#!">
							<div class="mask rgba-white-slight"></div>
						</a>
					</div>

					<!-- description -->
					<div class="description">

						<div class="likes">

							<!--COMPROBAR SI EL USUARIO DIO LIKE -->
							<?php $user_like = false; ?>

							<!-- Recorremos los likes y comprobamos si coincide con el 
								 ususario identificado -->
							@foreach($image->likes as $like)
								@if($like->user->id == Auth::user()->id)
									<?php $user_like = true; ?>
								@endif
							@endforeach

							{{count($image->likes)}} 
							@if($user_like)
								<img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike"/> 
							@else
								<img src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}" class="btn-like"/>
							@endif	

						</div>

						<a href="">{{"@".$image->user->nick}}</a>

						@if( (Auth::check()) && (Auth::user()->id == $image->user->id) )
						<div class="actions">
							<a href="{{route('image.edit', ['id' => $image->id])}}" class="btn btn-sm btn-primary">Editar publicacion</a>

							<!-- Modal delete image -->
							<!-- Button to Open the Modal -->
							<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">
								Eliminar publicacion
							</button>
							<!-- The Modal -->
							<div class="modal" id="myModal">
								<div class="modal-dialog">
									<div class="modal-content">

										<!-- Modal Header -->
										<div class="modal-header">
											<h4 class="modal-title">Eliminar publicacion</h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>

										<!-- Modal body -->
										<div class="modal-body">
											¿Deseas borrar definivamente la publicacion?
										</div>

										<!-- Modal footer -->
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" data-dismiss="modal">
												Cancelar
											</button>
											<a href="{{route('image.delete', ['id'=> $image->id])}}" class="btn btn-danger">
												Eliminar publicacion
											</a>
										</div>

									</div>
								</div>
							</div>
							<!--  end Modal -->
						</div>
						@endif

						<hr/>
						<p class="description-coment">{{$image->description}}<p>
					</div>


					<!-- Card footer -->
				</div>
				<div class="card-footer">

					<h4 class="detail-comments">
						Comentarios({{count($image->comments)}})
					</h4>
					<hr/>

					<form method="POST" action="{{route('comment.save')}}">
						@csrf
						<input type="hidden" name="image_id" value="{{$image->id}}" />

						<p>
							<textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content"></textarea>
							@if($errors->has('content'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('content') }}</strong>
							</span>
							@endif
						</p>

						<input type="submit" class="btn btn-sm btn-success" value="Enviar"/>
					</form>
					<hr/>

					<!-- Lista de comentarios -->
					<?php $comments = $image->comments ?>

					@foreach($comments as $comment)
					<div class="">
						<a href class="card-title font-weight-bold mb-2">
							{{$comment->user->name." ".$comment->user->surname." | @".$comment->user->nick}}</a>
						<p class="card-text">Posted: {{ \FormatTime::LongTimeFilter($comment->created_at) }}</p>
						<p>{{$comment->content}}</p>
					</div>

					<!-- Mostrar boton borrar si somos propietarios del comentario o de la publicacion -->
					@if((Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id)))
					<div class="btn-delete">
						<a href="{{route('comment.delete', ['id' => $comment->id])}}" class="btn btn-sm btn-danger">Borrar</a>
					</div>
					@endif

					<hr/>
					@endforeach

				</div>
			</div>
        </div>
    </div>
</div>
@endsection


