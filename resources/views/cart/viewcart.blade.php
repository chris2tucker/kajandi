@extends('layouts.pagelayout')
@section('content')
<style type="text/css">
    button.btncart{
        background: transparent;
        border: none;
    }
</style>
<div class="container">
        @if(empty($cartbag))
            <?php echo $view ?>
        @else
            <header class="page-header">
                <h1 class="page-title">My Shopping Bag</h1>
            </header>
            <div class="row">
                <div class="col-md-10">
                    @if(Session::has('status'))
                            <p class="alert alert-success alert-dismissable fade in">{{ Session::get('status') }}</p>
                            @endif

                    <div class="data"></div>

                    <table class="table table table-shopping-cart">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Type</th>
                                <th>Pay On Delivery</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php echo $view ?>
                        </tbody>
                    </table>
                    <div class="gap gap-small"></div>
                </div>
                <div class="col-md-2">
                    <ul class="shopping-cart-total-list">

                        <li><span>Subtotal</span><span>{{App\Http\Controllers\HomeController::converter($subtotal)}}</span>
                        </li>
                        <li><span>Shipping</span><span>{{App\Http\Controllers\HomeController::converter($totalshipping)}}</span>
                        </li>
                        <li><span>Taxes</span><span><?php echo App\Http\Controllers\HomeController::converter($tax); ?></span>
                        </li>
                        <li><span>Total</span><span><?php echo App\Http\Controllers\HomeController::converter($totalamt); ?></span>
                        </li>
                    </ul><a class="btn btn-primary" @if($notNew) onclick="return window.confirm('You are about to purchase a refurbished or fairly used item from a listed vendor. We do not provide any guarantee for such products. Visit terms and conditions for more information '); event.preventDefault()" @endif href="{{url('/checkout')}}">Checkout</a>
                </div>
            </div>
            <ul class="list-inline">
                <li><a class="btn btn-default" href="{{url('/')}}">Continue Shopping</a>
                </li>
               <!-- <li><a class="btn btn-default" href="#">Update Bag</a>
                </li>-->
            </ul>
    @endif
        </div>
        <div class="gap"></div>
@endsection