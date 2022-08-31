<div class="modal fade" id="user_details{{$row->ibm}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive mt-3">
          <table id="user_details_table{{$row->ibm}}" class="table table-hover text-center">
            <thead>
              <tr>
                <th>IBM#</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Whatsapp Number</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
               @foreach($users as $user)
               @if($user->ibm == $row->ibm)
                <tr>
                  <td>{{$user->ibm}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->surname}}</td>
                  <td>{{$user->whatsapp_number ?: "----"}}</td>
                  <td>{{$user->email}}</td>
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