@extends('layouts.dashboard')

{{-- LA CATEGORIA SPECIFICA --}}
{{-- @dd($category) --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Visualizzazione categoria {{ $category->id }}</h1>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><line x1="20" y1="12" x2="4" y2="12"></line><polyline points="10 18 4 12 10 6"></polyline></svg> Tutte le categorie
                </a>
            </div>
            <dl>
                <dt>Nome</dt>
                <dd>{{ $category->name }}</dd>
                <dt>Slug</dt>
                <dd>{{ $category->slug }}</dd>
                <dt>Descrizione</dt>
                {{-- <dd>{{ $category->description }}</dd> --}}
				@php $pars = preg_split("/\r\n|\n|\r/", $category['description']); @endphp
				<dd>@foreach ($pars as $par) <p>{{$par}}</p> @endforeach</dd>
				<dt>Post di questa categoria</dt>
                <dd>
					@forelse ($category->posts as $post)
						<div>
							<a href="{{route('admin.posts.show',$post->id)}}">{{ $post->title }}</a> 
							<div style="margin-left: 20px;">
								Autore: <a href="{{route('users.show',$post->user_id)}}">{{ $post->user->name }}</a>
								Tag:
								@forelse ($post->tags as $tag)
									<a href="{{route('admin.tags.show',$tag->id)}}">{{ $tag->name }}</a>{{!$loop->last?',':''}}
								@empty
									-
								@endforelse
							</div>
						</div>
					@empty
						-
					@endforelse
				</dd>
			</dl>
			{{-- EDIT --}}
            <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" class="btn btn-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg> Modifica
            </a>
			{{-- DELETE --}}
            <form class="d-inline-block" action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Elimina
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
