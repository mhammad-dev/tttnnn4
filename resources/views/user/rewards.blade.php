@extends('user.layout.master')
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

<div class="row">
	<div class="col-md-12">
    <div id="accordion" class="mt-4">
      @for($i=1 ; $i<=$level ; $i++)
       <div class="card">
          <div class="card-header rewards-card-header" id="heading{{$i}}">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed rewards-title-btn" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                Level {{$i}}
              </button>
            </h5>
          </div>
          <div id="collapse{{$i}}" class="collapse" aria-labelledby="heading{{$i}}" data-parent="#accordion">
            <div class="card-body">
              <table class="table" id="level{{$i}}">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Parent</th>
                    <th>Child</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $index = 1
                  @endphp
                  @foreach($data as $key => $row)
                  @if($i == $row->level)
                  <tr>
                    <th>{{$index++}}</th>
                    <td>{{$row->parent}}</td>
                    <td>{{$row->child}}</td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    @endfor
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