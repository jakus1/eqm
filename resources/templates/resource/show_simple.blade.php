@@extends('layouts.modal')

@@section('title')
{{ $Model or '' }} Detail
@@stop

@@section('header')
@@parent
	
@@stop

@@section('content')
	<div>
		<pre><span ng-bind="{{ $model or '' }} | json"></span></pre>
	</div>

@@stop
