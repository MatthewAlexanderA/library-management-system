@extends('layout')

@section('book-list')
active
@endsection
@section('title')
Book List
@endsection

@section('content')

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>ISBN</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($books as $book)
                                        <tr>
                                            <td></td>
                                            <td>{{ $book->id }}</td>
                                            <td>
                                                <div style="width: 200px;">
                                                    <img src="{{ asset('storage/' . $book->image) }}" alt="No Image"
                                                        class="img-fluid mt-3">
                                                </div>
                                            </td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->author }}</td>
                                            
                                            @switch($book->status)
                                                @case('borrowed')
                                                    <td><button disabled class="btn btn-warning">Borrowed</button></td>
                                                    @break
                                                @case('available')
                                                    <td><button disabled class="btn btn-success">Available</button></td>
                                                    @break
                                                @default
                                                    <td>{{ $book->status }}</td>
                                            @endswitch

                                            <td>
                                                @if ($check || $book->status != 'available')
                                                    <button class="mb-1 btn btn-success disabled" disabled>Request</button>
                                                @else
                                                    <form action="{{ route('borrow-request', $book->id) }}" method="POST">
                                                        @csrf
                                                        @METHOD('POST')

                                                        <button type="submit" class="mb-1 btn btn-success" >Request</button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('show-book', $book->slug) }}" class="btn btn-primary">View</a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>ISBN</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</div>

@endsection
