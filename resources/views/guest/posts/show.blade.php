@extends('layouts.app')

@php
	use App\Post;
@endphp

@section('title','Post')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3>Post: {{$post->title}}</h3>
				<p>Autore: <strong><a href="{{route('users.show',['id'=>$post->user->id])}}">{{$post->user->name}}</a></strong> ({{$post->user->email}})</p>
				<p>
					Categoria: 
					@if($post->category)
						<a href="{{route('categories.show',['slug'=>$post->category->slug])}}">{{$post->category->name}}</a>
					@else
						-	
					@endif
				</p>
				{{-- <p>{{$post->content}}</p> --}}
				<div class="post_content">
					@php $pars = preg_split("/\r\n|\n|\r/", $post['content']); @endphp
					@foreach ($pars as $par)			
						<p>{{$par}}</p>
					@endforeach
				</div>
				<div class="post_more_from">
					@php
						$this_user_posts = Post::where('user_id',$post->user_id)->where('id','!=',$post['id'])->get();
					@endphp
					@if ($this_user_posts->toArray())
						<p>Altri post di <strong><a href="{{route('users.show',['id'=>$post->user->id])}}">{{$post->user->name}}</a></strong>:</p>
						<ul>
							@foreach ($this_user_posts as $this_user_post)
								<li>
									<a href="{{route('posts.show',['slug'=>$this_user_post['slug']])}}">{{$this_user_post->title}}</a>
									Categoria: <a href="{{route('categories.show',['slug'=>$this_user_post->category->slug])}}">{{$this_user_post->category->name}}</a>
								</li>
							@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection