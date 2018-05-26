@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">
	@if (Auth::check())
		<a href="{{ action('MembersController@index') }}"> Members</a>
	@else
		<a href="{{ action('SessionsController@create') }}"> Sign in</a>
	@endif
</div>
@endsection