@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<!-- Messages Ok-errors -->
			@include('includes.messageOkError')
			<div class="card">
				<div class="card-header">{{ __('Modificar datos personales: ') }}</div>

				<div class="card-body">
					<form method="POST" enctype="multipart/form-data" action="{{ route('user.update') }}" aria-label="{{ __('Modificar datos personales') }}">
						@csrf

						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}" required autofocus>

								@if ($errors->has('name'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

							<div class="col-md-6">
								<input id="surname" type="text" class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" name="surname" value="{{ Auth::user()->surname }}" required autofocus>

								@if ($errors->has('surname'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('surname') }}</strong>
								</span>
								@endif
							</div>
						</div>

						<div class="form-group row">
							<label for="nick" class="col-md-4 col-form-label text-md-right">{{ __('Nick') }}</label>

							<div class="col-md-6">
								<input id="nick" type="text" class="form-control{{ $errors->has('nick') ? ' is-invalid' : '' }}" name="nick" value="{{Auth::user()->nick }}" required autofocus>

								@if ($errors->has('nick'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('nick') }}</strong>
								</span>
								@endif
							</div>
						</div>


						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{Auth::user()->email}}" required>

								@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
							</div>
						</div>
						<!--Avatar -->	
						<div class="form-group row">
							<label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>
							<div class="col-md-6">
								<input type="file" name="image" class="form-control-file" id="image" accept="image/png, image/jpeg, image/jpg, image/gif ">
							</div>
							@if ($errors->has('image'))
							<span class="invalid-feedback" role="alert">
								<strong>{{ $errors->first('image') }}</strong>
							</span>
							@endif
						</div>

						<!-- Preview Avatar -->	
						@if(Auth::user()->image)
						<div class="form-group row">
							<label for="image" class="col-md-4 col-form-label text-md-right">
								{{ __(' Preview avatar') }}</label>
							<div class="col-md-6">
								<div class="ml-2 col-sm-6">
									<img src="{{route('user.avatar', ['filename' => Auth::user()->image ] )}}" id="preview" class="img-thumbnail"/>
								</div>
							</div>							
						</div>
						@endif

						<!-- -->	
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-primary">
									{{ __('Guardar cambios') }}
								</button>
							</div>
						</div>
						<br/>
						<br/>
						<div class="form-group row mb-3">
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-primary">
									{{ __('Modificar Password') }}
								</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
