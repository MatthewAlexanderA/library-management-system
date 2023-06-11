<?php

namespace App\Http\Controllers;
use App\Models\Book;

class PageController extends Controller
{
    public function index()
    {
        $books = Book::inRandomOrder()->get();

        return view('index', compact('books'));
    }
}
