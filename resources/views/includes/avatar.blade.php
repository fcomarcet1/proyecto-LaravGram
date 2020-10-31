@if(Auth::user()->image)
<div class="form-group row">
	<label for="image" class="col-md-4 col-form-label text-md-right">
		{{ __(' Preview avatar') }}</label>
	<div class="col-md-6">
		<div class="ml-2 col-sm-6">
			<img src="{{route('user.avatar',['filename'=>Auth::user()->image ])}}" 
				 id="preview" class="img-thumbnail"/>
        </div>
    </div>                          
</div>
@endif


