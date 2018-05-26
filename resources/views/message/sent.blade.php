@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">
	@if (count($messageLines))
		<ul class="list-unstyled">
			@foreach ($messageLines as $messageLine)
				<li>{{ $messageLine }}</li>
			@endforeach
		</ul>
	@endif
</div>
@endsection