@extends('admin.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Members</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Members</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">My Members</h6>
        <div class="table-responsive mt-3">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Level</th>
                <th>IBM</th>
                <th>Names</th>
                <th>Email</th>
                <th>Introduced By</th>
                <th>Passed up</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($data as $row)
              <tr>
                <td>{{$row->level}}</td>
                <td>{{$row->ibm}}</td>
                <td>{{$row->name}}</td>
                <td>{{$row->email}}</td>
                @if($row->refer_ibm != NULL)
                <td>{{$row->refer_ibm}}</td>
                @else
                <td>Root</td>
                @endif
                <td>{{$row->passed_up_to}}</td>
                <td><a href="#productassign{{$row->ibm}}" data-toggle="modal"><i class="link-icon" data-feather="edit"></i></a>&nbsp; &nbsp;
                 <a href="#user_direct_invitation{{$row->ibm}}" data-toggle="modal" onclick="user_dn_dt('{{$row->ibm}}')"><i class="link-icon" data-feather="users"></i></a>
                  @include('admin.modal.product')
                @include('admin.modal.user_direct_invitation')
               </td>

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

  <script type="text/javascript">
  function product_ajax(id,ibm){
    $.ajax({  
        url: "/admin/productassign",
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), '_method': 'patch'},
        data: $('#'+id).serialize(),
        type:'json',

    success:function(response){
        if(response.success){
          $("#product_assign_msg_err"+ibm).prop('hidden' , !this.checked);
          $("#product_assign_msg"+ibm+ " > p").text(response.success);
          $("#product_assign_msg"+ibm).removeAttr('hidden');  
        }
        else{
          $("#product_assign_msg"+ibm).prop('hidden', !this.checked);
          $("#product_assign_msg_err"+ibm+ " > p").text(response.error);
          $("#product_assign_msg_err"+ibm).removeAttr('hidden');
        }
        
              
    },
    
    });    
  }

  function user_dn_dt(ibm){
    // $(document).ready( function () {
     $('#user_direct_invitation_table'+ibm).DataTable();
    // });
  }
 
 
  </script>
@endpush