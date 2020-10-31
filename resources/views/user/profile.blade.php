@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="row py-5 px-4">
			<div class="col-md-10 mx-auto">
				<!-- Profile widget -->
				<div class="bg-white shadow rounded overflow-hidden">
					<div class="px-4 pt-0 pb-4 cover">
						<div class="media align-items-end profile-head">
							<div class="profile mr-3">
								<!-- Avatar -->
								<img src="{{route('user.avatar',['filename'=>$user->image])}}" 
									 id="preview" width="130" class="rounded mb-2 img-thumbnail" alt="avatar"/>

								@if( (\Auth::user()) && (\Auth::user()->id == $user->id) )
									<a href="{{route('config')}}" class="btn btn-outline-dark btn-sm btn-block">
										Editar perfil
									</a>
								@endif
							</div>
							<div class="media-body mb-5 text-white">
								<h4 class="mt-0 mb-0">{{$user->name." ". $user->surname. "| @". $user->nick}}</h4>
								<p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i>Se unió: {{ \FormatTime::LongTimeFilter($user->created_at) }}</p>
							</div>
						</div>
					</div>
					<div class="bg-light p-4 d-flex justify-content-end text-center">
						<ul class="list-inline mb-0">
							<li class="list-inline-item">
								<h5 class="font-weight-bold mb-0 d-block">{{count($user->images)}}</h5><small class="text-muted"> <i class="fas fa-image mr-1"></i>Publicaciones</small>
							</li>
							<li class="list-inline-item">
								<h5 class="font-weight-bold mb-0 d-block">{{count($user->comments)}}</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Comentarios</small>
							</li>
							<li class="list-inline-item">
								<h5 class="font-weight-bold mb-0 d-block">{{count($user->likes)}}</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Likes</small>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="py-4 px-4">
					<div class="d-flex align-items-center justify-content-between mb-3">
						<h5 class="mb-0">Publicaciones recientes</h5><a href="{{route('home')}}" class="btn btn-link text-muted">Ir a Inicio</a>
					</div>
					<div class="row">
						@foreach($images as $image)
						<div class="col-lg-6 mb-2 pr-lg-1">
							<a href="{{route('image.detail',['id'=>$image->id])}}">
								<img class="card-img-top rounded-0" src="{{route('image.file',['filename' => $image->image_path])}}"  alt="Card image cap">
							</a>	
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

