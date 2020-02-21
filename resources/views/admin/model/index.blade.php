<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Model</title>
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
                        <a href="{{url('aadmin/model')}}">Model</a>
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
                                <a href="{{ URL::to('admin/model/create') }}" class="btn btn-bordered btn-primary mb5">Add Model</a>
                            </div>
                            <div class="panel-body">

              
                            <div class="panel-body pn">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped mg-t" id="table">
                                        <thead>
                                        <tr>
                                            
                                            <th class="va-m">Model</th>
                                            <th class="va-m">Created_by</th>
                                            <th class="va-m">Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                          @foreach($model as $key)
                                            <tr>
                                                <td>{{$key->name}}</td> 
                                                <td>{{$key->created_by}}</td>
                                                <td>  
                                                    <a href="{{ URL::to('admin/model/' . $key->id . '/edit') }}" class="btn btn-primary btn-xs edit"><span class="ti-pencil"></span> Edit</a>
                                                    

                                                     {{ Form::open(array('url' => 'admin/model/' . $key->id, 'class' => 'pull-left delete ')) }}
                                                        {{ Form::hidden('_method', 'DELETE') }}
                                                        {{ Form::button('<span class="ti-trash"></span> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs'] )  }}  
                                                        
                                                    {{ Form::close() }}
                                                    
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
