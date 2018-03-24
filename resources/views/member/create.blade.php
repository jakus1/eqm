@extends ('layouts.master')

@section('content')
  <div class="col-sm-8 blog-main">
    <h1>Create a member</h1>

    <hr>

    <!-- Store a post. In the router see the post operation to the /member url -->
    <form method="POST" action="/member">
      <!-- csrf is cross site request forgery, where a user modifies the
           information returned from this web page in the POST submission.
           Laravel puts this unique ID on the rendered web page, the ID is
           returned in the post, and compared when performing a save. 
      -->
	  {{ csrf_field() }}
	  
    <div class="form-group">
        <label for="first">First Name:</label>
        <input type="text" class="form-control" id="first" name="first" required>
		</div>

		<div class="form-group">
        <label for="last">First Name:</label>
        <input type="text" class="form-control" id="last" name="last" required>
	  </div>

	  <div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" name="email" required>
	  </div>

	  <div class="form-group">
				<label for="sms_phone">Phone Number:</label>
				<input type="tel" class="form-control" id="sms_phone" name="sms_phone" required>
	  </div>

	  <div class="form-group">
				<button type="submit" class="btn btn-primary">Create Member</button>
	  </div>

	  <div class="form-group">
			@include ('layouts.errors')
	  </div>
    </form>
  </div>
@endsection
