@extends ('layouts.master')

@section('content')
  <div class="col-sm-8 blog-main">
    <h1>Create a user</h1>

    <hr>

    <!-- Store a post. In the router see the post operation to the /user url -->
    <form method="POST" action="/user">
      <!-- csrf is cross site request forgery, where a user modifies the
           information returned from this web page in the POST submission.
           Laravel puts this unique ID on the rendered web page, the ID is
           returned in the post, and compared when performing a save. 
      -->
	  {{ csrf_field() }}
	  
      <div class="form-group">
    	<label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
	  </div>

	  <div class="form-group">
		<label for="email">Email:</label>
		<input type="email" class="form-control" id="email" name="email" required>
	  </div>

	  <div class="form-group">
		<label for="password">Password:</label>
		<input type="password" class="form-control" id="password" name="password" required>
	  </div>

	  <div class="form-group">
		<label for="password_confirmation">Password Confirmation:</label>
		<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
	  </div>

	  <div class="form-group">
		<button type="submit" class="btn btn-primary">Create User</button>
	  </div>

	  <div class="form-group">
		@include ('layouts.errors')
	  </div>
    </form>
  </div>
@endsection
