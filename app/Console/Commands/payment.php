<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\outstandingpayment;
use carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\duepaymentMail;
class payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment command';

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
        $outstandingpayments=outstandingpayment::all();
        foreach ($outstandingpayments as $payment) {
           $orderdate=Carbon::parse($payment->dateordered);
           $fifthday=$orderdate->addDays(5);
           $tenthday=$fifthday->addDays(5);
           $fifteenday=$tenthday->addDays(5);
           $twenthday=$fifteenday->addDays(5);
           $twentfifthday=$twenthday->addDays(5);
           $twnthsixth=$twentfifthday->addDays(1);
           $twentseventh=$twnthsixth->addDays(1);
           $twnteight=$twentseventh->addDays(1);
           $twentninth=$twnteight->addDays(1);
           $tees=$twentninth->addDays(1);
           if(Carbon::today()->toDateString()==$fifthday->toDateString() || Carbon::today()->toDateString()==$tenthday->toDateString() || Carbon::today()->toDateString()==$fifteenday->toDateString() || Carbon::today()->toDateString()==$twenthday->toDateString()|| Carbon::today()->toDateString()==$twentfifthday->toDateString()|| Carbon::today()->toDateString()==$twnthsixth->toDateString()||  Carbon::today()->toDateString()==$twentseventh->toDateString()|| Carbon::today()->toDateString()==$twnteight->toDateString()|| Carbon::today()->toDateString()==$twentninth->toDateString()|| Carbon::today()->toDateString()==$tees->toDateString()){
            $user=User::find($payment->user_id);
            Mail::to($user->email)->send(new duepaymentMail());
           }

        }
    }
}
