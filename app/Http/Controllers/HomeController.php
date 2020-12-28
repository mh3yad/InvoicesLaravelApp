<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count= Invoice::all()->count();
        $invoice_unpaid = round(Invoice::where('status_id',1)->count() / $count * 100);
        $invoice_partial = round(Invoice::where('status_id',2)->count()/ $count * 100);
        $invoice_paid =round( Invoice::where('status_id',3)->count() / $count * 100);
        $chartjs = app()->chartjs
            ->name('vertical')
            ->type('bar')
            ->size(['width' => 400, 'height' => 150])
            ->labels(['unpaid', 'partial', 'paid',])
            ->datasets([
                [
                    "label" => "Invoices details",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$invoice_unpaid, $invoice_partial, $invoice_paid],
                ],

            ])
            ->options([]);

        return view('index', compact('chartjs'));
    }
}
