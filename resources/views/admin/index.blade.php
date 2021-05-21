@extends('layouts.app')

@section('title','Post List')
@section('content')
{{-- <div class="container">
	<div class="row">
		<div class="col-12">
			<h3>Post List</h3>
			<ul>
				@foreach ($posts as $post)
					<li><a href="{{route('posts.show',['slug'=>$post['slug']])}}">{{$post->title}}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div> --}}
@endsection