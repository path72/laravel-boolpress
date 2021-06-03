@extends('layouts.dashboard')

{{-- IL POST SPECIFICO --}}
{{-- @dd($post) --}}
{{-- TUTTI I TAG DEL DB --}}
{{-- @dd($tags) --}}
{{-- I TAG DEL POST SPECIFICO - Collection & BelongsToMany --}}
{{-- @dd($post->tags) --}}
{{-- @dd($post->tags()) --}}
{{-- TUTTE LE CATEGORIE DEL DB --}}
{{-- @dd($categories) --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Modifica post {{ $post->id }}</h1>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><line x1="20" y1="12" x2="4" y2="12"></line><polyline points="10 18 4 12 10 6"></polyline></svg> Tutti i posts
                </a>
            </div>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Titolo</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Inserisci il titolo" value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
				<div class="form-group">
				@if($post->image)
					<p>Immagine:</p>
					<img style="max-width:600px;" src="{{asset('storage/'.$post->image)}}" alt="">
					<p>Sostituisci immagine</p>
				@else 
					<p>Immagine non presente</p>
                    <p>Inserisci mmagine</p>
				@endif
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" value="{{ old('image', $post->image) }}">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Contenuto</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="10" placeholder="Inizia a scrivere qualcosa..." required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<p>Seleziona i tag:</p>
							@foreach ($tags as $tag) 
								<div class="form-check @error('tags') is-invalid @enderror">
									{{-- 
										$tags       : Collection di Model Tag >> tutti i tag del DB
										$post->tags : Collection di Model Tag >> tag associati al $post
										$tag        : Model Tag >> ogni tag del DB
										qui uso $post->tags e non $post->tags() (classi diverse >> metodi diversi)
										name = 'tags' è l'array che raccoglie i valori di value = $tag->id
									--}}	
									{{-- {{'$tags'}} @dump($tags) --}}
									{{-- {{'$post->tags'}} @dump($post->tags) --}}
									{{-- {{'$tag'}} @dd($tag) --}}
									<input name="tags[]" class="form-check-input" type="checkbox" value="{{ $tag->id }}"
									{{ $post->tags->contains($tag) ? 'checked=checked' : '' }}>
									<label class="form-check-label">
										{{ $tag->name }}
									</label>
								</div>
							@endforeach
							@error('tags')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>		
					</div>
					<div class="col-6">
						<div class="form-group">
							<p>Categoria:</p>
							<select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
								<option value="">-- seleziona categoria --</option>
								@foreach ($categories as $category)
									{{-- 
										$categories : Collection di Model Category >> tutte le categorie del DB
										$category   : Model Category >> ogni categoria del DB
									--}}	
									{{-- {{'$categories'}} @dump($categories) --}}
									{{-- {{'$category'}} @dd($category) --}}
									<option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected=selected' : '' }}>
										{{ $category->name }}
									</option>
								@endforeach
							</select>
							@error('category_id')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>		
					</div>
				</div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> Salva post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
