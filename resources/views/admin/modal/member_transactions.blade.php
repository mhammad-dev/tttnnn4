<div class="modal fade" id="member_transactions{{$row->ibm}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Member Transactions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive mt-3">
          <table id="user_member_transactions_table{{$row->ibm}}" class="table table-hover text-center">
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
            <tbody>
               @foreach($transactions as $transaction)
               @if($transaction->member_id == $row->id)
              <tr>
               <td>{{date('d F Y', strtotime($transaction->created_at))}}</td>
               <td>{{substr(str_repeat(0, 7).$transaction->id, - 7)}}</td>
               <td>{{$transaction->product_name}}</td>
               <td>{{$transaction->policy_no}}</td>
               <td>{{$transaction->risk_amt_ex_vat}}</td>
               <td>{{$transaction->status}}</td>  
              </tr> 
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
         
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>