<?php

namespace App\Http\Controllers;
use App\Models\Book;

class DashboardController extends Controller
{
    public function index()
    {
        $book = Book::all()->count();

        return view('staff.dashboard', compact('book'));
    }
}
