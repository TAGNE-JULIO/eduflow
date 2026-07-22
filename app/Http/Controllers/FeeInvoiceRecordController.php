<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayFeeInvoiceRequest;
use App\Http\Requests\StoreFeeInvoiceRecordRequest;
use App\Http\Requests\UpdateFeeInvoiceRecordRequest;
use App\Models\FeeInvoiceRecord;
use App\Services\Fee\FeeInvoiceRecordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class FeeInvoiceRecordController extends Controller
{
    public FeeInvoiceRecordService $feeInvoiceRecordService;

    public function __construct(FeeInvoiceRecordService $feeInvoiceRecordService)
    {
        $this->feeInvoiceRecordService = $feeInvoiceRecordService;

        $this->authorizeResource(FeeInvoiceRecord::class, 'fee_invoice_record');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeInvoiceRecordRequest $request): RedirectResponse
    {
        $this->feeInvoiceRecordService->storeFeeInvoiceRecord($request->validated());

        return back()->with('success', 'Fee added to Fee Invoice Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeeInvoiceRecord $feeInvoiceRecord): Response
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeeInvoiceRecord $feeInvoiceRecord): Response
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeInvoiceRecordRequest $request, FeeInvoiceRecord $feeInvoiceRecord): RedirectResponse
    {
        $this->feeInvoiceRecordService->updateFeeInvoiceRecord($feeInvoiceRecord, $request->validated());

        return back()->with('success', 'Fee Details Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeeInvoiceRecord $feeInvoiceRecord): RedirectResponse
    {
        $this->feeInvoiceRecordService->deleteFeeInvoiceRecord($feeInvoiceRecord);

        return back()->with('success', 'Fee Removed From Fee Invoice Successfully');
    }

    public function pay(FeeInvoiceRecord $feeInvoiceRecord, PayFeeInvoiceRequest $request): RedirectResponse
    {
        $this->authorize('update', [$feeInvoiceRecord]);
        $this->feeInvoiceRecordService->addPayment($feeInvoiceRecord, $request->validated());

        return back()->with('success', 'Payment added to Fee Successfully');
    }

    public function stripePay(FeeInvoiceRecord $feeInvoiceRecord, Request $request): RedirectResponse
    {
        $this->authorize('update', [$feeInvoiceRecord]);

        $amountToPay = $request->input('pay');
        if (!$amountToPay || $amountToPay <= 0) {
            return back()->with('danger', 'Invalid payment amount');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $feeInvoiceRecord->fee->name,
                        'description' => 'Payment for ' . $feeInvoiceRecord->feeInvoice->name,
                    ],
                    'unit_amount' => $amountToPay * 100, // Stripe expects cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('fee-invoices-records.stripe-success', ['session_id' => '{CHECKOUT_SESSION_ID}', 'record_id' => $feeInvoiceRecord->id, 'amount' => $amountToPay]),
            'cancel_url' => route('fee-invoices-records.stripe-cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function stripeSuccess(Request $request): RedirectResponse
    {
        $sessionId = $request->input('session_id');
        $recordId = $request->input('record_id');
        $amount = $request->input('amount');

        if (!$sessionId || !$recordId || !$amount) {
            return redirect()->route('dashboard')->with('danger', 'Invalid payment session');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));
        
        try {
            $session = Session::retrieve($sessionId);
            if ($session->payment_status === 'paid') {
                $feeInvoiceRecord = FeeInvoiceRecord::findOrFail($recordId);
                
                // Add payment to the record
                $this->feeInvoiceRecordService->addPayment($feeInvoiceRecord, [
                    'pay' => $amount
                ]);
                
                return redirect()->route('fee-invoices.pay', $feeInvoiceRecord->fee_invoice_id)
                                 ->with('success', 'Online Payment Successful');
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('danger', 'Error verifying payment: ' . $e->getMessage());
        }

        return redirect()->route('dashboard')->with('danger', 'Payment not completed');
    }

    public function stripeCancel(): RedirectResponse
    {
        return redirect()->route('dashboard')->with('danger', 'Payment was cancelled');
    }
}
