<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Book $book)
    {
        $book = Book::latest()->get();

        return view('staff.book.index', compact('book'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        Book::create($validated);

        return redirect()->route('book.index')
            ->with('success', 'Add Success!');
    }

    public function edit($id)
    {
        $book = Book::find($id);

        return view('staff.book.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'image' => 'image|file',
            'id' => 'required',
            'title' => 'required',
            'desc' => 'required',
            'author' => 'required',
        ];

        $validated = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validated['image'] = $request->file('image')->store('post-images/book');
        };

        $validated['slug'] = Str::slug($request->title);

        $book = Book::find($id);
        $book->update($validated);

        return redirect()->route('book.index')
            ->with('success', 'Update Success!');
    }

    public function destroy(Book $book)
    {
        if ($book->image) {
            Storage::delete($book->image);
        }

        $book->delete($book->id);

        return redirect()->route('book.index')
            ->with('success', 'Delete Success!');
    }

    public function showBook(Book $book, $slug)
    {
        $book = Book::where('slug', $slug)->first();
        // Check if the member already borrow a book
        if (Auth::user()) {
            $check = Borrow::where('status', '=', 'borrowed')
                ->orWhere('status', '=', 'requested')
                ->where('member_id', Auth::user()->id)
                ->count();
        } else {
            $check = 0;
        } 

        return view('member.show', compact('book', 'check'));
    }
}
