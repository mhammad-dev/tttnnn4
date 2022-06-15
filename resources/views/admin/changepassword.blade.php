@extends('admin.layout.master')
@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
  </ol>
</nav>
@if ($message = Session::get('errors'))
    <div class="alert alert-danger">
      <p>{{ $message }}</p>
    </div>
@elseif($message = Session::get('success'))
    <div class="alert alert-success">
       <p>{{ $message }}</p>
    </div>
@endif
<div class="row justify-content-center">
 <div class="col-md-6 grid-margin stretch-card">
    <div class="card pb-3 pt-3">
      <div class="card-body">
        <h6 class="card-title">Change Password</h6>
        <form class="forms-sample" method="POST" action="{{ route('admin_change_password') }}">
          @csrf
          <div class="form-group">
            <label for="exampleInputPassword1">Old Password</label>
            <input type="password" class="form-control" id="oldpassword" autocomplete="off" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">New Password</label>
            <input type="password" class="form-control" id="newpassword" autocomplete="off" placeholder="Password" name="new_password" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmpassword" autocomplete="off" placeholder="Password" name="confirm_password" required>
          </div>
          <button type="submit" class="btn btn-primary mr-2">Update Password</button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection
