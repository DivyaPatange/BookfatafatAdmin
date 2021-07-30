@extends('vendor.vendor_layout.main')
@section('title', 'Product')
@section('page_title', 'Product Detail')
@section('customcss')

</style>
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
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Product Name</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ $product->product_name }}</p>
                            </div>
                        </div>
                        <?php 
                            $category = DB::table('categories')->where('id', $product->category_id)->first();
                            $subCategory = DB::table('sub_categories')->where('id', $product->sub_category_id)->first();
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Category</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>: @if(!empty($category)){{ $category->cat_name }} @endif</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Sub-Category</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>: @if(!empty($subCategory)){{ $subCategory->sub_category }} @endif</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Selling Price</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ $product->selling_price }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Cost Price</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ $product->cost_price }}</p>
                            </div>
                        </div>        
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Description</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ $product->description }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>Status</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>: {{ $product->status }}</p>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $explodeImg = explode(",", $product->product_img)
                    ?>
                    <div class="col-md-6">
                        <div id="demo" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                @for($i=0; $i < count($explodeImg); $i++)
                                <li data-target="#demo" data-slide-to="{{ $i }}" @if($i == 0) class="active" @endif></li>
                                @endfor
                            </ul>
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                @for($i=0; $i < count($explodeImg); $i++)
                                <div class="carousel-item @if($i == 0) active @endif">
                                    <img src="{{ asset('ProductImg/'.$explodeImg[$i]) }}" alt="Los Angeles" width="100%" height="250px">
                                </div>
                                @endfor
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            </a>

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