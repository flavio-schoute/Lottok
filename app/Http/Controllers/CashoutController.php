<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashoutRequest;
use App\Models\User;
use App\Services\CashoutService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CashoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('payments.cashout.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CashoutRequest $request
     * @return RedirectResponse
     */
    public function store(CashoutRequest $request): RedirectResponse
    {
        // Handle real life bank account details, like getting the bank account number etc. or in this case it is already fixed, and we have it
        // Processing...

        // Get the amount and convert it to float
        $amount = $request->safe()->only('amount');
        $amount = floatval($amount['amount']);

        try {
            $credits = (new CashoutService())->handleCashout($amount);
        } catch (\Exception $exception) {
            return redirect()->back(303)->withErrors(['cashout_errors' => $exception->getMessage()]);
        }

        // Update the user credits and return
        User::query()->where('id', '=', auth()->user()->id)->update(['credits' => $credits]);

        // Handle real life bank process to add cash to the bank of the user
        // ...

        return redirect()->route('cashout.index')->with('success', 'Uitbetaling is gelukt! Het kan 3 tot 5 werkdagen duren.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
