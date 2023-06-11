<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body style="background-color: #e9ecef;">
    @include('sweetalert::alert')
    
    <nav class="navbar navbar-expand-lg bg-dark bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('index') }}">Library Management System</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <span class="navbar-nav me-auto mb-2 mb-lg-0"></span>
            <form class="d-flex ms-3 mb-1" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
            <div class="ms-3">
              @if (Auth::user())
                  <a href="{{ route('dashboard.index') }}" class="btn btn-primary">Dashboard</a>
              @else
                  <a href="{{ route('login') }}" class="btn btn-success">Login</a>
              @endif
            </div>
          </div>
        </div>
      </nav>

      <div class="content m-5 p-5 card">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
              <img src="{{ asset('storage/'.$book->image) }}" style="width: 100%; object-fit:cover;" class="img-fluid rounded-start" alt="{{ $book->title }}">
            </div>  
            <div class="col-lg-9 col-md-9 col-sm-12">
              <h4>{{ $book->title }}</h4> 
              <p>By: {{ $book->author }}</p> 
              {!! $book->desc !!}
              <p>Status:
                @switch($book->status)
                    @case('available')
                        <button class="btn btn-sm btn-success" disabled>Available</button>
                        @break
                    @case('borrowed')
                        <button class="btn btn-sm btn-warning" disabled>Borrowed</button>
                        @break
                    @default
                        {{ $book->status }}
                @endswitch
              </p>
              @if ($check || $book->status != 'available')
                <button class="btn btn-success disabled" disabled>Request</button>
              @else
                <form action="{{ route('borrow-request', $book->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-success">Request</button>
                </form>
              @endif
            </div>  
        </div>
      </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>