<div class="col-sm-8">
</div>
<div class="col-sm-4 list-search">
    <div class="search_form">
        {{ Form::open(array('method'=>'GET','url'=>$url,'class'=>'navbar-form navbar-right','role'=>'search')) }}
        <div class="input-group custom-search-form">
            {{ Form::text($inputname, Input::old($inputname), array('class' => 'form-control ', 'placeholder'=>$placeholder ,'required' => 'required')) }}
            <span class="input-group-btn">
                <button class="btn btn-default-sm" type="submit">
                    <i class="fa fa-search"></i>
                </button>
    		</span>
        </div>                  
         {{ Form::close() }}
         </div>
  </div>