@extends('layouts.app')

@section('title','Category List')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
			<h3>Tags List</h3>
			<ul>
				@foreach ($tags as $tag)
					<li><a href="{{route('tags.show',['slug'=>$tag['slug']])}}">{{$tag->name}}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection