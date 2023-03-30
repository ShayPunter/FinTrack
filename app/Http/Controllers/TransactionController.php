<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Transaction::paginate(100));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // nothing yet
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'category' => 'string',
            'amount' => 'decimal:0,4|required',
        ]);

        try {
            // todo: add some form of intelligent processing to auto-categorise transactions
            $transaction = new Transaction();
            $transaction->name = $request->name;

            if ($request->category == null) {
                $transaction->category = 'undefined';
            } else {
                $transaction->category = $request->category;
            }

            $transaction->amount = $request->amount;
            $transaction->save();
        } catch (\Exception $e) {
            return response('', 500)->json($e);
        }

        return response()->json('Record created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return response()->json($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // nothing yet
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'name' => 'string|required',
            'category' => 'string',
            'amount' => 'decimal:0,4|required',
        ]);

        $transaction->name = $request->name;
        $transaction->category = $request->category;
        $transaction->amount = $request->amount;
        $transaction->save();

        return response()->json('Record updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json('Record deleted');
    }
}
