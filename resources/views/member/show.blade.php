@extends ('layouts.master')

@section ('title')
{{ $member->first }} {{ $member->last }}
@stop

@section ('pagetitle')
{{ $member->first }} {{ $member->last }}
@stop

@section ('content')
<div class="col-sm-8 blog-main">
	@foreach($member->tags as $tag)
<span class="label label-primary">{{$tag->tag}}</span>
	@endforeach
	<ul class="list-unstyled">
		<li><strong>Status: </strong>{{ $member->status }}</li>
		<li><strong>Name: </strong>{{ $member->first }} {{ $member->last }}</li>
		<li><strong>Email: </strong>{{ $member->email }}</li>
		<li><strong>Phone: </strong>{{ $member->sms_phone }}</li>
	</ul>
	<a href="{{ action('MembersController@edit', $member->id) }}">Edit {{ $member->first }}</a>

	<hr>

	<div class="comments">
		<ul>
		@foreach ($member->messages as $message)
			<li class="list-group-item">
				<strong>
					{{ $message->created_at->diffForHumans() }} &nbsp;
				</strong>
				<a href="{{ action('MembersController@show', $member)}}"> {{$member->last}}</a>:
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