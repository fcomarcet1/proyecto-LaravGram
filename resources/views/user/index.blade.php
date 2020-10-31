@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<h1>Gente</h1>
			@include('includes.messageOk')
			@include('includes.messageOkError')

<!--			<form method="GET" action="{{route('user.index')}}" id="buscador">
				<div class="input-group mb-3">
					<input type="text" name="search" class="form-control" placeholder="Buscar usuarios">
					<div class="input-group-append">
						<button class="btn btn-success" type="submit">Buscar</button>
					</div>
				</div>
			</form>	-->

			<form method="POST" action="{{route('user.search')}}" id="buscador">
				@csrf

				<div class="input-group mb-3">
					<input type="text" name="search" class="form-control" placeholder="Buscar usuarios">
					<div class="input-group-append">
						<button class="btn btn-success" type="submit">Buscar</button>
					</div>
				</div>
			</form>


			<hr>
			<!--	 Users list -->
			<!-- Profile widget -->
			@foreach($users as $user)
			<div class="bg-white shadow rounded overflow-hidden">
				<div class="px-4 pt-0 pb-4 cover">
					<div class="media align-items-end profile-head">
						<div class="profile mr-3">
							<!-- Avatar -->
							@if($user->image)
							<a href="{{route('profile', ['id' => $user->id])}}" >
								<img src="{{route('user.avatar',['filename'=>$user->image])}}" 
									 id="preview" width="130" class="rounded mb-2 img-thumbnail" alt="avatar"/>
							</a>
							@endif
							<div class="buttons-users">
								<div class="button-edit">
									@if( (\Auth::user()) && (\Auth::user()->id == $user->id) )
									<a href="{{route('config')}}" class="btn btn-outline-dark btn-sm btn-block">
										Editar perfil
									</a>
									@endif
								</div>

							</div>	
						</div>
						<div class="media-body mb-5 text-white">
							<h4 class="mt-0 mb-0 "> 
								<a href="{{route('profile', ['id' => $user->id])}}" >{{$user->name." ". $user->surname. "| @". $user->nick}}</a>
							</h4>
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
			<br/>
			<hr>
			@endforeach

			<!--	 end Users list -->

			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="pagination">
				{{ $users->links() }}
			</div>
			<!-- end Pagination -->
        </div>
    </div>
</div>
@endsection
