@extends('admin.admin_layout.main')
@section('title', 'Vendor')
@section('page_title', 'Vendor Profile')
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
    <div class="col-lg-12 mb-4">
        <!-- Simple Tables -->
        <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="btn btn-primary">Login to Vendor</button></a>
                <form action="{{ route('vendor.login.submit') }}" method="post" target="_blank">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $vendor->id}}">
                    <input type="hidden" name="username" value="{{ $vendor->username }}">
                    <input type="hidden" name="password" value="{{ $vendor->show_pwd}}">
                </form>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <tr>
                        <th class="thead-light" width="40%">Business Owner Name</th>
                        <td>{{ $vendor->business_owner_name }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Name</th>
                        <td>{{ $vendor->business_name }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Type</th>
                        <td>{{ $vendor->business_type }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Start Date</th>
                        <td>{{ $vendor->business_start_date }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Location</th>
                        <td>{{ $vendor->location }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">Business Address</th>
                        <td>{{ $vendor->address }}</td>
                    </tr>
                    <tr>
                        <th class="thead-light" width="40%">GST No.</th>
                        <td>{{ $vendor->gst_no }}</td>
                    </tr>
                    @if($vendor->aadhar_img)
                    <tr>
                        <th class="thead-light" width="40%">Aadhar Image</th>
                        <td>
                            <img src="{{  URL::asset('AadharImg/' . $vendor->aadhar_img) }}" width="25%">
                        </td>
                    </tr>
                    @endif
                    @if($vendor->pan_img)
                    <tr>
                        <th class="thead-light" width="40%">Pan Image</th>
                        <td>
                            <img src="{{  URL::asset('PanImg/' . $vendor->pan_img) }}" width="25%">
                        </td>
                    </tr>
                    @endif
                    @if($vendor->shop_img)
                    <tr>
                        <th class="thead-light" width="40%">Business Shop Image</th>
                        <td>
                            <img src="{{  URL::asset('ShopImg/' . $vendor->shop_img) }}" width="25%">
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="card-footer"></div>
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