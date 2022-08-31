@extends('user.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Products</a></li>
    <li class="breadcrumb-item active" aria-current="page">Products List</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Products List</h6>
        <div class="table-responsive mt-3">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Policy No</th>
                <th>Business Builder</th>
                <th>Group Name</th>
              </tr>
            </thead>
            <tbody>
              @foreach($usersProductsDetail as $key => $singleUserProduct)
              <tr>
                <td>{{++$key}}</td>
                <td>{{$singleUserProduct->product_name}}</td>
                <td>{{$singleUserProduct->product_description}}</td>
                <td>{{$singleUserProduct->policy_no}}</td>
                <td>{{$singleUserProduct->business_builder_name}}</td>
                <td>{{$singleUserProduct->group_name ?: "----"}}</td>
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