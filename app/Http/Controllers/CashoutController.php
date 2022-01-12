<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashoutRequest;
use App\Models\User;
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
        // TODO: Add iban or something?

        // Get the amount and convert it to float
        $amount = $request->safe()->only('amount');
        $amount = floatval($amount['amount']);

        // If the amount is less than 20 euro we redirect the user back with error message
        if ($amount < 20) {
            return redirect()->back(303)->withErrors(['cashout_error_less_than_20_euro' => 'Het minimale bedrag moet 20 euro zijn.']);
        }

        $userCredits = auth()->user()->credits;

        // Calculate tax for the owner and insert it into the database
        $cashoutTax = $amount / 100 * 7;

        DB::table('cashout_customers')->insert([
            'user_id' => auth()->user()->id,
            'tax_credits' => $cashoutTax,
            'cashout_date' => Carbon::now()
        ]);

        // Calculate new user credits
        $amount = $amount - $cashoutTax;
        $newUserCredits = $userCredits - $amount;

        // Check if the new calculated credits is not less than 0 if so, return with error message
        if ($newUserCredits < 0) {
            return redirect()->back(303)->withErrors(['cashout_error_less_than_0_euro' => 'Je hebt niet genoeg credits.']);
        }



        // Update the user credits and return
        User::query()->where('id', '=', auth()->user()->id)->update(['credits' => $newUserCredits]);

        // Handle real life bank process to add cash to the bank of the user
        // ...

        return redirect()->route('cashout.index')->with('success', 'Uitbetaling is gelukt!');
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
