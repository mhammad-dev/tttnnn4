@extends('admin.layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Transactions</div>
                <div class="card-body">
                    <form method="POST" id="addtransaction">
                        @csrf
                         <div class="form-group">
                            <label for="users-select">Users</label>
                            <select class="js-example-basic-single w-100" id="users-select" name="user_ibm" required>
                                <option value="" selected disabled>Select User</option>
                                @foreach($users as $user)
                                    <option value="{{$user->ibm}}">{{$user->identification_number}}-{{$user->ibm}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" placeholder="description" required> 
                          </div>
                          <div class="form-group">
                            <label for="risk_amt_ex_vat">Risk Amount <span class="text-muted">(ex vat)</span></label>
                            <input type="text" class="form-control" name="risk_amt_ex_vat" placeholder="risk_amt_ex_vat" required> 
                          </div>
                          <div class="form-group">
                            <label for="comm_fee_ex_vat">Commission Fee <span class="text-muted">(ex vat)</span></label>
                            <input type="text" class="form-control" name="comm_fee_ex_vat" placeholder="comm_fee_ex_vat"> 
                          </div>
                          <div class="form-group">
                            <label for="comm_fee_vat">Commission Fee <span class="text-muted">(with vat)</span></label>
                            <input type="text" class="form-control" name="comm_fee_vat" placeholder="comm_fee_vat"> 
                          </div>
                          <div class="form-group">
                            <label for="balance_brought_forward_ex_vat">Balance Brought Forward<span class="text-muted">(ex vat)</span></label>
                            <input type="text" class="form-control" name="balance_brought_forward_ex_vat" placeholder="balance_brought_forward_ex_vat"> 
                          </div>
                          <div class="form-group">
                            <label for="balance_carried_forward_ex_vat">Balance Carried Forwar<span class="text-muted">(ex vat)</span></label>
                            <input type="text" class="form-control" name="balance_carried_forward_ex_vat" placeholder="balance_carried_forward_ex_vat"> 
                          </div>
                          <div class="form-group">
                            <label for="total_owed_ex_vat">Total Owed<span class="text-muted">(ex vat)</span></label>
                            <input type="text" class="form-control" name="total_owed_ex_vat" placeholder="total_owed_ex_vat"> 
                          </div>
                          <div class="form-group">
                            <label for="total_paid_ex_vat">Total Paid<span class="text-muted">(ex vat)</span></label>
                            <input type="text" class="form-control" name="total_paid_ex_vat" placeholder="total_paid_ex_vat"> 
                          </div>
                        
                      {{--  <a href="#" onclick="addTransaction();" class="btn btn-primary">Add</a> --}}
                      <button class="btn btn-primary">
                          Add
                      </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script>
$("#addtransaction").on('submit', function(e) {
     e.preventDefault();
    var formdata = $(this).serialize();
            $.ajax({
               type:'POST',
               url:'/admin/addTransaction',
                data: formdata,
                dataType: "json",
               success:function(data) {
                alert(data['success']);
                    $("#addtransaction")[0].reset();
               }
            });
   
});

</script>
@endpush