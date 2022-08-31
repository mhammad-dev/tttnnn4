@extends('admin.layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Members</a></li>
    <li class="breadcrumb-item active" aria-current="page">All Subscribed Members</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">All Subscribed Members</h6>
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
                <th>Scheme Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $row)
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
                <td>
                  @if($row->scheme_type == 1)
                  <button class="btn btn-primary">Individual</button>
                  @endif
                  @if($row->scheme_type == 2)
                  <button class="btn btn-warning text">Group</button>
                  @endif
                </td>
                <td>{{-- <a href="#productassign{{$row->ibm}}" data-toggle="modal" data-toggle="tooltip" data-placement="right" title="Products Assigning"><i class="link-icon" data-feather="edit"></i></a>&nbsp; &nbsp; --}}
                  <a href="#scheme_type_assign{{$row->ibm}}" data-toggle="modal"><i class="link-icon" data-feather="type" data-toggle="tooltip" data-placement="right" title="Scheme Assigning"></i></a>&nbsp; &nbsp;
                  <a href="#bb_assign{{$row->ibm}}" data-toggle="modal"><i class="link-icon" data-feather="feather" data-toggle="tooltip" data-placement="right" title="BB Assigning"></i></a>&nbsp; &nbsp;
                  <a href="#user_details{{$row->ibm}}" data-toggle="modal" onclick="user_dn_dt('{{$row->ibm}}')" data-toggle="tooltip" data-placement="right" title="User Details"><i class="link-icon" data-feather="eye"></i></a>&nbsp; &nbsp;
                 <a href="#user_direct_invitation{{$row->ibm}}" data-toggle="modal" onclick="user_dn_dt('{{$row->ibm}}')"><i class="link-icon" data-feather="users" data-toggle="tooltip" data-placement="right" title="Direct Invitations"></i></a>&nbsp; &nbsp;
                 <a href="#member_transactions{{$row->ibm}}" data-toggle="modal" onclick="user_mem_trans('{{$row->ibm}}')"><i class="link-icon" data-feather="credit-card" data-toggle="tooltip" data-placement="right" title="Transactions"></i></a>&nbsp;&nbsp;
                 <a href="#member_commissions{{$row->ibm}}" data-toggle="modal" onclick="user_mem_coms('{{$row->ibm}}')"><i class="link-icon" data-feather="dollar-sign" data-toggle="tooltip" data-placement="right" title="Commissions"></i></a>&nbsp;&nbsp;
                 <a href="#products_list{{$row->ibm}}" data-toggle="modal" onclick="user_products_list('{{$row->ibm}}')" data-toggle="tooltip" data-placement="right" title="Products List"><i class="link-icon" data-feather="list"></i></a>&nbsp;&nbsp;
                 <a href="/admin/member/rewards/{{$row->ibm}}/{{$row->name}}" target="_blank" data-toggle="tooltip" data-placement="right" title="Member Rewards"><i class="link-icon" data-feather="gift"></i></a>
                  {{-- @include('admin.modal.product') --}}
                  @include('admin.modal.scheme_assign')
                  @include('admin.modal.bb_assign')
                  @include('admin.modal.user_details')
                  @include('admin.modal.user_direct_invitation')
                  @include('admin.modal.member_transactions')
                  @include('admin.modal.commission')
                  @include('admin.modal.product_lists')
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
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
{{--   <script src="{{ asset('assets/js/select2.js') }}"></script> --}}

  <script type="text/javascript">
/*
  $(document).ready(function(){
    var maxField = 50; //Input fields increment limitation
    var addButton = $('#add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '  <div class="product_inputs_div mt-2"><select name="product_name[]" class="form-control col-md-6 d-inline-block" required>' + myOptions + '</select>&nbsp;<input type="text" name="policy_number[]" value="" class="form-control col-md-4 d-inline-block" placeholder="Policy Number" required="" /><a href="javascript:void(0);" class="remove_button btn btn-danger col-md-2" style="padding:8px;margin-left: 8px !important;">Remove</a></div></div>';
     //New input field html 
     var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});*/
 
/*  function product_ajax(id,ibm){
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
  }*/

  function scheme_assign_ajax(id,ibm){
    $.ajax({  
        url: "/admin/scheme_assign",
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), '_method': 'patch'},
        data: $('#'+id).serialize(),
        type:'json',

    success:function(response){

        if(response.success){
          $("#scheme_assign_msg_err"+ibm).prop('hidden' , !this.checked);
          $("#scheme_assign_msg"+ibm+ " > p").text(response.success);
          $("#scheme_assign_msg"+ibm).removeAttr('hidden');  
        }
        else{
          $("#scheme_assign_msg"+ibm).prop('hidden', !this.checked);
          $("#scheme_assign_msg_err"+ibm+ " > p").text(response.error);
          $("#scheme_assign_msg_err"+ibm).removeAttr('hidden');
        }
        
              
    },
    
    });    
  }

  function bb_assign_ajax(id,ibm){
    $.ajax({  
        url: "/admin/bb_assign",
        method: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), '_method': 'patch'},
        data: $('#'+id).serialize(),
        type:'json',

    success:function(response){

        if(response.success){
    
          $("#bb_assign_msg_err"+ibm).prop('hidden' , !this.checked);
          $("#bb_assign_msg"+ibm+ " > p").text(response.success);
          $("#bb_assign_msg"+ibm).removeAttr('hidden');  
        }
        else{
    
          $("#bb_assign_msg"+ibm).prop('hidden', !this.checked);
          $("#bb_assign_msg_err"+ibm+ " > p").text(response.error);
          $("#bb_assign_msg_err"+ibm).removeAttr('hidden');
        }
        
              
    },
    
    });    
  }

   function user_details(ibm){
     $('#user_details_table'+ibm).DataTable();
  }
  
  function user_dn_dt(ibm){
    // $(document).ready( function () {
     $('#user_direct_invitation_table'+ibm).DataTable();
    // });
  }

  function user_mem_trans(ibm){
    $('#user_member_transactions_table'+ibm).DataTable();
  }

  function user_mem_coms(ibm){
    $('#user_member_commissions_table'+ibm).DataTable();
  }

  function showDiv(id1, id2,element)
  {
    document.getElementById(id1).style.display = element.value == 1 ? 'block' : 'none';
    document.getElementById(id2).style.display = element.value == 1 ? 'block' : 'none';
  }

  function user_products_list(ibm){
    $('#user_products_list_table'+ibm).DataTable();
  }

  </script>
@endpush