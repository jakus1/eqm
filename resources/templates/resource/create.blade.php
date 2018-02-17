@@extends('layouts.modal')

@@section('title')
Create New {{ $Model or '' }}
@@stop

@@section('header')
@@parent
	@{!! HTML::ul($errors->all() ) !!}
	@{!! Form::open(['action' => '\{{ $namespace or '' }}\Http\Controllers\ApiController@post{{ $Model or '' }}','id'=>'modalForm']) !!}
	<input name="c7token" type="hidden" value="@{{ csrf_token() }}" data-ng-init="bind._token='@{{ csrf_token() }}'"  data-ng-model="bind._token">
@@stop

@@section('content')
	<div class="row">
		<div class="col-md-12">
@foreach($fields as $field)
@if(isset($field['name']))
			<div class="form-group">
				@{!! Form::label('{{ strtolower($field['name']) }}', '{{ $field['label'] or '' }}') !!}
				@{!! Form::text('{{ strtolower($field['name']) }}', null, array('class' => 'form-control','data-ng-model'=>'bind.{{ strtolower($field['name']) }}','placeholder'=>'Enter {{ $field['label'] or '' }}')) !!}
			</div>
@endif
@endforeach
		</div>	
	</div>
@@stop

@@section('buttons')
	<div class="form-group text-center">
		@{!! Form::button('Create {{ $Model or '' }}', array('class' => 'btn btn-success','ng-click'=>'ok($event)')) !!}
		@{!! Form::button('Cancel',array('class'=>'btn cancel','ng-click'=>'$dismiss()','data-dismiss'=>'modal')) !!}
	</div>
   @{!! Form::close() !!}
@@stop
