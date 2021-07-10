@extends('admin.admin_layout.main')
@section('title', 'Order Details')
@section('page_title', 'Order Details')
@section('customcss')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
		<div class="alert alert-success alert-block mt-3">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong><i class="fa fa-check text-white">&nbsp;</i>{{ $message }}</strong>
		</div>
		@endif
		@if ($message = Session::get('danger'))
		<div class="alert alert-danger alert-block mt-3">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong>{{ $message }}</strong>
		</div>
		@endif
    </div>
</div>
<div class="row mb-3">
    <div class="col-lg-12">
        <!-- Simple Tables -->
        <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6>Customer Details</h6>
            </div>
            <hr>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <p><b>Customer Name:</b></p>
                    </div>
                    <?php 
                        $user = DB::table('users')->where('id', $order->user_id)->first();
                        $payment = DB::table('payments')->where('order_id', $order->id)->first();
                    ?>
                    <div class="col-md-3">
                        <p>@if(!empty($user)) {{ $user->name }} @endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Email:</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>@if(!empty($user)) {{ $user->email }} @endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Mobile No.:</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>@if(!empty($user)) {{ $user->mobile_no }} @endif</p>
                    </div>
                    <?php 
                        $userInfo = DB::table('user_infos')->where('user_id', $order->user_id)->first();
                    ?>
                    <div class="col-md-3">
                        <p><b>Address:</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>@if(!empty($userInfo)) {{ $userInfo->address }} @endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Country:</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>@if(!empty($userInfo)) {{ $userInfo->country }} @endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>City:</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>@if(!empty($userInfo)) {{ $userInfo->city }} @endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Pincode:</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>@if(!empty($userInfo)) {{ $userInfo->pin_code }} @endif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6>Order Details</h6>
            </div>
            <hr>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Order No. </b></p>
                    </div>
                    <div class="col-md-6">
                        <p>: {{ $order->order_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Product Count</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>: {{ $order->item_count }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Grand Total</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>: {{ $order->grand_total }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Payment Status</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>: @if(!empty($payment)) Paid @else Not-Paid @endif</p>
                    </div>
                    @if(!empty($payment))
                    <div class="col-md-6">
                        <p><b>Transaction ID</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>: {{ $payment->transaction_id }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Payment Mode</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>: {{ $payment->payment_mode }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>Payment Date</b></p>
                    </div>
                    <div class="col-md-6">
                        <p>: {{ date("d-m-Y H:i:s", strtotime($payment->payment_datetime)) }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6>Product Details</h6>
            </div>
            <hr>
            <?php 
                $orderItem = DB::table('order_items')->where('order_id', $order->id)->get();
            ?>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        @foreach($orderItem as $o)
                        <?php 
                            $product = DB::table('products')->where('id', $o->product_id)->first();
                        ?>
                        <tr>
                            <td>@if(!empty($product)) {{ $product->product_name }} @endif</td>
                            <td>{{ $o->quantity }}</td>
                            <td><i class="fas fa-rupee">&nbsp;</i>{{ $o->price }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Row-->

@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

@endsection