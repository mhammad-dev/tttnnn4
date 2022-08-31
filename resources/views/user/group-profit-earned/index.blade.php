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
    <li class="breadcrumb-item"><a href="#">Profit Earned</a></li>
    <li class="breadcrumb-item active" aria-current="page">Group Profit Earned</li>
  </ol>
</nav> 
<div class="row d-flex mb-3 mt-4">
  <div class="col-md-12 d-flex justify-content-around">
    <div class="card info-box col-md-3">
      <span class="info-box-icon"><i class="link-icon" data-feather="package"></i></span>
      <span class="info-box-heading">Total Products</span>
      <span class="info-box-num" id="total_products">0</span>
    </div>
    <div class="card info-box col-md-3">
      <span class="info-box-icon"><i class="link-icon" data-feather="gift"></i></span>
      <span class="info-box-heading">Total Premium</span>
      <span class="info-box-num" id="total_premium">0</span>
    </div>
    <div class="card info-box col-md-3">
    <span class="info-box-icon"><i class="link-icon" data-feather="clipboard"></i></span>
     <span class="info-box-heading">Profit Earned</span>
      <span class="info-box-num" id="total_profit_earned">0</span>
    </div>
  </div>
</div>

<div class="row ">
  <div class="col-md-12 mb-4">
  <div class="filter-navbar col-md-12 bg-white shadow-sm">
    <button class="accordion"><h5><i class="btn-icon-prepend" data-feather="filter"></i>&nbsp;Filter Profit
      <i id="chevdown" class="chevron-down float-right btn-icon-prepend" data-feather="chevron-down"></i><i id="chevup" class="chevron-up float-right btn-icon-prepend" data-feather="chevron-up"></i></h5></button>
<div class="panel">
  <form method="GET"  class="mt-3 ml-2" id="group_profit_earned_filter">
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
        <h6 class="card-title">Group Profit Earned</h6>
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
            <tbody id="tb_group_profit_earned_body">
              
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
     fetch_group_profit_earned();
      $('.panel').show();

    function fetch_group_profit_earned(){
      $.ajax({
        url:"{{ route('user.group_profit_earned.search') }}",
        method:'POST',
        data:$('#group_profit_earned_filter').serialize(),
        dataType: 'json',
        success:function(data)
        {

          $('#tb_group_profit_earned_body').html(data.group_profit_earned_data);
           $('#total_products').html(data.total_products);
          $('#total_premium').html(data.total_premium);
          $('#total_profit_earned').html(data.total_profit_earned);
         
        }
      })
    }

    $(document).on('click', '#search', function(){

    fetch_group_profit_earned();
     $(".panel").hide();
    });
  })



</script>
@endpush