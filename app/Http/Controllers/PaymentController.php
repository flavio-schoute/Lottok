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
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
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
     * @return Application|Redirector|RedirectResponse|void
     */
    public function store(PaymentRequest $request)
    {
        try {
            $amount = 10;
            $requestData = $request->validated();

//            $amount = match ($requestData) {
//                $requestData['amount-5'] => $requestData['amount-5'],
//                $requestData['amount-10'] => $requestData['amount-10'],
//                $requestData['amount-20'] => $requestData['amount-20'],
//                $requestData['other-amount'] => $requestData['other-amount'],
//            };



            $customer = Customer::retrieve(auth()->user()->stripe_id);
            $currency = config('cashier.currency');

            $returnUrl = redirect()->route('pay.index')->getTargetUrl();

            $unitAmount = $amount * 100;

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

            return redirect($session->url, 303);

        } catch (ApiErrorException $e) {
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
