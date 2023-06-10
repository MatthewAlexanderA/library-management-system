@extends('layout')

@section('history')
active
@endsection
@section('title')
History
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
                                            <th>Borrow Date</th>
                                            <th>Must Return Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($histories as $history)
                                        <tr>
                                            <td></td>
                                            <td>
                                                <div style="width: 200px;">
                                                    <img src="{{ asset('storage/' . $history->book->image) }}" alt="No Image"
                                                        class="img-fluid mt-3">
                                                </div>
                                            </td>
                                            <td>{{ $history->book->title }}</td>
                                            @if ($history->borrow_date)
                                                <td>{{ $history->borrow_date }}</td>
                                            @else
                                                <td> - </td>
                                            @endif
                                            @if ($history->must_return_date)
                                                <td>{{ $history->must_return_date }}</td>
                                            @else
                                                <td> - </td>
                                            @endif
                                            @if ($history->return_date)
                                                <td>{{ $history->return_date }}</td>
                                            @else
                                                <td> - </td>
                                            @endif

                                            @if ($history->status == 'borrowed' && $history->must_return_date <= date('Y-m-d'))
                                                <td class="bg-danger">Out Of Date</td>
                                            @else
                                            @switch($history->status)
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
                                            @endif

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Image</th>
                                            <th>Book Title</th>
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
