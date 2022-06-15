@extends('user.layout.master')
@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
  </ol>
</nav>

@if($message = Session::get('success'))
    <div class="alert alert-success">
       <p>{{ $message }}</p>
    </div>
@endif

<div class="row">
  <div class="col-md-12 stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Edit Profile</h6>
        
        <form method="POST" action="{{route('editprofile')}}" enctype="multipart/form-data">
        	@csrf
        <div class="row">
        	<div class="col-sm-6">
	          <div class="form-group">
	            <label for="ibm">IBM Number</label>
	            <input type="text" class="form-control" id="ibm" name="ibm" value="{{$user->ibm}}" readonly>
	          </div>
	        </div>
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label for="policy_number">Policy Number</label>
	            <input type="text" class="form-control" id="policy_number" name="policy_number" value="{{$user->policy_number}}" readonly>
	          </div>
	        </div>
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label for="name">Name</label>
	            <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" placeholder="Enter Name">
	          </div>
	        </div>

	        <div class="col-sm-6">
	          <div class="form-group">
	            <label for="surname">Surname</label>
	            <input type="text" class="form-control" id="surname" name="surname" value="{{$user->surname}}" placeholder="Enter Surname">
          	  </div>
	        </div>
            <div class="col-sm-6">
          	  <div class="form-group">
	            <label for="email">Email</label>
	            <input type="email" class="form-control" id="email" value="{{$user->email}}" name="email"  placeholder="Enter Email">
              </div>
            </div>
            <div class="col-sm-6">
	          <div class="form-group">
	            <label for="whatsapp_number">Whatsapp Number</label>
	            <input type="number" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{$user->whatsapp_number}}" placeholder="Enter Whatsapp Number">
	          </div>
	        </div>
	        <div class="col-sm-12">
	          <div class="form-group">
	            <label for="productname">Product Name</label>
	            <input type="text" class="form-control" id="productname" name="productname" value="{{$user->product_name}}" readonly>
	          </div>
	        </div>
         	<div class="col-sm-12">
	          <div class="form-group">
	            <label for="productdescription">Product Description</label>
	            <textarea class="form-control" id="productdescription" rows="5" readonly>{{$user->product_description}}</textarea>
	          </div>
	        </div>
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label for="bankname">Bank Name</label>
	            <input type="text" class="form-control" id="bankname" name="bankname" value="{{$user->bank_name}}" placeholder="Enter Bank Name" >
	          </div>
	        </div>
					<div class="col-sm-6">
	          <div class="form-group">
	            <label for="iban">Account/IBAN Number</label>
	            <input type="text" class="form-control" id="iban" name="iban" value="{{$user->iban_number}}" placeholder="Enter Account/IBAN Number">
	          </div>
	        </div>
	        <div class="col-sm-6">
	          <div class="form-group">
	            <label for="profile_img">Profile Image</label>
	            <input type="file" class="form-control" id="profile_img" name="profile_img">
	          </div>
	        </div>
          </div>
          <button class="btn btn-primary" type="submit">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection