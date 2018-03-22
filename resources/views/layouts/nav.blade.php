<div class="blog-masthead">
  <div class="container">
    <nav class="blog-nav">
      <a class="blog-nav-item active" href="#">Home</a>
      <a class="blog-nav-item" href="#">Menu 1</a>
      <a class="blog-nav-item" href="#">Menu 2</a>
      <a class="blog-nav-item" href="#">Menu 3</a>
      <a class="blog-nav-item" href="#">About</a>

      @if (Auth::check())
        <a class="blog-nav-item pull-right" href="#">{{ Auth::user()->name }}</a>
      @endif
    </nav>
  </div>
</div>
