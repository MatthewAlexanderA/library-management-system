<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    // Start staff function
    public function index(Borrow $borrow) // Verify request page
    {
        $borrows = Borrow::latest()
            ->with('book')
            ->with('member')
            ->where('status', 'requested')
            ->get();

        return view('staff.borrow.index', compact('borrows'));
    }

    public function inputDate($id)
    {
        $borrow = Borrow::find($id);

        return view('staff.borrow.verify', compact('borrow'));
    }
    
    public function verify(Request $request, $id)
    {
        $rules = [
            'must_return_date' => 'required',
        ];
        $validated = $request->validate($rules);

        $validated['borrow_date'] = date('Y-m-d');
        $validated['status'] = 'borrowed';

        $borrow = Borrow::find($id);

        $borrow->update($validated);

        return redirect()->route('verify')
            ->with('success', 'Request Accepted!');
    }

    public function reject($id)
    {
        $validated['status'] = 'rejected';
        $updateBook['status'] = 'available';

        $borrow = Borrow::find($id);
        $book = Book::find($borrow->isbn);

        $book->update($updateBook);
        $borrow->update($validated);

        return redirect()->route('verify')
            ->with('success', 'Request Rejected!');
    }

    public function return(Borrow $borrow)
    {
        $borrows = Borrow::latest()
            ->with('book')
            ->with('member')
            ->where('status', 'borrowed')
            ->get();

        return view('staff.borrow.return', compact('borrows'));
    }
    
    public function confirmReturn($id)
    {
        $validated['status'] = 'returned';
        $validated['return_date'] = date('Y-m-d');

        $updateBook['status'] = 'available';

        $borrow = Borrow::find($id);
        $book = Book::find($borrow->isbn);

        $book->update($updateBook);
        $borrow->update($validated);

        return redirect()->route('return-book')
            ->with('success', 'Return Confirmed!');
    }

    public function allHistory()
    {
        $borrows = Borrow::where('status', '!=', 'requested')
            ->with('book')
            ->with('member')
            ->latest()
            ->get();

        return view('staff.borrow.history', compact('borrows'));
    }

    public function outOffDate()
    {
        $borrows = Borrow::where('must_return_date', '<=', date('Y-m-d'))
            ->where('status', 'borrowed')
            ->with('book')
            ->with('member')
            ->latest()
            ->get();

        return view('staff.borrow.out', compact('borrows'));
    }
    // End staff function

    // Start member function
    public function list() 
    {
        $books = Book::orderBy('status', 'ASC')->get();
        // Check if the member already borrow a book
        $check = Borrow::where('status', '=', 'borrowed')
            ->orWhere('status', '=', 'requested')
            ->where('member_id', Auth::user()->id)  
            ->count();

        return view('member.list', compact('books', 'check'));
    }

    public function request($id)
    {
        $validated['isbn'] = $id;
        $validated['member_id'] = Auth::user()->id;
        $validated['status'] = 'requested';

        $updateBook['status'] = 'borrowed';

        $book = Book::find($validated['isbn']);

        $book->update($updateBook);
        Borrow::create($validated);

        return redirect()->route('request-history')
            ->with('success', 'Request Success!');
    }

    public function history()
    {
        $histories = Borrow::where('member_id', Auth::user()->id)
            ->with('book')
            ->latest()
            ->get();

        return view('member.history', compact('histories'));
    }
    // End member function
}
