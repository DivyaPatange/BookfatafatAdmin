@extends('vendor.vendor_layout.main')
@section('title', 'Placed Order')
@section('page_title', 'Placed Order List')
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
            <div class="card-header py-3 ">
                <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
            </div>
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th></th>
                            <th>User Name</th>
                            <th>Mobile No.</th>
                            <th>Order No.</th>
                            <th>Product Count</th>
                            <th>Total Price</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>User Name</th>
                            <th>Mobile No.</th>
                            <th>Order No.</th>
                            <th>Product Count</th>
                            <th>Total Price</th>
                            <th>Payment Status</th>
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
var SITEURL = '{{ route('vendor.placed-order')}}';
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px; width:100%">'+
        '<tr>'+
            '<td style="text-align:center">Action</td>'+
            '<td style="text-align:center">'+d.action+'</td>'+
        '</tr>'+
    '</table>';
}
$(document).ready(function() {
    var table =$('#dataTableHover').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: SITEURL,
            type: 'GET'
        },
        columns: [
            { 
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { data: 'user_name', name: 'user_name' },
            { data: 'mobile_no', name: 'mobile_no' },
            { data: 'order_number', name: 'order_number' },
            { data: 'item_count', name: 'item_count' },
            { data: 'grand_total', name: 'grand_total' },
            { data: 'payment_status', name: 'payment_status' },
        ],
        order: [[0, 'desc']]
    })
    $('#dataTableHover tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});
</script>
@endsection