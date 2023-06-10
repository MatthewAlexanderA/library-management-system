@extends('layout')

@section('verify')
active
@endsection
@section('title')
Verify Request
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
                                            <th>Image</th>
                                            <th>Book Title</th>
                                            <th>Member Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($borrows as $borrow)
                                        <tr>
                                            <th></th>
                                            <td>
                                                <div style="width: 200px;">
                                                    <img src="{{ asset('storage/' . $borrow->book->image) }}" alt="No Image"
                                                        class="img-fluid mt-3">
                                                </div>
                                            </td>
                                            <td>{{ $borrow->book->title }}</td>
                                            <td>{{ $borrow->member->username }}</td>
                                            <td>{{ $borrow->status }}</td>

                                            <td>
                                                <form action="{{ route('reject-request',$borrow->id) }}" method="POST">

                                                    <a href="{{ route('verify-request', $borrow->id) }}" class="btn btn-success" >Verify</a>

                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                </form>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Image</th>
                                            <th>Book Title</th>
                                            <th>Member Name</th>
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
