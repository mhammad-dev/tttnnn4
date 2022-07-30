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

  #total_transactions{
    font-weight:500; 
    border-radius: 20px;
    padding: 10px 20px;" 
  }

  #trans_value{
    font-size: 20px;
  }
  </style>
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Transactions</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Transactions</li>
  </ol>
</nav>

{{-- <div class="row d-flex mb-3 mt-4">
  <div class="col-md-12 d-flex justify-content-around">
    <div class="card info-box col-md-3">
      <span class="info-box-icon"><i class="link-icon" data-feather="gift"></i></span>
      <span class="info-box-heading">Premium Paid</span>
      <span class="info-box-num">{{$risk_amt_sum}}</span>
    </div>
    <div class="card info-box col-md-3">
    <span class="info-box-icon"><i class="link-icon" data-feather="clipboard"></i></span>
     <span class="info-box-heading">Fee Paid</span>
      <span class="info-box-num">{{$comm_with_vat_sum}}</span>
    </div>
    <div class="card info-box col-md-3">
      <span class="info-box-icon"><i class="link-icon" data-feather="package"></i></span>
      <span class="info-box-heading">Total Paid</span>
      <span class="info-box-num">{{$risk_amt_sum + $comm_with_vat_sum}}</span>
    </div>
  </div>
</div> --}}
<div class="row">
  <div class="col-md-12 mt-1 mb-4">
    <div class="float-right bg-primary" id="total_transactions">
      <h4 class="d-inline text-white">Total Transactions:</h4>
      <span id="trans_value" class="text-white">&nbsp;&nbsp;0</span>

    </div>
    </div>
</div>
<div class="row ">
  <div class="col-md-12 mb-4">
  <div class="filter-navbar col-md-12 bg-white shadow-sm">
    <button class="accordion"><h5><i class="btn-icon-prepend" data-feather="filter"></i>&nbsp;Filter Transactions
      <i id="chevdown" class="chevron-down float-right btn-icon-prepend" data-feather="chevron-down"></i><i id="chevup" class="chevron-up float-right btn-icon-prepend" data-feather="chevron-up"></i></h5></button>
<div class="panel">
  <form class="mt-3 ml-2" id="transaction_filter">
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
      {{-- <button id="clear" class="btn btn-sm btn-outline-dark" type="button" onclick="clearFilter();"><i class="btn-icon-prepend" data-feather="download" style="width:16px; height: 16px;"></i>&nbsp;DOWNLOAD</button> --}}
      
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
        <h6 class="card-title">My Transactions</h6>
        <div class="table-responsive mt-3">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                  <th>Transaction Date</th>
                  <th>Transaction ID</th>
                  <th>Product Type</th>
                  <th>Policy Number</th>
                  <th>Premium</th>
                  <th>Status</th>
              </tr>
                            
                          
            </thead>
            <tbody id="tb_transaction_body">
             {{--  @foreach($transactions as $row)
              <tr>
               <td>{{date('d F Y', strtotime($row->created_at))}}</td>
               <td>{{substr(str_repeat(0, 7).$row->id, - 7)}}</td>
               <td>{{$row->product_name}}</td>
               <td>{{$row->policy_no}}</td>
               <td>{{$row->risk_amt_ex_vat}}</td>
               <td>{{$row->status}}</td>  
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
     fetch_transaction();
      $('.panel').show();

    function fetch_transaction(){
      $.ajax({
        url:"{{ route('user.transactions.search') }}",
        method:'POST',
        data:$('#transaction_filter').serialize(),
        dataType: 'json',
        success:function(data)
        {

          $('#tb_transaction_body').html(data.transaction_data);
          $('#trans_value').html(data.total_transactions);
          // $('#total_comm').html(data.total_comm);
          // $('#total_payout').html(data.total_comm);
        }
      })
    }

    $(document).on('click', '#search', function(){

    fetch_transaction();
     $(".panel").hide();
    });
  })

</script>
@endpush