@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">
	<ul class="list-unstyled">
		<li><strong>Name: </strong>{{ $member->first }} {{ $member->last }}</li>
		<li><strong>Email: </strong>{{ $member->email }}</li>
		<li><strong>Phone: </strong>{{ $member->sms_phone }}</li>
	</ul>
	Edit <a href="{{ action('MembersController@edit', $member->id) }}">{{ $member->first }}</a>

	<hr>

	<div class="comments">
		<ul>
		@foreach ($member->messages as $message)
			<li class="list-group-item">
				<strong>
					{{ $message->created_at->diffForHumans() }} &nbsp;
				</strong>
				<a href="action('MembersController@show', $member) {{$member->last}}</a>:
				<br>
				<h3> {{ $message->subject }}</h3>
				<br>
				{{ $message->body }}
			</li>
		@endforeach
	</ul>
	</div>
</div>
@endsection