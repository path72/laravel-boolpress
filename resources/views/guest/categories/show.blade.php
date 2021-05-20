@extends('layouts.app')

@php
	use App\Post;
@endphp

@section('title','Category')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3>{{$category->name}}</h3>
				<div class="category_content">
					@php $pars = preg_split("/\r\n|\n|\r/", $category['description']); @endphp
					@foreach ($pars as $par)			
						<p>{{$par}}</p>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection