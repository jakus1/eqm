@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">
	<ul class="list-unstyled">
		<li><strong>Name: </strong>{{ $member->first }} {{ $member->last }}</li>
		<li><strong>Email: </strong>{{ $member->email }}</li>
		<li>FIXME: Add more details</li>
	</ul>
</div>
@endsection