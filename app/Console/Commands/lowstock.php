<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\vendorproduct;
use App\notification;
class lowstock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:low';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'low stock';

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
        $products=vendorproduct::all();
        foreach ($products as $product) {
            if($product->stack_count ==NULL || $product->stack_count<50){
                $oldnotification=notification::where('user_id','=',$product->user_id)->delete();
                $adminnot=notification::where('user_id','=',40)->delete();
                $notification=new notification;
                $notification->user_id=$product->user_id;
                $notification->notification='your'.$product->name.' stock is low ('.$product->stock_count.')';
                $adminnotification=new notification;
                $adminnotification->user_id=40;
                $adminnotification->notification='your'.$product->name.' stock is low ('.$product->stock_count.')';
                $adminnotification->save();
                $notification->save();
            }
        }
        
    }
}
