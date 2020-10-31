@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

			@include('includes.messageOk')
			@include('includes.messageOkError')

			
			<!--	 Image list -->
			@foreach($images as $image)
				<!-- Mostrar tarjeta de 1 imagen --> 
				@include('includes.image',['image' => $image])
			@endforeach   
			<!--	 end image list -->

			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="pagination">
				{{ $images->links() }}
			</div>
			<!-- end Pagination -->

        </div>
    </div>
</div>
@endsection
