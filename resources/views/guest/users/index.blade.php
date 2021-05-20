@extends('layouts.app')

@section('title','User List')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
			<h3>User List</h3>
			<ul>
				@foreach ($users as $user)
					<li><a href="{{route('users.show',['id'=>$user['id']])}}">{{$user->name}}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection