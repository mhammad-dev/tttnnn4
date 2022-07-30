@extends('user.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <style type="text/css">
   /* Style the buttons that are used to open and close the accordion panel */
  .accordion {
    background-color: #fff;
    cursor: pointer;
    padding: 13px;
    height: 50px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
     transition: all 0.3s ease-in-out 0s, visibility 0s linear 0.3s, z-index 0s linear 0.01s;

    
}

  /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
   .accordion:hover {
    color:#007BFF ;
  }

  /* Style the accordion panel. Note: hidden by default */
  .panel {
    padding: 0 18px;
    background-color: white;
    display: none;
   
  }

  .form-group.col-md-3.float-right.btn-div {
    margin-left: 15px;
    margin-top: 31px;
  }

  #chevdown{
    display: none;
  }

  #chevup{
    display: block;
  }

  </style>
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Commissions</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Commissions</li>
  </ol>
</nav> 
<div class="row d-flex mb-3 mt-4">
  <div class="col-md-12 d-flex justify-content-around">
    <div class="card info-box col-md-3">
      <span class="info-box-icon"><i class="link-icon" data-feather="gift"></i></span>
      <span class="info-box-heading">Total Premium Paid</span>
      <span class="info-box-num" id="risk_amt_sum">0</span>
    </div>
    <div class="card info-box col-md-3">
    <span class="info-box-icon"><i class="link-icon" data-feather="clipboard"></i></span>
     <span class="info-box-heading">Commission Earned</span>
      <span class="info-box-num" id="total_comm">0</span>
    </div>
    <div class="card info-box col-md-3">
      <span class="info-box-icon"><i class="link-icon" data-feather="package"></i></span>
      <span class="info-box-heading">Total Payout</span>
      <span class="info-box-num" id="total_payout">0</span>
    </div>
  </div>
</div>

<div class="row ">
 {{--  <div class="col-md-12 mb-3 mt-2">
     <h5 class="ml-3"><i class="link-icon" data-feather="filter"></i>Filter</h5>
     <form method="POST" id="commission-form" class="form-inline col-md-12 mt-4">
          @csrf
          
          <div class="col-md-3 form-group">  
            <label>Start Date</label>
            <input type='date' class="form-control" id='comm_start_date' name="comm_start_date" /> &nbsp;&nbsp;&nbsp;
          </div>
          <div class="col-md-3 form-group">  
            <label>End Date</label>
            <input type='date' class="form-control" id='comm_end_date' name="comm_end_date" /> &nbsp;&nbsp;&nbsp;
          </div>
          
          <div class="col-md-4 form-group mt-4">
            <a href="#" onclick="fetch_commission();" class="btn btn-primary">Search</a>
            <span>&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;</span>
            <a href="#" onclick="fetch_commission();" class="btn btn-primary">Download</a>
          </div>
                
            
          
        </form>
  </div> --}}
  <div class="col-md-12 mb-4">
  <div class="filter-navbar col-md-12 bg-white shadow-sm">
    <button class="accordion"><h5><i class="btn-icon-prepend" data-feather="filter"></i>&nbsp;Filter Commission
      <i id="chevdown" class="chevron-down float-right btn-icon-prepend" data-feather="chevron-down"></i><i id="chevup" class="chevron-up float-right btn-icon-prepend" data-feather="chevron-up"></i></h5></button>
<div class="panel">
  <form method="GET" action="/downloadCommissions" class="mt-3 ml-2" id="commission_filter">
    @csrf
  <div class="form-row" style="margin-top: -10px;">

    <div class="form-group col-md-2">
      <label for="dates">From Date:</label><br>
      <input type="date" name="fromdate" id="fromdate" class="form-control">
    </div>

    <div class="form-group col-md-2">
      <label for="dates">To Date:</label><br>
      <input type="date" name="todate" id="todate" class="form-control">
    </div>

    <div class="form-group col-md-3 float-right btn-div">
      <button id="search" class="btn btn-sm btn-outline-primary" type="button"><i class="btn-icon-prepend" data-feather="search" style="width:16px; height: 16px;"></i>&nbsp;SEARCH</button>
      <button type="submit" id="download" class="btn btn-sm btn-outline-dark" type="button"><i class="btn-icon-prepend" data-feather="download" style="width:16px; height: 16px;"></i>&nbsp;DOWNLOAD</button>

      {{-- <a href="#" id="search" onclick="fetch_commission();" class="btn btn-outline-primary"><i class="btn-icon-prepend" data-feather="search" style="width:16px; height: 16px;"></i>&nbsp;Search</a>
      <span>&nbsp;&nbsp;&nbsp;OR&nbsp;&nbsp;&nbsp;</span> --}}
      {{-- <a href="/downloadCommissions"  class="btn btn-outline-dark"><i class="btn-icon-prepend" data-feather="download" style="width:16px; height: 16px;"></i>&nbsp;Download</a> --}}
      
    </div>
    </div>

</form>
</div>


    

  
  </div>
  </div>
  </div>




<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">               
      <div class="card-body">
        <h6 class="card-title">My Commissions</h6>
        <div class="table-responsive mt-3">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                  <th>#</th>
                  <th>Referral</th>
                  <th>Level</th>
                  <th>Risk Premium Paid</th>
                  <th>Commisssion Paid</th>
                   <th>
                    Commisssion Paid 
                    <span class="table-data-extra">(in %)</span>
                  </th>
                  <th>Date</th>
              </tr>
                            
                          
            </thead>
            <tbody id="tb_commisssion_body">
              {{-- @foreach($commissions as $key => $commission)
              <tr>
               <td>{{++$key}}</td>
               <td>{{$commission->referral}}</td>
               <td>{{$commission->level}}</td>
               <td>{{$commission->risk_premium_paid}}</td>
               <td>{{$commission->commission_paid}}</td>
               <td>{{$commission->commission_paid_percent}}</td>
              </tr> 
              @endforeach --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        /* Toggle between adding and removing the "active" class,
        to highlight the button that controls the panel */
        this.classList.toggle("active");
        var chev= document.getElementById("chevdown");
        var chevup= document.getElementById("chevup");
        /* Toggle between hiding and showing the active panel */
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
          chev.style.display = "none";
          chevup.style.display="block";

         
        } else {
          panel.style.display = "block";
           chev.style.display = "block";
          chevup.style.display = "none";

         
        }
      });
  }

  $(document).ready(function(){
     fetch_commission();
      $('.panel').show();

    function fetch_commission(){
      $.ajax({
        url:"{{ route('user.commissions.search') }}",
        method:'POST',
        data:$('#commission_filter').serialize(),
        dataType: 'json',
        success:function(data)
        {

          $('#tb_commisssion_body').html(data.commission_data);
          $('#risk_amt_sum').html(data.risk_amt_sum);
          $('#total_comm').html(data.total_comm);
          $('#total_payout').html(data.total_comm);
          /*$('#total_records').text(data.total_data);*/
        }
      })
    }

    $(document).on('click', '#search', function(){

    fetch_commission();
     $(".panel").hide();
    });
  })



</script>
@endpush