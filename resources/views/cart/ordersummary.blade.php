@extends('layouts.pagelayout')
@section('content')

	<div class="gap"></div>
        <div class="container">
            <div class="payment-success-icon fa fa-check-circle-o"></div>
            <div class="payment-success-title-area">
                <h1 class="payment-success-title">{{$name}}, your payment was successful!</h1>
                <p class="lead">Order details has been send to <strong>{{$email}}</strong>
                </p>
            </div>
            <div class="gap gap-small"></div>
            <div class="row row-col-gap">
                <div class="col-md-4">
                    <h3 class="widget-title">Order Summary</h3>
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $product; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <h3 class="widget-title">Billing/Shipping Details</h3>
                    <div class="box">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Shipping Details</th>
                                    <th>Billing Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $billing; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="gap gap-small"></div>
            <h3 class="widget-title">You Might Also Like</h3>
            
        </div>
        <div class="gap"></div>

@endsection