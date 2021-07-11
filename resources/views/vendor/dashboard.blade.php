@extends('vendor.vendor_layout.main')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('customcss')

@endsection
@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h3>Hello {{ Auth::guard('vendor')->user()->business_owner_name }}</h3>
        <h5>Welcome to Bookfatafat!</h5>
    </div>
</div>
<div class="row mb-3">
    <!-- New User Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <?php 
                            $products = DB::table('products')->where('vendor_id', Auth::guard('vendor')->user()->id)->get();
                        ?>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Products</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ count($products) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fab fa-product-hunt fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New User Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <?php 
                            $services = DB::table('services')->where('vendor_id', Auth::guard('vendor')->user()->id)->get();
                        ?>
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Services</div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ count($services) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-server fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <?php 
                        $currentMonth = date('m');
                        $orders = DB::table('orders')->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
                        $items = array();
                        foreach($orders as $o)
                        {
                            $orderItems = DB::table('order_items')->where('order_id', $o->id)->where('vendor_id', Auth::guard('vendor')->user()->id)->get();
                            foreach($orderItems as $orderItem)
                            {
                                $items[] = $orderItem->order_id;
                            }
                        }
                        $countOrder = array_unique($items);
                    ?>
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Order Placed (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($countOrder) }}</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Since last month</span> -->
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <?php 
                    $bookings = DB::table('book_services')->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get();
                ?>
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Booking (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($bookings) }}</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Since last years</span> -->
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <?php 
                    $payments = DB::table('payments')->whereRaw('MONTH(payment_datetime) = ?',[$currentMonth])->get();
                ?>
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Payment (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($payments) }}</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Since yesterday</span> -->
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-warning"></i>
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