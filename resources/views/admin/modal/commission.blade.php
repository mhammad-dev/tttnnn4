<div class="modal fade" id="member_commissions{{$row->ibm}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Commissions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive mt-3">
          <table id="user_member_commissions_table{{$row->ibm}}" class="table table-hover text-center">
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
            <tbody>
               @foreach($commissions as $key => $commission)
               @if($commission->sponsor == $row->ibm)
              <tr>
               <td>{{++$key}}</td>
               <td>{{$commission->referral}}</td>
               <td>{{$commission->level}}</td>
               <td>{{$commission->risk_premium_paid}}</td>
               <td>{{$commission->commission_paid}}</td>
               <td>{{$commission->commission_paid_percent}}</td>
               <td>{{date('d F Y', strtotime($commission->created_at))}}</td>
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


