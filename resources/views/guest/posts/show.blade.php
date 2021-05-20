@extends('layouts.app')

@php
	use App\Post;
@endphp

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h1>{{$post->title}}</h1>
				<p>Autore: <strong>{{$post->user->name}} ({{$post->user->email}})</strong></p>
				{{-- <p>{{$post->content}}</p> --}}
				<div class="post_content">
					@php $pars = preg_split("/\r\n|\n|\r/", $post['content']); @endphp
					@foreach ($pars as $par)			
						<p>{{$par}}</p>
					@endforeach
				</div>
				<div class="post_more_from">
					<p>Altri post di <strong>{{$post->user->name}}:</strong></p>
					@php
						// $this_user_posts = Post::where('user_id',$post->user_id)->where('id','!=',$post['id']); // non funziona!
						$posts = Post::all();
						$this_user_posts = $posts->where('user_id',$post->user_id)->where('id','!=',$post['id']);
					@endphp
					<ul>
						@foreach ($this_user_posts as $this_user_post)
							<li><a href="{{route('posts.show',['slug'=>$this_user_post['slug']])}}">{{$this_user_post->title}}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection