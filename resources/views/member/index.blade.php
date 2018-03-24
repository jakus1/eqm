@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">

  @if (count($members))
	<ul class="list-unstyled">
		@foreach ($members as $member)
			<li><a href="member/{{ $member->id}}"> {{ $member->first }} {{ $member->last }}</a></li>
		@endforeach
	</ul>
  @endif

</div>
@endsection