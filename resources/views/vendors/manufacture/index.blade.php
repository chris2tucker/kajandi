<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manufacture</title>
    @include('includes_vendor.head')
</head>

@include('includes_vendor.header')
        <header id="topbar" class="alt">
            <div class="topbar-left">
                <ol class="breadcrumb">
                    <li class="breadcrumb-icon">
                        <a href="dashboard1.html">
                            <span class="fa fa-home"></span>
                        </a>
                    </li>
                    <li class="breadcrumb-active">
                        <a href="{{url('vendors/index')}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-link">
                        <a href="{{url('vendors/manufacture')}}">Manufacture</a>
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
                                <a href="{{ URL::to('vendors/manufacture/create') }}" class="btn btn-bordered btn-primary mb5">Add Manufacture</a>
                            </div>
                            <div class="panel-body">

              
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            
                                            <th class="va-m">Manufacture</th>
                                            <th class="va-m">Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                          @foreach($manufacture as $key)
                                            <tr>
                                                <td>{{$key->name}}</td> 
                                                <td>  
                                                    <a href="{{ URL::to('vendors/manufacture/' . $key->id . '/edit') }}" class="btn btn-primary btn-xs edit"><span class="ti-pencil"></span> Edit</a>
                                                    

                                               <!--      {{ Form::open(array('url' => 'vendors/manufacture/' . $key->id, 'class' => 'pull-left delete ')) }}
                                                        {{ Form::hidden('_method', 'DELETE') }}
                                                        {{ Form::button('<span class="ti-trash"></span> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs'] )  }}  
                                                        
                                                    {{ Form::close() }} -->
                                                    
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

<script>

 $(".delete").on("submit", function(){
        
        return confirm("Do you want to delete this item?");
        
    });
    
</script>
            <!-- -------------- /Column Center -------------- -->
@include('includes.footer')
