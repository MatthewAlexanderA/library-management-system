<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Borrow $borrow)
    {
        $borrow = Borrow::latest()->get();

        return view('admin.borrow.index', compact('borrow'));
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
            'title' => 'required',
            'desc' => 'required',
            'category' => 'required',
            'keyword' => 'required',
            'tag' => 'required',
        ]);

        $validated['date'] = date('Y-m-d');

        Borrow::create($validated);

        return redirect()->route('borrow.index')
            ->with('success', 'Add Success!');
    }

    public function edit($id)
    {
        $borrow = Borrow::find($id);

        return view('admin.borrow.edit', compact('borrow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'desc' => 'required',
            'category' => 'required',
            'keyword' => 'required',
            'tag' => 'required',
        ];

        $validated = $request->validate($rules);

        $borrow = Borrow::find($id);

        $borrow->update($validated);

        return redirect()->route('borrow.index')
            ->with('success', 'Update Success!');
    }

    public function destroy(Borrow $borrow)
    {
        $borrow->delete($borrow->id);

        return redirect()->route('borrow.index')
            ->with('success', 'Delete Success!');
    }
}
