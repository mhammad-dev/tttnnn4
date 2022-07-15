@extends('user.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
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
      <span class="info-box-num">{{$risk_amt_sum}}</span>
    </div>
    <div class="card info-box col-md-3">
    <span class="info-box-icon"><i class="link-icon" data-feather="clipboard"></i></span>
     <span class="info-box-heading">Commission Earned</span>
      <span class="info-box-num">{{$total_comm}}</span>
    </div>
    <div class="card info-box col-md-3">
      <span class="info-box-icon"><i class="link-icon" data-feather="package"></i></span>
      <span class="info-box-heading">Total Payout</span>
      <span class="info-box-num">{{$total_comm}}</span>
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
              </tr>
                            
                          
            </thead>
            <tbody>
              @foreach($commissions as $key => $commission)
              <tr>
               <td>{{++$key}}</td>
               <td>{{$commission->referral}}</td>
               <td>{{$commission->level}}</td>
               <td>{{$commission->risk_premium_paid}}</td>
               <td>{{$commission->commission_paid}}</td>
               <td>{{$commission->commission_paid_percent}}</td>
              </tr> 
              @endforeach
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
@endpush