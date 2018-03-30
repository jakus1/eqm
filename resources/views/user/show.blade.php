@extends ('layouts.master')

@section('content')
<div class="col-sm-8 blog-main">
	<ul class="list-unstyled">
		<li><strong>Name: </strong>{{ $user->name }}</li>
		<li><strong>Email: </strong>{{ $user->email }}</li>
	</ul>
	Edit <a href="{{ action('UsersController@edit', $user->id) }}">{{ $user->name }}</a>
	<hr>
</div>
@endsection