<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $book = Book::all()->count();
        $available = Book::where('status', 'available')->count();
        $borrowed = Book::where('status', 'borrowed')->count();

        $member_borrow = Borrow::where('status', '!=' ,'rejected')
            ->where('status', '!=' ,'requested')
            ->where('member_id', Auth::user()->id)
            ->count();
        $out = Borrow::where('status', 'borrowed')
            ->where('must_return_date', '<=', date('Y-m-d'))
            ->where('member_id', Auth::user()->id)
            ->count();

        return view('staff.dashboard', compact('book', 'available', 'borrowed', 'member_borrow', 'out'));
    }
}
