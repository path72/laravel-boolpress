@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
			<div class="card">
                <div class="card-header">{{ __('Dati Utente') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- __('You are logged in!') --}}
					<ul class="list-group list-group-flush">
						<li class="list-group-item">{{Auth::user()->name}}</li>
						<li class="list-group-item">{{Auth::user()->email}}</li>
						@if (Auth::user()->api_token)
							<li class="list-group-item">Token: {{Auth::user()->api_token}}</li>
						@else
							<form action="{{ route('admin.generate_token') }}" method="post">
								@csrf
								@method('POST')
								<button type="submit" class="btn btn-warning">Genera API token</button>
							</form>
						@endif
					</ul>
                </div>
            </div>
		</div>
    </div>
</div>
@endsection

