@extends('layouts.pagelayout')
@section('content')

<style type="text/css">
	
.chat-window{
    bottom:0;
    position:fixed;
    float:right;
    margin-left:10px;
}
.chat-window > div > .panel{
    border-radius: 5px 5px 0 0;
}
.icon_minim{
    padding:2px 10px;
}
.msg_container_base{
  background: #e5e5e5;
  margin: 0;
  padding: 0 10px 10px;
  max-height:300px;
  overflow-x:hidden;
}
.top-bar {
  background: #666;
  color: white;
  padding: 10px;
  position: relative;
  overflow: hidden;
}
.msg_receive{
    padding-left:0;
    margin-left:0;
}
.msg_sent{
    padding-bottom:20px !important;
    margin-right:0;
}
.messages {
  background: white;
  padding: 10px;
  border-radius: 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
  max-width:100%;
}
.messages > p {
    font-size: 13px;
    margin: 0 0 0.2rem 0;
  }
.messages > time {
    font-size: 11px;
    color: #ccc;
}
.msg_container {
    padding: 10px;
    overflow: hidden;
    display: flex;
}
img {
    display: block;
    width: 100%;
}
.avatar {
    position: relative;
}
.base_receive > .avatar:after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    width: 0;
    height: 0;
    border: 5px solid #FFF;
    border-left-color: rgba(0, 0, 0, 0);
    border-bottom-color: rgba(0, 0, 0, 0);
}

.base_sent {
  justify-content: flex-end;
  align-items: flex-end;
}
.base_sent > .avatar:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 0;
    border: 5px solid white;
    border-right-color: transparent;
    border-top-color: transparent;
    box-shadow: 1px 1px 2px rgba(black, 0.2); // not quite perfect but close
}

.msg_sent > time{
    float: right;
}



.msg_container_base::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

.msg_container_base::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

.btn-group.dropup{
    position:fixed;
    left:0px;
    bottom:0;
}
</style>

<script src="/js/paginathing.js"></script>
<link rel="stylesheet" type="text/css" href="https://prevwong.github.io/drooltip.js/assets/drooltip/css/drooltip.css">
<script src="{{asset('js/drooltip.js')}}"></script>

<script>
    $(document).ready(function(){
        $(document).on('click','.requestuserid', function() {
        id = $(this).attr('id');
      url = ajaxurl+'/requestuserid';
        $.get(
          url,
          {id : id},
          function(data) {
            $('.show').html(data);
          });
      });
    })
</script>
    	<div class="gap"></div>
    @php
            $user_id=App\User::find($id);
            $vendors=App\vendors::where('user_id','=',$user_id->id)->first();
            $bankdetails=App\Bankdetails::where('user_id','=',$user_id->id)->first();
             
            @endphp

<div class="container" style="width: 90%;">
    <img src="{{url('/img/products/'.$vendors->banner)}}"  style="    height: 300px;
    position: absolute;
    z-index: 1;
    width: 1180px;">
    <img src="{{url('/img/products/'.$vendors->image)}}"   style="width: 250px;height: 250px;position: absolute;margin-top: 70px;z-index: 1;border-radius: 10px;">
	<div class="row">
		<div class="col-md-12 bg-wrapper">
		</div>
	</div>

		<div class="row">
			<div class="col-md-12 box">
				<div class="row">
					<div class="col-md-3">
                        
					
				</div>

				<div class="col-md-3">
                    <h2>@if($vendorproduct) {{ App\vendorproduct::where('user_id','=',$vendorproduct->user_id)->count() }} @else 0 @endif products</h2>
                </div>
                <div class="col-md-3">
                    <h2>{{App\Http\Controllers\HomeController::converter( $totalprice )}} earned</h2>
                </div>
                <div class="col-md-3">
                    <h2>{{ $totalcustomer->count() }} customer</h2>
                </div>
                @if(Auth::user()->user_type !='Admin')
                <div class="col-md-2 pull-right">
					<?php
					if (Auth::check()) {
					?>
					<span class="sure">
					<?php echo $follow ?>
					</span>
					<?php	# code...
					}
					 ?>
                     <?php 
                                            if(Auth::check()){
                                                $customersvendor = DB::table('customersvendor')->where('customer_id', Auth::user()->id)->where('vendor_id', $id)->first();
                                            }
                                                if (!empty($customersvendor)) {
                                                        if ($customersvendor->status == 'yes') {?>
                                                         <p class='bg-primary text-center' style='    position: absolute;
    right: 150px;'>Contacted</p>
                                                   <?php }elseif ($customersvendor->verification == 'pending') {?>
                                                        <p class='bg-success text-center' style='padding: 3px;position: absolute;
    right: 140px;'>Pending</p>
                                                    <?php }
                                                    else{ ?>
                                                    <button class='btn btn-primary btn-sm requestuseidr' id="$id" style="position: absolute;right: 140px;">Request Invitation</button>
                                                   <?php }
                                                }else{?>
                                                 <div class="show">
                                                   <button type="button" class="btn btn-primary requestuserid myTooltip" id="<?php echo $id  ?>" title="Click this button to Send a request to this vendor, to buy and pay in 15 days or 30 days" style="position: absolute;right: 140px;"> Send Credit Request</button>
                                                 </div>
                                              <?php  }
                                            ?>
				</div>
                @endif
				</div>
				
			
			</div>
		</div>
	<br>
	<div class="row box">
		<div class="col-md-3 rows" >
			<h2 ><?php echo $vendorname->name; ?><small style="color: blue;">({{$vendors->ratings}})</small></h2>
			<h4>About Vendor</h4>
			<ul>
				<li>Location:{{$vendors->location}}@if($vendors->state), {{$vendors->state}}  @endif</li>
				<li>Type:{{$vendors->vendor_type}}</li>
                <li> CAC :{{$vendors->cac}}</li>
				<!--<li>Contact:{{$vendors->contactphone}}</li>-->
			</ul>

            @if(Auth::user()->user_type=='Admin')
            <h4>Bank Details</h4>
            @if($bankdetails)
            <ul>
                <li>Bank Name: {{$bankdetails->bank_name}}</li>
                <li>Account Name:{{$bankdetails->account_name}}</li>
                <li>Account Number:{{$bankdetails->account_number}}</li>
                <li>Account Type:@if($bankdetails->account_type==1) Current @else Saving @endif</li>
                <!--<li>Contact:{{$vendors->contactphone}}</li>-->
            </ul>
            @else
            <li>Bank detail is not set by this user</li>
            @endif
            @endif
			<h4>Categories</h4>
			<br>
			<?php echo $category; ?>

	</div>
		<div class="col-md-9 rows" style="border-left: 1px solid #000">
				<div class="row">
	                <?php echo $view; ?>
				</div>
				
		</div>
		@if(Auth::check())
		<?php
		$sender_id=Auth::user()->id;
		$receiver_id=$id;
				$messages=App\message::where('sent_user_id','=',$sender_id)->where('receiver_user_id','=',$receiver_id)->orwhere(function($query) use ($receiver_id,$sender_id){
			$query->where('sent_user_id','=',$receiver_id)->where('receiver_user_id','=',$sender_id);
		});
		$msgs=$messages->get();
		  ?>
		<div class="container">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;">
        <div class="col-xs-12 col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - {{$vendorname->name}}</h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                       <!-- <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>-->
                    </div>
                </div>
                <div class="panel-body msg_container_base">
                	@foreach($msgs as $ms)
                	@if($ms->sent_user_id==Auth::user()->id)
                    <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10">
                            <div class="messages msg_sent">
                                <p>{{$ms->mesage}}</p>
                                <time datetime="2009-11-13T20:00">{{$ms->created_at->diffForHumans()}}</time>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                    @else
                    @php
                    $ms->isread=1;
                    $ms->save();
                    @endphp
                    <div class="row msg_container base_receive">
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                        <div class="col-md-10 col-xs-10">
                            <div class="messages msg_receive">
                                <p>{{$ms->mesage}}</p>
                                <time datetime="2009-11-13T20:00">{{$ms->created_at->diffForHumans()}}</time>
                            </div>
                        </div>
                    </div>
                    @endif
                   @endforeach
                    
                </div>
                <form action="{{url('customer/send/message')}}" method="POST" accept-charset="utf-8">
                	{{csrf_field()}}
                	<input type="hidden" name="sender" value="{{Auth::user()->id}}">
                	<input type="hidden" name="receiver" value="{{$id}}">
                <div class="panel-footer">
                    <div class="input-group">
                        <input id="btn-input" name="message" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" type="submit" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>
                 </form>
    		</div>
        </div>
    </div>
    
    </div>
    @endif
	</div>
	
</div>

<script>
	$(document).ready(function(){
        var tooltip = new Drooltip({"element" : ".myTooltip"});
		$(document).on('click', '.panel-heading span.icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('focus', '.panel-footer input.chat_input', function (e) {
    var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideDown();
        $('#minim_chat_window').removeClass('panel-collapsed');
        $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '#new_chat', function (e) {
    var size = $( ".chat-window:last-child" ).css("margin-left");
     size_total = parseInt(size) + 400;
    alert(size_total);
    var clone = $( "#chat_window_1" ).clone().appendTo( ".container" );
    clone.css("margin-left", size_total);
});
$(document).on('click', '.icon_close', function (e) {
    //$(this).parent().parent().parent().parent().remove();
    $( "#chat_window_1" ).remove();
});
$("#favorite").click(function(){
    favorite='{{$vendors->user_id}}';
   $.ajax({
    url:'{{url('favorite/vendor')}}',
    method:'GET',
    data:{data:favorite},
    dataType:'json',
    success:function(data){
       if(data=='favorite'){
        $("#favorite").remove();
        $('.sure').append('<button class="btn btn-default pull-right follow" id="unfavorite">unfavorite</button>');
       }
    }
   })
})
$("#unfavorite").click(function(){
 favorite='{{$vendors->user_id}}';
   $.ajax({
    url:'{{url('unfavorite/vendor')}}',
    method:'GET',
    data:{data:favorite},
    dataType:'json',
    success:function(data){
       if(data=='unfavorite'){
        $("#unfavorite").remove();
        $('.show').append('<button class="btn btn-default pull-right follow" id="favorite">favorite</button>');
       }
    }
   })
})
	})
</script>

@endsection