@extends('vendor.vendor_layout.main')
@section('title', 'Profile')
@section('page_title', 'Profile')
@section('customcss')

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
    <div class="col-md-12">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Documents</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <?php 
                                    $id = Auth::guard('vendor')->user()->id;
                                ?>
                                <a href="{{ route('vendor.profile.edit', $id) }}"><button type="button" class="btn btn-danger">Edit Profile</button></a>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p><b>Business Name</b></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>: {{ $vendor->business_name }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><b>Business Type</b></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>: {{ $vendor->business_type }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><b>Business Owner Name</b></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>: {{ $vendor->business_owner_name }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><b>Business Start Date</b></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>: {{ $vendor->business_start_date }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><b>Location</b></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>: {{ $vendor->location }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><b>Address</b></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p>: {{ $vendor->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @if($vendor->aadhar_img)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Aadhar Image</h5>
                                            </div>
                                            <div class="card-body">
                                                <img src="{{  URL::asset('AadharImg/' . $vendor->aadhar_img) }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($vendor->pan_img)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Pan Image</h5>
                                            </div>
                                            <div class="card-body">
                                                <img src="{{  URL::asset('PanImg/' . $vendor->pan_img) }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($vendor->shop_img)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Shop Image</h5>
                                            </div>
                                            <div class="card-body">
                                                <img src="{{  URL::asset('ShopImg/' . $vendor->shop_img) }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Row-->
@endsection
@section('customjs')

@endsection