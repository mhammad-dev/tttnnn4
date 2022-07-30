@extends('admin.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Rewards</a></li>
    <li class="breadcrumb-item active" aria-current="page">CareCover Rewards</li>
  </ol>
</nav>
<div class="row mt-4" style="width:200px">
  <div class="col-md-12">
    <h4 class="text-capitalize bg-primary text-white text-center py-1">{{ request()->route('name') }}</h4>
  </div>
</div>
<div class="row">
	<div class="col-md-12">
    <div id="accordion" class="mt-4">
      @foreach($total_comm as $level)
       <div class="card">
          <div class="card-header rewards-card-header" id="heading{{$level->level}}">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed rewards-title-btn" data-toggle="collapse" data-target="#collapse{{$level->level}}" aria-expanded="false" aria-controls="collapse{{$level->level}}">
                Level {{$level->level}} - {{$level->commission}} r
              </button>
            </h5>
          </div>
          <div id="collapse{{$level->level}}" class="collapse" aria-labelledby="heading{{$level->level}}" data-parent="#accordion">
            <div class="card-body">
              <table class="table" id="level{{$level->level}}">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ibm</th>
                    <th>Member Name</th>
                    <th>Email Address</th>
                    <th>Direct Referral Sponsor</th>
                    <th>Product Type</th>
                    <th>Commission</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $index = 1
                  @endphp
                  @foreach($data as $key => $row)
                  @if($level->level == $row->level)
                  <tr>
                    <td>{{$index++}}</td>
                    <td>{{$row->ibm}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->email}}</td>
                    <td>{{$row->refer_ibm}}</td>
                    <td>{{$row->product_name}}</td>
                    <td>{{$row->commission_paid}}</td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    @endforeach
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
<script type="text/javascript">
   $(document).ready( function () {
    var levels = {{$level}};
    for(var i=1 ; i<= levels ; i++){
      $('#level'+i).DataTable();
    }
     
    });
</script>
@endpush