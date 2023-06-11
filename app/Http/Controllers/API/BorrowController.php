<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function index(Borrow $borrow)
    {
        $borrows = Borrow::latest()
            ->with('book')
            ->with('member')
            ->where('status', 'requested')
            ->get();

            return response()->json([
                'data' => $borrows
            ]);
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

        return response()->json([
            'data' => $borrow
        ]);
    }

    public function reject($id)
    {
        $validated['status'] = 'rejected';
        $updateBook['status'] = 'available';

        $borrow = Borrow::find($id);
        $book = Book::find($borrow->isbn);

        $book->update($updateBook);
        $borrow->update($validated);

        return response()->json([
            'data' => $borrow
        ]);
    }

    public function return(Borrow $borrow)
    {
        $borrows = Borrow::latest()
            ->with('book')
            ->with('member')
            ->where('status', 'borrowed')
            ->get();

        return response()->json([
            'data' => $borrows
        ]);
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

        return response()->json([
            'data' => $borrow
        ]);
    }

    public function allHistory()
    {
        $borrows = Borrow::where('status', '!=', 'requested')
            ->with('book')
            ->with('member')
            ->latest()
            ->get();

        return response()->json([
            'data' => $borrows
        ]);
    }

    public function outOffDate()
    {
        $borrows = Borrow::where('must_return_date', '<=', date('Y-m-d'))
            ->where('status', 'borrowed')
            ->with('book')
            ->with('member')
            ->latest()
            ->get();

        return response()->json([
            'data' => $borrows
        ]);
    }

    public function request(Request $request, $id)
    {
        $validated['isbn'] = $id;
        $validated['member_id'] = $request->member_id;
        $validated['status'] = 'requested';

        $updateBook['status'] = 'borrowed';

        $book = Book::find($validated['isbn']);

        $book->update($updateBook);
        $borrow = Borrow::create($validated);

        return response()->json([
            'data' => $borrow
        ]);
    }
}
