<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\User;
use App\Services\LottokPaymentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('payments.pay.index');
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
     * @param PaymentRequest $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(PaymentRequest $request): Redirector|RedirectResponse|Application
    {
        try {
            // Get the requested amount, convert to string and then in a number
            $requestedAmount = $request->validated();
            $stringAmount = implode("", $requestedAmount);
            $amount = floatval($stringAmount);

            // Handle payment in the service class
            $session = (new LottokPaymentService())->pay($amount, auth()->user()->stripe_id);

            // TODO: Future webhook handling credits update
            // Normally you handle this in webhook, but the webhook isn't working
            // Stripe support didn't know how to fix it. The webhook gives a status 200 but you get HTML doc with 503.
            // Now we just update and the credits, this is a NOT DONE in real life
            // See: https://gyazo.com/a54728843bee0eb3fb6afa0b445e42a2

            $currentUserCredits = auth()->user()->credits;
            $newUserCredits = $currentUserCredits + $amount;
            User::query()->where('id', auth()->user()->id)->update(['credits' => $newUserCredits]);

            // Redirect to the hosted Stripe page to handle the payment
            return redirect($session->url, 303);

        } catch (\Exception $e) {
            return redirect()->route('pay.index')->withErrors(['payment_error' => $e->getMessage()]);
        }
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
