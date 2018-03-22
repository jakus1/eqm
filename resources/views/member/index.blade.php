@extends ('layouts.master')

@section ('content')
<div class="col-sm-8 blog-main">

  <ul>
  @foreach ($members as $member)
    <li>Name: {{ $member->first }}   {{ $member->last }} </li>
  @endforeach
  </ul>

</div>
@endsection