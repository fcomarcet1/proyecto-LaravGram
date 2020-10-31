<form action="" method="POST" enctype="multipart/form-data">

	<div class="form-group">
		<label for="image"><strong>Imagen:</strong></label>
		<div class="custom-file">
			<input type="file" onchange="readURL(this);" class="custom-file-input" name="image" id="image" lang="es" >
			<label class="custom-file-label" for="customFileLang">Seleccionar Imagen...</label>
		</div>
	</div>

	<div class="form-group">
		<label><strong>Preview imagen seleccionada:</strong></label>
		<div class="image-preview">
			<img class="image-prev" src="http://placehold.it/180" alt="Tu imagen" />
		</div>
	</div> 

	<div class="form-group">
		<label for="description"><strong>Descripcion:</strong></label>
		<textarea class="form-control" name="description" id="description" rows="4"></textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" value="Subir imagen" name="submit_image"/>
	</div>
</form>