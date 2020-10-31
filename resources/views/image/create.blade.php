@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
					<strong>{{ __('Añadir nueva imagen') }}</strong>
				</div>
				
				<!-- Messages errors -->
				@if (session('message'))
					<div class="alert alert-danger">
						{{session('message')}}
					</div>
				@endif
				
                <div class="card-body">
					<form action="{{route('image.save')}}" method="POST" enctype="multipart/form-data">
						@csrf

						<label>Seleccionar Imagen</label>
						<div class="custom-file mb-3">
							<input type="file" class="custom-file-input {{ $errors->has('filename') ? 'is-invalid' : '' }}" id="customFile" name="filename" accept="image/png, image/jpeg, image/jpg, image/gif" required>
							<label class="custom-file-label" for="customFile">Seleccionar imagen</label>
							@if($errors->has('filename'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('content') }}</strong>
								</span>
								@endif
						</div>
						
						<!-- Preview image -->
						<div class="form-group">
							<label><strong>Preview imagen seleccionada:</strong></label>
							<div class="image-preview">
								<img class="image-prev" id="image-prev" src="http://placehold.it/180" alt="Tu imagen" />
							</div>
						</div> 
						<!-- -->
						<div class="form-group">
							<label for="description"><strong>Descripcion:</strong></label>
							<textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" rows="4" required></textarea>
							@if($errors->has('content'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('description') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Subir imagen" name="submit_image"/>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
