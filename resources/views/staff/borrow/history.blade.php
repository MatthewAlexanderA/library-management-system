@extends('layout')

@section('request-history')
active
@endsection
@section('title')
Request History
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
                                            <th>Borrow Date</th>
                                            <th>Must Return Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
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
                                            @if ($borrow->borrow_date)
                                                <td>{{ $borrow->borrow_date }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($borrow->must_return_date)
                                                <td>{{ $borrow->must_return_date }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($borrow->return_date)
                                                <td>{{ $borrow->return_date }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @switch($borrow->status)
                                                @case('rejected')
                                                    <td><button disabled class="btn btn-danger">Rejected</button></td>
                                                    @break
                                                @case('requested')
                                                    <td><button disabled class="btn btn-secondary">Requested</button></td>
                                                    @break
                                                @case('borrowed')
                                                    <td><button disabled class="btn btn-warning">Borrowed</button></td>
                                                    @break
                                                @case('returned')
                                                    <td><button disabled class="btn btn-success">Returned</button></td>
                                                    @break
                                                @default
                                                    <td>{{ $borrow->status }}</td>
                                            @endswitch

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Image</th>
                                            <th>Book Title</th>
                                            <th>Member Name</th>
                                            <th>Borrow Date</th>
                                            <th>Must Return Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
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
