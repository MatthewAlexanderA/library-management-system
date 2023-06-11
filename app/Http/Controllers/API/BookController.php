<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Book $book)
    {
        $book = Book::latest()->get();

        return response()->json([
            'data' => $book
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'image|file|required',
            'id' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'author' => 'required',
        ]);

        $image = $request->file('image')->store('post-images/book');

        $validated['image'] = $image;

        $validated['slug'] = Str::slug($request->title);

        $book = Book::create($validated);

        return response()->json([
            'data' => $book
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'image|file|required',
            'id' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'author' => 'required',
        ]);

        $image = $request->file('image')->store('post-images/book');

        $validated['image'] = $image;

        $validated['slug'] = Str::slug($request->title);

        $book = Book::find($id);
        $book->update($validated);

        return response()->json([
            'data' => $book
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json([
            'message' => 'book deleted'
        ], 204);
    }

    public function showBook(Book $book, $id)
    {
        $book = Book::where('id', $id)->first();

        return response()->json([
            'data' => $book
        ]);
    }
}
