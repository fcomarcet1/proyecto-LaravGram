@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
					<h1><strong>{{ __('Editar publicacion') }}</strong></h1>
				</div>

				<!-- Messages errors -->
				@include('includes.messageOk')
				@include('includes.messageOkError')

                <div class="card-body">
					<form action="{{route('image.update')}}" method="POST" enctype="multipart/form-data">
						@csrf

						<input type="hidden" name="image_id" value="{{$image->id}}" />

						<label><strong>Seleccionar Imagen</strong></label>
						<div class="custom-file mb-3">
							<input type="file" class="custom-file-input {{ $errors->has('filename') ? 'is-invalid' : '' }}" id="customFile" name="filename" accept="image/png, image/jpeg, image/jpg, image/gif" >
							<label class="custom-file-label" for="customFile">Seleccionar imagen</label>
							@if($errors->has('filename'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('filename') }}</strong>
								</span>
							@endif
						</div>

						<label><strong>Imagen Actual</strong></label>
						<div class="image-container">
							<img class="card-img-top rounded-0" src="{{ route('image.file',['filename' => $image->image_path]) }}"  alt="Card image cap">
							<a href="#!">
								<div class="mask rgba-white-slight"></div>
							</a>
						</div>
						<div class="form-group">
							<label for="description"><strong>Descripcion:</strong></label>
							<textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" rows="4" required>{{$image->description}}</textarea>
							@if($errors->has('description'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('description') }}</strong>
								</span>
							@endif
						</div>

						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Actualizar publicacion" name="update_image"/>
						</div>
						
					</form>
				</div> 
			</div>
		</div>
	</div>
</div>
@endsection

