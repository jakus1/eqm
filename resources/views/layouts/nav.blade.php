<div class="blog-masthead">
  <div class="container">
    <nav class="blog-nav">
      <a class="blog-nav-item active" href="/">Home</a>
      <a class="blog-nav-item" href="#">Menu 1</a>
      <a class="blog-nav-item" href="#">Menu 2</a>
      <a class="blog-nav-item" href="#">Menu 3</a>
      <a class="blog-nav-item" href="#">About</a>

      @if (Auth::check())
        <a class="blog-nav-item pull-right" href="/user/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a>
        <a class="blog-nav-item pull-right" href="/logout">Logout</a>
        <a class="blog-nav-item pull-right" href="/member/create">Create Member</a>
      @else
        <a class="blog-nav-item pull-right" href="/user/create">Create User</a>
        <a class="blog-nav-item pull-right" href="/login">Login</a>
      @endif
    </nav>
  </div>
</div>
