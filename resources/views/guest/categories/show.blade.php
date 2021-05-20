@extends('layouts.app')

@php
	use App\Post;
@endphp

@section('title','Category')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3>Categoria: {{$category->name}}</h3>
				<div class="category_content">
					@php $pars = preg_split("/\r\n|\n|\r/", $category['description']); @endphp
					@foreach ($pars as $par)			
						<p>{{$par}}</p>
					@endforeach
				</div>
				<div class="category_more_from">
					@php
						$this_category_posts = Post::where('category_id',$category['id'])->get();
					@endphp
					@if ($this_category_posts->toArray())
						<p>Post in questa categoria:</p>
						<ul>
							@foreach ($this_category_posts as $this_category_post)
								<li>
									<a href="{{route('posts.show',['slug'=>$this_category_post['slug']])}}">{{$this_category_post->title}}</a>
									Autore: <a href="{{route('users.show',['id'=>$this_category_post->user->id])}}">{{$this_category_post->user->name}}</a>
									
								</li>
							@endforeach
						</ul>						
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection