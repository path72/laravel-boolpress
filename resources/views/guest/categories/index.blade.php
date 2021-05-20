@extends('layouts.app')

@section('title','Category List')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
			<h3>Category List</h3>
			<ul>
				@foreach ($categories as $category)
					<li><a href="{{route('categories.show',['slug'=>$category['slug']])}}">{{$category->name}}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection