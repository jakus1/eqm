@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">
	<table class="table table-striped">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Status</th>
		</tr>
		@if (count($members))
			@foreach ($members as $member)
				<tr>
					<td><a href="{{ action('MembersController@show', $member->id) }}"> {{ $member->first }} {{ $member->last }}</a></td>
					<td>{{ $member->email }}</td>
					<td>{{ $member->sms_phone }}</td>
					<td>{{ $member->status }}</td>
				</tr>
			@endforeach
		@endif
	</table>
</div>
@endsection