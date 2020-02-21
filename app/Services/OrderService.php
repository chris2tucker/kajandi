<?php namespace App\Services;

use App\currency;
use App\orders;
use Illuminate\Support\Facades\Session;

class OrderService
{
    public function orderSummary(orders $order)
    {
        $order->load('orderdetails');
        $amounts = $this->getDefaultAmounts();
        $amounts['shipping']['amount'] = $order->shipping_fee;
        foreach ($order->orderdetails as $orderitem) {
            if ($orderitem->payondelivery) {
                $amounts['on_delivery']['amount'] += $orderitem->totalprice;
            } else if ($orderitem->payoptions === 1) {
                $amounts['subtotal']['amount'] += $orderitem->totalprice;
                $amounts['payable']['amount'] += $orderitem->totalprice;
            } else if ($orderitem->payoptions === 2) {
                $amounts['15_payment']['amount'] += $orderitem->totalprice;
            } else if ($orderitem->payoptions === 3) {
                $amounts['30_payment']['amount'] += $orderitem->totalprice;
            }
        }
        $amounts['payable']['amount'] += $order->shipping_fee;

        $amounts = $this->addTotal($amounts);

        return collect($this->convertAmounts($amounts))->sortBy('order');
    }

    protected function getDefaultAmounts()
    {
        return [
            'subtotal'  =>  [
                'order' =>  0,
                'amount'    =>  0,
                'label'     =>  'Subtotal',
            ],
            'shipping'  =>  [
                'order' =>  1,
                'amount'    =>  0,
                'label'     =>  'Shipping',
            ],

            'on_delivery'  =>  [
                'order' =>  2,
                'amount'    =>  0,
                'label'     =>  'Pay on Delivery',
            ],
            '15_payment'  =>  [
                'order' =>  3,
                'amount'    =>  0,
                'label'     =>  'Pay in 15 Days',
            ],
            '30_payment'  =>  [
                'order' =>  4,
                'amount'    =>  0,
                'label'     =>  'Pay in 30 Days',
            ],
            'payable'  =>  [
                'order' =>  6,
                'amount'    =>  0,
                'label'     =>  '<strong>Payable Amount</strong>',
            ],
        ];
    }

    protected function converter($price)
    {
        if (Session::has('currency')) {
            if ($price > 99) {
                $getPrice = currency::find(1);
                if (Session::get('currency') == 'Dollar') {
                    $price = "$ " . number_format((float)$price * $getPrice->Dollar);
                } else {
                    if (Session::get('currency') == 'Yen') {
                        $price = "¥ " . number_format($price * $getPrice->Yen);

                    } else {
                        if (Session::get('currency') == 'Euro') {
                            $price = "€ " . number_format($price * $getPrice->Euro);


                        } else {
                            $price = "₦ " . number_format($price);

                        }
                    }
                }
            } else {
                $getPrice = currency::find(1);
                if (Session::get('currency') == 'Dollar') {
                    $price = "$ " . ($price * $getPrice->Dollar);
                } else {
                    if (Session::get('currency') == 'Yen') {
                        $price = "¥ " . ($price * $getPrice->Yen);

                    } else {
                        if (Session::get('currency') == 'Euro') {
                            $price = "€ " . ($price * $getPrice->Euro);


                        } else {
                            $price = "₦ " . ($price);

                        }
                    }
                }
            }
        } else {

            $price = "₦ " . number_format($price);

        }


        return $price;
    }

    protected function convertAmounts(array $amounts)
    {
        foreach ($amounts as $name => $amount)   {
            if ($name === 'payable') {
                $amounts[$name]['amount_str'] = '<strong>'.$this->converter($amounts[$name]['amount']).'</strong>';
            } else {
                $amounts[$name]['amount_str'] = $this->converter($amounts[$name]['amount']);
            }
        }
        return $amounts;
    }

    protected function addTotal(array $amounts)
    {
        $total = 0;
        foreach ($amounts as $name => $amount)   {
            if ($name !== 'payable') {
                $total += $amount['amount'];
            }
        }
        $amounts['total']   =   [
            'order' =>  5,
            'amount'    =>  $total,
                'label'     =>  'Total Amount',
        ];
        return $amounts;
    }
}