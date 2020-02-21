<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\orders;
use App\Notification;
class pendingDelivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pending:delivery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $orders=orders::all();
        foreach ($orders as $order) {
       if($order->deliverystatus=='pending'){
        $notification=new notification;
        $notification->user_id=$order->vendor_id;
        $notification->notification='order '.$order->ordernumber.' is still pending';
        $notification->save();
       }
        }
    }
}
