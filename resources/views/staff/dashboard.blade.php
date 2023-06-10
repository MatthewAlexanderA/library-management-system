@extends('layout')

@section('dashboard')
active
@endsection
@section('title')
Dashboard
@endsection

@section('content')

@if (Auth::user()->role != 'member')

<h5 class="mb-2 mt-4">Data Information</h5>

<div class="row">

    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box" style="background-color: white;">
            <div class="inner">
                <h3>{{ $book }}</h3>

                <p>Total Book</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-book"></i>
            </div>
            <div class="small-box-footer"> </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box" style="background-color: white;">
            <div class="inner">
                <h3>{{ $available }}</h3>

                <p>Total Avaiable Book</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-book"></i>
            </div>
            <div class="small-box-footer"> </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box" style="background-color: white;">
            <div class="inner">
                <h3>{{ $borrowed }}</h3>

                <p>Total Borrowed Book</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-book"></i>
            </div>
            <div class="small-box-footer"> </div>
        </div>
    </div>

</div>

@else

<h5 class="mb-2 mt-4">Welcome, {{ Auth::user()->username }}</h5>

<div class="row">

    @if ($out)
        <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $out }}</h3>

                    <p>Out Of Date Book</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="small-box-footer"> </div>
            </div>
        </div>
    @endif

    <div class="col-lg-3 col-6">
        <!-- small card -->
        <div class="small-box" style="background-color: white;">
            <div class="inner">
                <h3>{{ $member_borrow }}</h3>

                <p>Total Borrowed Book</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-book"></i>
            </div>
            <div class="small-box-footer"> </div>
        </div>
    </div>

</div>

@endif

@endsection
