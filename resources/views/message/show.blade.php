@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">
	<h2>{{ $message->subject }}</h2>
	{{ $message->created_at->toFormattedDateString() }}
	<hr>
	{{ $message->body }}
</div>
@endsection