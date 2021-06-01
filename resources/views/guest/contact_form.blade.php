@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-6">
				<h1>Contact Form</h1>
				<div class="d-flex justify-content-between align-items-center">
					{{-- REDIRECT message management --}}
					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif
				</div>
				<form action="{{route('contact.sent')}}" method="post">
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
					</div>
					<div class="form-group">
						<label for="name">E-Mail</label>
						<input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
					</div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea class="form-control" id="message" name="message" placeholder="Enter your message" required></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Send Message</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection