@extends('user.layout.master')
@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Referrals</a></li>
    <li class="breadcrumb-item active" aria-current="page">Referral Link</li>
  </ol>
</nav>
<div class="row bg-white" id="row-refferal">

    <div class="col-md-12 bg-primary text-white shadow-sm px-4 py-4">
    	<h5><i class="btn-icon-prepend" data-feather="zap"></i>&nbsp;&nbsp;Referral Link</h5>
    	<span class="ml-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In order to sign up people in your downline, they need to register from this link</span>
    </div>

    <div class="col-md-12" id="referral_link_div">
    	<input type="text" class="form-control col-md-12" name="referral_link" id="referral_link" value="{{URL::to('/')}}/referral/?ref={{Auth::user()->ibm}}" readonly>
       <button id="refferal_btn" class="btn btn-md btn-dark offset-5 col-md-2 mt-4" onclick="copylink()">Copy Link</button>
    </div>



</div>
@endsection


@push('custom-scripts')
  

 <script type="text/javascript">
   function copylink() {
  
  var copyText = document.getElementById("referral_link");
  copyText.select();
  navigator.clipboard.writeText(copyText.value);
  toastr.options =
  {
  	"closeButton" : true,
  }
  toastr.success("Referral Link Copied");
}
 </script>

 
@endpush