@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

			@include('includes.messageOk')
			@include('includes.messageOkError')
			
			<h1>Mis imagenes favoritas</h1>
			
			@foreach ($likes as $like)
				@include('includes.image',['image'=>$like->image])
			@endforeach
			
			<!-- Pagination -->
			<div class="clearfix"></div>
			<div class="pagination">
				{{ $likes->links() }}
			</div>
			<!-- end Pagination -->
			
        </div>
    </div>
</div>
@endsection
