@extends('admin.admin_layout.main')
@section('title', 'Today Order Placed List')
@section('page_title', 'Today Order Placed List')
@section('customcss')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://use.fontawesome.com/d5c7b56460.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<style>
td.details-control:before {
    font-family: 'FontAwesome';
    content: '\f105';
    display: block;
    text-align: center;
    font-size: 20px;
}
tr.shown td.details-control:before{
   font-family: 'FontAwesome';
    content: '\f107';
    display: block;
    text-align: center;
    font-size: 20px;
}

.select2-container .select2-selection--single{
    height:42px;
}
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
		<div class="alert alert-success alert-block mt-3">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong>{{ $message }}</strong>
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
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>Order Number</th>
                            <th>Amount</th>
                            <th>Product Quantity</th>
                            <th>Payment Status</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Mobile No.</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Order Number</th>
                            <th>Amount</th>
                            <th>Product Quantity</th>
                            <th>Payment Status</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Mobile No.</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                    </tbody>
                </table>
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.js-example').select2();

});
var SITEURL = '{{ route('admin.todayOrderPlaced')}}';
$(document).ready(function() {
    var table =$('#dataTableHover').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url: SITEURL,
        type: 'GET',
        },
        columns: [
            { data: 'order_number', name: 'order_number' },
            { data: 'grand_total', name: 'grand_total' },
            { data: 'item_count', name: 'item_count' },
            { data: 'payment_status', name: 'payment_status' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'mobile_no', name: 'mobile_no' },
        ],
        order: [[0, 'desc']]
    })
});

</script>
@endsection