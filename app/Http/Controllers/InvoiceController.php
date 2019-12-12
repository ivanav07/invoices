<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Invoice;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class InvoiceController
 *
 * @package App\Http\Controllers
 */
class InvoiceController extends Controller
{
    /**
     * InvoiceController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all employee's invoices
     *
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $invoices = Auth::user()->invoices();
        return view('invoices', compact('invoices'));
    }

    /**
     * Show PDF invoice
     *
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $invoice    = Invoice::find($id);
        $activities = Activity::where('invoice_id', $invoice->id)->get();
        $user       = $invoice->user();

        $pdf = PDF::loadView('pdf-invoice', compact('invoice','activities','user'));
        return $pdf->stream();
    }

    /**
     * Show unpaid invoices to the employer
     *
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unpaidInvoices()
    {
        $invoices = Invoice::where('paid', 0)->get();

        return view('admin.invoices-unpaid', compact('invoices'));
    }

    /**
     * Show paid invoices to the employer
     *
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paidInvoices()
    {
        $invoices = Invoice::where('paid', '!=', 0)->get();

        return view('admin.invoices-paid', compact('invoices'));
    }

    /**
     * Creating a new invoice from all activities which are accepted and not yet invoiced
     *
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $user          = Auth::user();
        $activities    = $user->activities()->whereNull('invoice_id')->where('accepted', true)->get();
        $invoice       = new Invoice();
        $invoice->note = $request->note;
        $invoice->save();
        $total_earned = 0;
        foreach ($activities as $activity)
        {
            $total_earned         += $activity->earned;
            $activity->invoice_id = $invoice->id;
            $activity->save();
        }
        $invoice->total_sum = $total_earned;
        $invoice->save();

        return back();
    }

    /**
     * Employer marks the invoice as paid
     *
     * @author Ivana Vasic <kontakt@ivanavasic.rs>
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pay($id)
    {
        Invoice::find($id)->update(['paid' => 1]);
        return back();
    }
}
