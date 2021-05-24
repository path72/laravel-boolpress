@extends('layouts.dashboard')
 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            {{-- <div class="d-flex justify-content-between align-items-center"> --}}
				<h3>Dati Utente</h3>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">{{Auth::user()->name}}</li>
					<li class="list-group-item">{{Auth::user()->email}}</li>
					@if (Auth::user()->api_token)
						<li class="list-group-item">{{Auth::user()->api_token}}</li>
					@else
						<form action="{{ route('admin.generate_token') }}" method="post">
							@csrf
							@method('POST')
							<button type="submit" class="btn btn-warning">Genera API token</button>
						</form>
					@endif
				</ul>			
			{{-- </div> --}}
		</div>
	</div>
</div>

@endsection