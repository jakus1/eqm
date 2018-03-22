@extends ('layouts.master')

@section('content')
  <div class="col-sm-8 blog-main">
    <h1>Create a member</h1>

    <hr>

    <!-- Store a post. In the router see the post operation to the /members url -->
    <form method="POST" action="/members">
      <!-- csrf is cross site request forgery, where a user modifies the
           information returned from this web page in the POST submission.
           Laravel puts this unique ID on the rendered web page, the ID is
           returned in the post, and compared when performing a save. See
           the comments in the MembersController::save method for more details.
      -->
      {{ csrf_field() }}
      <div class="form-group">
        <label for="name">Name:</label>

        <!-- if we want to submit the data to a database, it needs a "name" -->
        <input type="text" class="form-control" id="name" name="name">
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Create</button>
      </div>

      @include ('layouts.errors')
    </form>
  </div>
@endsection
