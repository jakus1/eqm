@extends ('layouts.master')

@section ('content')
<div class="col-md-12 blog-main">
	<table class="table table-striped">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Status</th>
			<th>Email</th>
			<th>Text</th>
			<th>Edit</th>
		</tr>
		@if (count($members))
			@foreach ($members as $member)
				<tr>
					<td><a href="{{ action('MembersController@show', $member->id) }}">{{ $member->last or '' }}, {{ $member->first or '' }}</a></td>
					<td>{{ $member->email or '' }}</td>
					<td>{{ $member->sms_phone or '' }}</td>
					<td>{{ $member->status or '' }}</td>
					<td>{{ $member->receives_email ? 'yes' : 'no' }}</td>
					<td>{{ $member->receives_text ? 'yes' : 'no' }}</td>
					<td><a href="{{ action('MembersController@edit', $member)}}"> [edit]</a></td>
				</tr>
			@endforeach
		@endif
	</table>
</div>
@endsection