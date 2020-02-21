<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Customer Q & A</title>
    @include('includes.head')
</head>

@include('includes.header')

        <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="dashboard1.html">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="{{url('admin/index')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="{{url('admin/veiw_customer_q_a')}}">Customers Q & A</a>
                    </li>
                   
                </ol>
            </div>
            
        </header>

    <section id="content" class="table-layout animated fadeIn">

         
            <!-- -------------- /Column Left -------------- -->

            <!-- -------------- Column Center -------------- -->
            <div class="chute chute-center">

                <div class="mw1000 center-block">

                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              
                            </div>
                            <div class="panel-body">

              
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            
                                            <th class="va-m">Product</th>
                                            <th>Vendor</th>
                                            <th class="va-m">Question</th>
                                            <th class="va-m">Answer</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($q_a as $key)
                                            <tr>
                                                
                                                <td>{{$key->name}}</td>
                                                <td>@if($key->user_id) {{App\User::find($key->user_id)->name}} @endif</td>
                                                <td>{{$key->question}}</td>
                                                <td>
                                                    @if($key->answer_status == 'yes')
                                                        {{$key->answer}}
                                                    @else
                                                        <form action="{{url('admin/answer/'.$key->id)}}">
                                                            <textarea name="answer"></textarea>
                                                            <button class="btn btn-primary btn-xs">send</button>
                                                        </form>
                                                    @endif
                                                </td>

                                                
                                                
                                            </tr>
                                          @endforeach
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                      

                                

                                <!-- -------------- /form -------------- -->



                            </div>
                        </div>

                    </div>



                </div>
            </div>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
