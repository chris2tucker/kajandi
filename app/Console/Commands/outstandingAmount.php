<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\outstandingpayment;
use carbon\Carbon;
use App\vendorproduct;
use App\ordersdetail;
class outstandingAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oustanding:extend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto extend 30 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $outstandingpayment=outstandingpayment::where('payment','=','pending')->where('payoptions','=','2')->get();
        foreach ($outstandingpayment as $payment) {
            $orderdate=Carbon::parse($payment->dateordered);
            $orderdate=$orderdate->addDays(15);
            if(Carbon::today()->toDateString() >$orderdate->toDateString()){
                $product=vendorproduct::where('product_id','=',$payment->product_id)->first();
                $payment->price=$product->pricewithin30days;
                $payment->totalprice=$product->pricewithin30days*$payment->quantity;
                $payment->save();
                $orderdetails=ordersdetail::where('ordernumber','=',$payment->ordernumber)->where('product_id','=',$payment->product_id)->first();
                if($orderdetails){
                    $orderdetails->price=$product->pricewithin30days;
                    $orderdetails->totalprice=$product->pricewithin30days*$orderdetails->quantity;
                    $orderdetails->save();
                }

            }
        }
    }
}
