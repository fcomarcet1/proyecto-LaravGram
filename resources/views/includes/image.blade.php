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
			<p class="card-text">Posted:{{ \FormatTime::LongTimeFilter($image->created_at) }}</p>
	 <!--	<p class="card-text">Posted: {{$image->created_at->format('G:ia  \o\n l jS F Y')}}</p> -->
		</div>
	</div>
	<div class="card-body">

		<!-- Card image -->
		<a href="{{route('image.detail',['id'=>$image->id])}}">
			<div class="image-container">
				<img class="card-img-top rounded-0" src="{{route('image.file',['filename' => $image->image_path])}}"  alt="Card image cap">
				<a href="#!">
					<div class="mask rgba-white-slight"></div>
				</a>
			</div>
		</a>	

		<!-- description -->
		<div class="description">
			<a href="">{{"@".$image->user->nick}}</a>
			<p>{{$image->description}}<p>
		</div>
		<!-- Card footer -->	
	</div>
	<div class="card-footer">

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

		<a href="{{route('image.detail', ['id' => $image->id])}}">
			<button type="button" class="btn btn-warning btn-sm btn-comments">
				Comentarios({{count($image->comments)}})
			</button>
		</a>	
	</div>
</div>