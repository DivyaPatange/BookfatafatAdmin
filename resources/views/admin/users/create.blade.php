@extends('admin.admin_layout.main')
@section('title', 'User')
@section('page_title', 'Add User')
@section('customcss')
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script> -->
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

@endsection
@section('content')
<div class="row mb-3">
    <div class="col-lg-12">
        <!-- Form Basic -->
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Add User</h6>
            </div>
            <div class="card-body">
                <form method="POST" id="submitForm" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label> <span  style="color:red" id="name_err"> </span>
                            <input type="text" name="name" class="form-control" id="name"
                            placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label> <span  style="color:red" id="email_err"> </span>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label> <span  style="color:red" id="pwd_err"> </span>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="con_pwd">Confirm Password</label> <span  style="color:red" id="con_pwd_err"> </span>
                            <input type="password" name="password_confirmation" class="form-control" id="con_pwd" placeholder="Enter Confirm Password">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="role_access">Role Access <span style="color:red" id="access_err"></span></label><br>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" name="role_access[]" class="form-check-input" value="User">User
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" name="role_access[]" class="form-check-input" value="Vendor">Vendor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" name="role_access[]" class="form-check-input" value="Category">Category
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" name="role_access[]" class="form-check-input" value="Sub-Category">Sub-Category
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" name="role_access[]" class="form-check-input" value="Product">Product
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" name="role_access[]" class="form-check-input" value="Services">Services
                        </label>
                    </div>
                </div>
                <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Row-->

@endsection
@section('customjs')
<script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    // alert(‘1’);
    $('#service').select2();

});

$('body').on('click', '#submitButton', function () {
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var confirmPassword = $("#con_pwd").val();
    var searchIDs = $("#submitForm input:checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    // alert(searchIDs);
    if (name=="") {
        $("#name_err").fadeIn().html("Required");
        setTimeout(function(){ $("#name_err").fadeOut(); }, 3000);
        $("#name").focus();
        return false;
    }
    if (email=="") {
        $("#email_err").fadeIn().html("Required");
        setTimeout(function(){ $("#email_err").fadeOut(); }, 3000);
        $("#email").focus();
        return false;
    }
    if (password=="") {
        $("#pwd_err").fadeIn().html("Required");
        setTimeout(function(){ $("#pwd_err").fadeOut(); }, 3000);
        $("#password").focus();
        return false;
    }
    if (confirmPassword=="") {
        $("#con_pwd_err").fadeIn().html("Required");
        setTimeout(function(){ $("#con_pwd_err").fadeOut(); }, 3000);
        $("#con_pwd").focus();
        return false;
    }
    if (password != confirmPassword)
    {
        $("#con_pwd_err").fadeIn().html("Password Does Not March!");
        setTimeout(function(){ $("#con_pwd_err").fadeOut(); }, 3000);
        $("#con_pwd").focus();
        return false;
    }
    if (searchIDs=="") {
        $("#access_err").fadeIn().html("Required");
        setTimeout(function(){ $("#access_err").fadeOut(); }, 3000);
        // $("#email").focus();
        return false;
    }
    else
    { 
        $("#submitForm").submit();
    }
})
function checkPasswordMatch() {
    var password = $("#password").val();
    var confirmPassword = $("#con_pwd").val();
    if (password != confirmPassword)
    {
        $("#con_pwd_err").html("Passwords does not match!");
    }
    else{
        $("#con_pwd_err").html("Passwords match.");
    }

}
$(document).ready(function () {
    $("#con_pwd").keyup(checkPasswordMatch);
});
</script>
@endsection