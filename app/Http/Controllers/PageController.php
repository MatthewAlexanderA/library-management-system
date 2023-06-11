<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::inRandomOrder()->paginate(9);

        $books = Book::when($request->search, function ($query) use ($request) {
            $query->where('title', 'like', "%{$request->search}%")
                ->orWhere('id', 'like', "%{$request->search}%")
                ->orWhere('author', 'like', "%{$request->search}%");;
        })->latest()->paginate(9);

        $books->appends($request->only('search'));

        return view('index', compact('books'))
            ->with('i', (request()->input('page', 1) - 1) * 9);
    }
}
