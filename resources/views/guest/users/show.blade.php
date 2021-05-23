@extends('layouts.app')

@php
	use App\Post;
@endphp

@section('title','User')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3>Utente: {{$user->name}}</h3>
				<p>{{$user->email}}</p>
				<div class="post_more_from">
					@php
						$this_user_posts = Post::where('user_id',$user->id)->get();
					@endphp
					@if ($this_user_posts->toArray())
						<p>Post di <strong>{{$user->name}}</strong>:</p>
						<ul>
							@foreach ($this_user_posts as $this_user_post)
							<li>
								<a href="{{route('posts.show',['slug'=>$this_user_post['slug']])}}">{{$this_user_post->title}}</a>
								Categoria: 
								@if ($this_user_post->category)										
									<a href="{{route('categories.show',$this_user_post->category->slug)}}">{{$this_user_post->category->name}}</a>
								@else
									-
								@endif
							</li>									
							@endforeach
						</ul>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection