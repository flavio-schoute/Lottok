<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;

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
    public function store(PaymentRequest $request)
    {
        try {
            // Get the requested amount, convert to string and then in a number
            $requestedAmount = $request->validated();
            $stringAmount = implode("", $requestedAmount);
            $amount = floatval($stringAmount);

            // Get the customer and the currency
            $customer = Customer::retrieve(auth()->user()->stripe_id);
            $currency = config('cashier.currency');

            // The url the user will be redirected to if the payment succeed or canceled
            $returnUrl = redirect()->route('pay.index')->getTargetUrl();

            $unitAmount = $amount * 100;

            // Checkout session
            $session = Session::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => $currency,
                        'product_data' => [
                            'name' => 'Credits Lottok',
                        ],
                        'unit_amount' => $unitAmount,
                    ],
                    'quantity' => 1,
                ]],
                'payment_method_types' => ['ideal'],
                'metadata' => [
                    'product' => 'Credit Lottok'
                ],
                'mode' => 'payment',
                'customer' => $customer,
                'billing_address_collection' => 'required',
                'phone_number_collection' => [
                    'enabled' => true
                ],
                'submit_type' => 'pay',
                'success_url' => $returnUrl . '?succes=true&amount=' . $unitAmount,
                'cancel_url' => $returnUrl
            ]);

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
