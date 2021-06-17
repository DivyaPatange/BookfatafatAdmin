@extends('vendor.vendor_layout.main')
@section('title', 'Available Date')
@section('page_title', 'Available Date')
@section('customcss')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
.hidden{
    display:none;
}
.datepicker {
  padding: 4px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  direction: ltr;
}
.datepicker-inline {
  width: 220px;
}
.datepicker.datepicker-rtl {
  direction: rtl;
}
.datepicker.datepicker-rtl table tr td span {
  float: right;
}
.datepicker-dropdown {
  top: 0;
  left: 0;
}
.datepicker-dropdown:before {
  content: '';
  display: inline-block;
  border-left: 7px solid transparent;
  border-right: 7px solid transparent;
  border-bottom: 7px solid #999999;
  border-top: 0;
  border-bottom-color: rgba(0, 0, 0, 0.2);
  position: absolute;
}
.datepicker-dropdown:after {
  content: '';
  display: inline-block;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-bottom: 6px solid #ffffff;
  border-top: 0;
  position: absolute;
}
.datepicker-dropdown.datepicker-orient-left:before {
  left: 6px;
}
.datepicker-dropdown.datepicker-orient-left:after {
  left: 7px;
}
.datepicker-dropdown.datepicker-orient-right:before {
  right: 6px;
}
.datepicker-dropdown.datepicker-orient-right:after {
  right: 7px;
}
.datepicker-dropdown.datepicker-orient-bottom:before {
  top: -7px;
}
.datepicker-dropdown.datepicker-orient-bottom:after {
  top: -6px;
}
.datepicker-dropdown.datepicker-orient-top:before {
  bottom: -7px;
  border-bottom: 0;
  border-top: 7px solid #999999;
}
.datepicker-dropdown.datepicker-orient-top:after {
  bottom: -6px;
  border-bottom: 0;
  border-top: 6px solid #ffffff;
}
.datepicker > div {
  display: none;
}
.datepicker table {
  margin: 0;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.datepicker td,
.datepicker th {
  text-align: center;
  width: 20px;
  height: 20px;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  border: none;
}
.table-striped .datepicker table tr td,
.table-striped .datepicker table tr th {
  background-color: transparent;
}
.datepicker table tr td.day:hover,
.datepicker table tr td.day.focused {
  background: #eeeeee;
  cursor: pointer;
}
.datepicker table tr td.old,
.datepicker table tr td.new {
  color: #999999;
}
.datepicker table tr td.disabled,
.datepicker table tr td.disabled:hover {
  background: none;
  color: #999999;
  cursor: default;
}
.datepicker table tr td.highlighted {
  background: #d9edf7;
  border-radius: 0;
}
.datepicker table tr td.today,
.datepicker table tr td.today:hover,
.datepicker table tr td.today.disabled,
.datepicker table tr td.today.disabled:hover {
  background-color: #fde19a;
  background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
  background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
  border-color: #fdf59a #fdf59a #fbed50;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #000;
}
.datepicker table tr td.today:hover,
.datepicker table tr td.today:hover:hover,
.datepicker table tr td.today.disabled:hover,
.datepicker table tr td.today.disabled:hover:hover,
.datepicker table tr td.today:active,
.datepicker table tr td.today:hover:active,
.datepicker table tr td.today.disabled:active,
.datepicker table tr td.today.disabled:hover:active,
.datepicker table tr td.today.active,
.datepicker table tr td.today:hover.active,
.datepicker table tr td.today.disabled.active,
.datepicker table tr td.today.disabled:hover.active,
.datepicker table tr td.today.disabled,
.datepicker table tr td.today:hover.disabled,
.datepicker table tr td.today.disabled.disabled,
.datepicker table tr td.today.disabled:hover.disabled,
.datepicker table tr td.today[disabled],
.datepicker table tr td.today:hover[disabled],
.datepicker table tr td.today.disabled[disabled],
.datepicker table tr td.today.disabled:hover[disabled] {
  background-color: #fdf59a;
}
.datepicker table tr td.today:active,
.datepicker table tr td.today:hover:active,
.datepicker table tr td.today.disabled:active,
.datepicker table tr td.today.disabled:hover:active,
.datepicker table tr td.today.active,
.datepicker table tr td.today:hover.active,
.datepicker table tr td.today.disabled.active,
.datepicker table tr td.today.disabled:hover.active {
  background-color: #fbf069 \9;
}
.datepicker table tr td.today:hover:hover {
  color: #000;
}
.datepicker table tr td.today.active:hover {
  color: #fff;
}
.datepicker table tr td.range,
.datepicker table tr td.range:hover,
.datepicker table tr td.range.disabled,
.datepicker table tr td.range.disabled:hover {
  background: #eeeeee;
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}
.datepicker table tr td.range.today,
.datepicker table tr td.range.today:hover,
.datepicker table tr td.range.today.disabled,
.datepicker table tr td.range.today.disabled:hover {
  background-color: #f3d17a;
  background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
  background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
  border-color: #f3e97a #f3e97a #edde34;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  border-radius: 0;
}
.datepicker table tr td.range.today:hover,
.datepicker table tr td.range.today:hover:hover,
.datepicker table tr td.range.today.disabled:hover,
.datepicker table tr td.range.today.disabled:hover:hover,
.datepicker table tr td.range.today:active,
.datepicker table tr td.range.today:hover:active,
.datepicker table tr td.range.today.disabled:active,
.datepicker table tr td.range.today.disabled:hover:active,
.datepicker table tr td.range.today.active,
.datepicker table tr td.range.today:hover.active,
.datepicker table tr td.range.today.disabled.active,
.datepicker table tr td.range.today.disabled:hover.active,
.datepicker table tr td.range.today.disabled,
.datepicker table tr td.range.today:hover.disabled,
.datepicker table tr td.range.today.disabled.disabled,
.datepicker table tr td.range.today.disabled:hover.disabled,
.datepicker table tr td.range.today[disabled],
.datepicker table tr td.range.today:hover[disabled],
.datepicker table tr td.range.today.disabled[disabled],
.datepicker table tr td.range.today.disabled:hover[disabled] {
  background-color: #f3e97a;
}
.datepicker table tr td.range.today:active,
.datepicker table tr td.range.today:hover:active,
.datepicker table tr td.range.today.disabled:active,
.datepicker table tr td.range.today.disabled:hover:active,
.datepicker table tr td.range.today.active,
.datepicker table tr td.range.today:hover.active,
.datepicker table tr td.range.today.disabled.active,
.datepicker table tr td.range.today.disabled:hover.active {
  background-color: #efe24b \9;
}
.datepicker table tr td.selected,
.datepicker table tr td.selected:hover,
.datepicker table tr td.selected.disabled,
.datepicker table tr td.selected.disabled:hover {
  background-color: #9e9e9e;
  background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
  background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
  background-image: linear-gradient(to bottom, #b3b3b3, #808080);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
  border-color: #808080 #808080 #595959;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td.selected:hover,
.datepicker table tr td.selected:hover:hover,
.datepicker table tr td.selected.disabled:hover,
.datepicker table tr td.selected.disabled:hover:hover,
.datepicker table tr td.selected:active,
.datepicker table tr td.selected:hover:active,
.datepicker table tr td.selected.disabled:active,
.datepicker table tr td.selected.disabled:hover:active,
.datepicker table tr td.selected.active,
.datepicker table tr td.selected:hover.active,
.datepicker table tr td.selected.disabled.active,
.datepicker table tr td.selected.disabled:hover.active,
.datepicker table tr td.selected.disabled,
.datepicker table tr td.selected:hover.disabled,
.datepicker table tr td.selected.disabled.disabled,
.datepicker table tr td.selected.disabled:hover.disabled,
.datepicker table tr td.selected[disabled],
.datepicker table tr td.selected:hover[disabled],
.datepicker table tr td.selected.disabled[disabled],
.datepicker table tr td.selected.disabled:hover[disabled] {
  background-color: #808080;
}
.datepicker table tr td.selected:active,
.datepicker table tr td.selected:hover:active,
.datepicker table tr td.selected.disabled:active,
.datepicker table tr td.selected.disabled:hover:active,
.datepicker table tr td.selected.active,
.datepicker table tr td.selected:hover.active,
.datepicker table tr td.selected.disabled.active,
.datepicker table tr td.selected.disabled:hover.active {
  background-color: #666666 \9;
}
.datepicker table tr td.active,
.datepicker table tr td.active:hover,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active.disabled:hover {
  background-color: #006dcc;
  background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
  background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: linear-gradient(to bottom, #0088cc, #0044cc);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
  border-color: #0044cc #0044cc #002a80;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td.active:hover,
.datepicker table tr td.active:hover:hover,
.datepicker table tr td.active.disabled:hover,
.datepicker table tr td.active.disabled:hover:hover,
.datepicker table tr td.active:active,
.datepicker table tr td.active:hover:active,
.datepicker table tr td.active.disabled:active,
.datepicker table tr td.active.disabled:hover:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active:hover.active,
.datepicker table tr td.active.disabled.active,
.datepicker table tr td.active.disabled:hover.active,
.datepicker table tr td.active.disabled,
.datepicker table tr td.active:hover.disabled,
.datepicker table tr td.active.disabled.disabled,
.datepicker table tr td.active.disabled:hover.disabled,
.datepicker table tr td.active[disabled],
.datepicker table tr td.active:hover[disabled],
.datepicker table tr td.active.disabled[disabled],
.datepicker table tr td.active.disabled:hover[disabled] {
  background-color: #0044cc;
}
.datepicker table tr td.active:active,
.datepicker table tr td.active:hover:active,
.datepicker table tr td.active.disabled:active,
.datepicker table tr td.active.disabled:hover:active,
.datepicker table tr td.active.active,
.datepicker table tr td.active:hover.active,
.datepicker table tr td.active.disabled.active,
.datepicker table tr td.active.disabled:hover.active {
  background-color: #003399 \9;
}
.datepicker table tr td span {
  display: block;
  width: 23%;
  height: 54px;
  line-height: 54px;
  float: left;
  margin: 1%;
  cursor: pointer;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
}
.datepicker table tr td span:hover {
  background: #eeeeee;
}
.datepicker table tr td span.disabled,
.datepicker table tr td span.disabled:hover {
  background: none;
  color: #999999;
  cursor: default;
}
.datepicker table tr td span.active,
.datepicker table tr td span.active:hover,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active.disabled:hover {
  background-color: #006dcc;
  background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
  background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
  background-image: linear-gradient(to bottom, #0088cc, #0044cc);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
  border-color: #0044cc #0044cc #002a80;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
  color: #fff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
.datepicker table tr td span.active:hover,
.datepicker table tr td span.active:hover:hover,
.datepicker table tr td span.active.disabled:hover,
.datepicker table tr td span.active.disabled:hover:hover,
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active,
.datepicker table tr td span.active.disabled,
.datepicker table tr td span.active:hover.disabled,
.datepicker table tr td span.active.disabled.disabled,
.datepicker table tr td span.active.disabled:hover.disabled,
.datepicker table tr td span.active[disabled],
.datepicker table tr td span.active:hover[disabled],
.datepicker table tr td span.active.disabled[disabled],
.datepicker table tr td span.active.disabled:hover[disabled] {
  background-color: #0044cc;
}
.datepicker table tr td span.active:active,
.datepicker table tr td span.active:hover:active,
.datepicker table tr td span.active.disabled:active,
.datepicker table tr td span.active.disabled:hover:active,
.datepicker table tr td span.active.active,
.datepicker table tr td span.active:hover.active,
.datepicker table tr td span.active.disabled.active,
.datepicker table tr td span.active.disabled:hover.active {
  background-color: #003399 \9;
}
.datepicker table tr td span.old,
.datepicker table tr td span.new {
  color: #999999;
}
.datepicker .datepicker-switch {
  width: 145px;
}
.datepicker .datepicker-switch,
.datepicker .prev,
.datepicker .next,
.datepicker tfoot tr th {
  cursor: pointer;
}
.datepicker .datepicker-switch:hover,
.datepicker .prev:hover,
.datepicker .next:hover,
.datepicker tfoot tr th:hover {
  background: #eeeeee;
}
.datepicker .cw {
  font-size: 10px;
  width: 12px;
  padding: 0 2px 0 5px;
  vertical-align: middle;
}
.input-append.date .add-on,
.input-prepend.date .add-on {
  cursor: pointer;
}
.input-append.date .add-on i,
.input-prepend.date .add-on i {
  margin-top: 3px;
}
.input-daterange input {
  text-align: center;
}
.input-daterange input:first-child {
  -webkit-border-radius: 3px 0 0 3px;
  -moz-border-radius: 3px 0 0 3px;
  border-radius: 3px 0 0 3px;
}
.input-daterange input:last-child {
  -webkit-border-radius: 0 3px 3px 0;
  -moz-border-radius: 0 3px 3px 0;
  border-radius: 0 3px 3px 0;
}
.input-daterange .add-on {
  display: inline-block;
  width: auto;
  min-width: 16px;
  height: 18px;
  padding: 4px 5px;
  font-weight: normal;
  line-height: 18px;
  text-align: center;
  text-shadow: 0 1px 0 #ffffff;
  vertical-align: middle;
  background-color: #eeeeee;
  border: 1px solid #ccc;
  margin-left: -5px;
  margin-right: -5px;
}

</style>
@endsection
@section('content')
<div class="row mb-3">
  <div class="col-lg-12">
    <!-- Form Basic -->
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Add Service Available Date</h6>
      </div>
      <div class="card-body">
        <form method="POST" id="submitForm" enctype="multipart/form-data">
          <div class="row">
            <?php
              foreach($availableDate as $a)
              {
                $dates[] = date("d-m-Y", strtotime($a->available_date));
              }
            ?>
            <div class="col-md-6">
              <div class="form-group">
                <label for="date">Available Date <span class="text-danger" id="date_err"></span></label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control date" name="available_date" id="date" placeholder="Pick the multiple dates">
                    <div class="input-group-append">
                      <i class="fa fa-calendar input-group-text"></i>
                    </div>
                </div>
              </div>
            </div>
            @if($service->quantity)
            <div class="col-md-6">
              <div class="form-group">
                <label for="status">Quantity</label> <span  style="color:red" id="status_err"> </span>
                <input type="number" name="quantity" class="form-control" disabled id="quantity" value="{{ $service->quantity }}">
              </div>
            </div>
            @endif
            <div class="col-md-6">
              <div class="form-group">
                <label for="time_slot">Time Slot</label>
                <table class="table " id="dynamic_field">
                  <thead>
                    <tr>
                      <th>Start Time <span class="text-danger" id="from_err"></span></th>
                      <th>End Time <span class="text-danger" id="to_err"></span></th>
                      <th width="23%">Action</th>
                    </tr>
                  </thead>
                  <tbody id="table_example">
                    <tr>
                      <td><input type="time" name="from_time" id="from_time" class="form-control name_list" /></td>
                      <td><input type="time" name="to_time" id="to_time" class="form-control name_list" /></td>
                      <td><button type="button" name="add" id="add" class="btn btn-sm btn-primary">Add More</button></td>  
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!--Row-->
<div class="row mb-3">
  <div class="col-lg-12">
    <div class="card mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Marked Available Date List</h6>
      </div>
      <div class="table-responsive p-3">
        <table class="table align-items-center table-flush table-hover" id="dataTableHover">
          <thead class="thead-light">
            <tr>
              <th>Sr. No.</th>
              <th>Available Date</th>
              <th>Total Quantity</th>
              <th>Remain Quantity</th>
              <th>Status</th>
              <th>Time Slot</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Sr. No.</th>
              <th>Available Date</th>
              <th>Total Quantity</th>
              <th>Remain Quantity</th>
              <th>Status</th>
              <th>Time Slot</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
              
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Service Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="updateForm">
        <div class="modal-body">
          <div class="form-group">
            <label for="service_date" class="col-form-label">Available Date</label>
            <input type="date" class="form-control" id="service_date">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Status</label>
            <select name="status" id="status" class="form-control">
              <option value="">-Select Status-</option>
              <option value="Available">Available</option>
              <option value="Not Available">Not Available</option>
              <option value="Booked">Booked</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="id" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="updateButton" class="btn btn-primary" onclick="return checkSubmit()">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Time Slot</h5>
        <button type="button" id="add1" class="btn btn-primary btn-sm">Add New</button>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="serviceDiv"></tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="service_id" id="service_id" value="">
        <input type="hidden" name="vendor_id" id="vendor_id" value="">
        <input type="hidden" name="available_date_id" id="available_date_id" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('customjs')
<!-- Page level plugins -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
  <!-- <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function(){
  var i = 1;
  $("#add1").click(function(){
    i++;
    $('#serviceDiv').append('<tr id="row'+i+'"><td><input type="time" name="start_time" class="form-control name_list"/></td><td><input type="time" name="end_time" class="form-control name_list"/></td><td><button type="button" id="'+i+'" class="btn btn-sm add btn-success mr-2">Save</button><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove1">X</button></td></tr>');  
  });

  $(document).on('click', '.btn_remove1', function(){  
    var button_id = $(this).attr("id");   
    $('#row'+button_id+'').remove();  
  });
});
var SITEURL = '{{ route('vendor.service.getDate', $service->id)}}';
$('#dataTableHover').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
  url: "{{ route('vendor.service.show', $service->id) }}",
  type: 'GET',
  },
  columns: [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
    { data: 'available_date', name: 'available_date' },
    { data: 'total_quantity', name: 'total_quantity' },
    { data: 'remain_quantity', name: 'remain_quantity' },
    { data: 'status', name: 'status' },
    { data: 'time_slot', name: 'time_slot' },
    { data: 'action', name: 'action', orderable: false},
  ],
  order: [[0, 'desc']]
});

$('body').on('click', '#submitButton', function () {
  var date = $("#date").val();
  var quantity = $("#quantity").val();
  var service = "{{ $service->id }}";
  var from_time = $("#from_time").val();
  var to_time = $("#to_time").val();
  var TableData = new Array();
  $('#dynamic_field tr').each(function(row, tr) {
      TableData[row] = {
      "from": $(tr).find("input[name='from_time']").val(),
      "to": $(tr).find("input[name='to_time']").val()
      }//tableData[row]
  });
  TableData.shift(); // first row will be empty - so remove
  var Data;
  Data = JSON.stringify(TableData);
  if(!quantity)
  {
    quantity = "";
  }
  if (date=="") {
    $("#date_err").fadeIn().html("Required");
    setTimeout(function(){ $("#date_err").fadeOut(); }, 3000);
    $("#date").focus();
    return false;
  }
  if (from_time=="") {
    $("#from_err").fadeIn().html("Required");
    setTimeout(function(){ $("#from_err").fadeOut(); }, 3000);
    $("#from_time").focus();
    return false;
  }
  if (to_time=="") {
    $("#to_err").fadeIn().html("Required");
    setTimeout(function(){ $("#to_err").fadeOut(); }, 3000);
    $("#to_time").focus();
    return false;
  }
  else
  { 
    $.ajax({
      type:"POST",
      url:"{{ route('vendor.available-date.store') }}",
      data:{date:date, quantity:quantity, service:service, Data:Data},
      cache:false,        
      success:function(returndata)
      {
        // alert(returndata);
        document.getElementById("submitForm").reset();
        var oTable = $('#dataTableHover').dataTable(); 
        oTable.fnDraw(false);
        toastr.success(returndata.success);
      }
    });
  }
})

$('body').on('click', '#deleteTime', function () {
  var id = $(this).data("id");
  if(confirm("Are You sure want to delete !")){
    $.ajax({
      type: "delete",
      url: "{{ url('vendors/time-slot/delete') }}"+'/'+id,
      success: function (data) {
        var oTable = $('#dataTableHover').dataTable(); 
        oTable.fnDraw(false);
        if(data.success){
          toastr.success(data.success);
        }
        else{
          toastr.error(data.error);
        }
        $("#serviceModal").modal('hide');
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
});

$(document).on('click', '#editTime', function(){
  var $row = $(this).closest("tr");
  var id = $row.find("#editTime").data('id');
  var start_time = $row.find("input[name='start_time']").val();
  var end_time = $row.find("input[name='end_time']").val();
  $.ajax({
    type:"POST",
    url:"{{ route('vendor.service-time.update') }}",
    data:{id:id, start_time:start_time, end_time:end_time},
    cache:false,        
    success:function(returndata)
    {
      var oTable = $('#dataTableHover').dataTable(); 
      oTable.fnDraw(false);
      $("#serviceModal").modal('hide');
      toastr.success(returndata.success);
    }
  });
});

$(document).on('click', '.add', function(){
  var $row = $(this).closest("tr");;
  var start_time = $row.find("input[name='start_time']").val();
  var end_time = $row.find("input[name='end_time']").val();
  var service_id = $("#service_id").val();
  var vendor_id = $("#vendor_id").val();
  var available_date_id = $("#available_date_id").val();
  // alert(vendor_id);
  $.ajax({
    type:"POST",
    url:"{{ route('vendor.service-time.add') }}",
    data:{service_id:service_id, start_time:start_time, end_time:end_time, vendor_id:vendor_id, available_date_id:available_date_id},
    cache:false,        
    success:function(returndata)
    {
      var oTable = $('#dataTableHover').dataTable(); 
      oTable.fnDraw(false);
      $("#serviceModal").modal('hide');
      toastr.success(returndata.success);
    }
  });
});

$('body').on('click', '#delete', function () {
  var id = $(this).data("id");
  if(confirm("Are You sure want to delete !")){
    $.ajax({
      type: "delete",
      url: "{{ url('vendors/available-date') }}"+'/'+id,
      success: function (data) {
      var oTable = $('#dataTableHover').dataTable(); 
      oTable.fnDraw(false);
      toastr.success(data.success);
      location.reload(true);
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
});

$(function() {
  $.getJSON(SITEURL, function(json){
  var myBadDates=json;
  console.log(myBadDates);
  $('.date').datepicker({
    multidate: true,
    format: 'yyyy-mm-dd',
    beforeShowDay: function(date) {
      // console.log(date);
      var date = new Date(date),
      mnth = ("0" + (date.getMonth() + 1)).slice(-2),
      day = ("0" + date.getDate()).slice(-2);
      date1 = [date.getFullYear(), mnth, day].join("-");
      var excluded = $.inArray(date1, myBadDates) > -1;
      if(excluded == true)
      {
        return false;
      }
      else{
        console.log('enabled');
      }
    }
  });
// function checkAvailability(mydate){
//   console.log($myBadDates);
//   var $return=true;
//   var $returnclass ="available";
//   $checkdate = $.datepicker.formatDate('dd-mm-yyyy', mydate);
//   for(var i = 0; i < $myBadDates.length; i++)
//   {
//     if($myBadDates[i] == $checkdate)
//     {
//       $return = false;
//       $returnclass= "unavailable";
//     }
//   }
//   return [$return,$returnclass];
// }
  })
})

function ServiceModel(obj,bid)
{
  var datastring="bid="+bid;
  $.ajax({
    type:"POST",
    url:"{{ route('vendor.get.time-slot') }}",
    data:datastring,
    cache:false,        
    success:function(returndata)
    {
      // if (returndata!="0") {
        $("#serviceModal").modal('show');
        var json = JSON.parse(returndata);
        $("#service_id").val(json.service_id);
        $("#vendor_id").val(json.vendor_id);
        $("#available_date_id").val(json.available_date_id);
        $("#serviceDiv").html(json.service);
      // }
    }
  });
}

function EditModel(obj,bid)
{
  var datastring="bid="+bid;
  $.ajax({
    type:"POST",
    url:"{{ route('vendor.get.service-date') }}",
    data:datastring,
    cache:false,        
    success:function(returndata)
    {
      if (returndata!="0") {
        $("#myModal").modal('show');
        var json = JSON.parse(returndata);
        $("#id").val(json.id);
        $("#service_date").val(json.service_date);
        $("#status").val(json.status);
      }
    }
  });
}

function checkSubmit()
{
  var service_date = $("#service_date").val();
  var status = $("#status").val();
  var id = $("#id").val().trim();
  if (service_date=="") {
    $("#edit_date_err").fadeIn().html("Required");
    setTimeout(function(){ $("#edit_date_err").fadeOut(); }, 3000);
    $("#service_date").focus();
    return false;
  }
  if (status=="") {
    $("#status_err").fadeIn().html("Required");
    setTimeout(function(){ $("#status_err").fadeOut(); }, 3000);
    $("#status").focus();
    return false;
  }
  else
  { 
    $('#updateButton').attr('disabled',true);
    var datastring="service_date="+service_date+"&status="+status+"&id="+id;
    // alert(datastring);
    $.ajax({
      type:"POST",
      url:"{{ url('/vendors/service-date/update') }}",
      data:datastring,
      cache:false,        
      success:function(returndata)
      {
        $('#updateButton').attr('disabled',false);
        $("#myModal").modal("hide");
        var oTable = $('#dataTableHover').dataTable(); 
        oTable.fnDraw(false);
        if(returndata.success){
          toastr.success(returndata.success);
        }
        else{
          toastr.error(returndata.error);
        }
      }
    });
  }
}
$(document).ready(function(){
  var i = 1;
  $("#add").click(function(){
    i++;
    $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="time" name="from_time" class="form-control name_list"/></td><td><input type="time" name="to_time" class="form-control name_list"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">X</button></td></tr>');  
  });

  $(document).on('click', '.btn_remove', function(){  
    var button_id = $(this).attr("id");   
    $('#row'+button_id+'').remove();  
  });
});
</script>
@endsection