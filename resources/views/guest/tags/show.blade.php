@extends('layouts.app')

@php
	use App\Post;
@endphp

@section('title','Category')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h3>Tag: {{$tag->name}}</h3>
				<div class="entity_content">
					@php $pars = preg_split("/\r\n|\n|\r/", $tag['description']); @endphp
					@foreach ($pars as $par)			
						<p>{{$par}}</p>
					@endforeach
				</div>
				{{-- <div class="entity_more_from">
					@php
						$this_tag_posts = Post::where('tag_id',$tag['id'])->get(); // ! NOOOO !
					@endphp
					@if ($this_tag_posts->toArray())
						<p>Post con questo tag:</p>
						<ul>
							@foreach ($this_tag_posts as $this_tag_post)
								<li>
									<a href="{{route('posts.show',['slug'=>$this_tag_post['slug']])}}">{{$this_tag_post->title}}</a>
									Autore: <a href="{{route('users.show',['id'=>$this_tag_post->user->id])}}">{{$this_tag_post->user->name}}</a>
									
								</li>
							@endforeach
						</ul>						
					@endif
				</div> --}}
			</div>
		</div>
	</div>
@endsection