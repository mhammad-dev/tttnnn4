<div class="modal fade" id="bb_assign{{$row->ibm}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Business Builder Assigning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div hidden id="bb_assign_msg{{$row->ibm}}" class="alert alert-success">
          <p></p>
        </div>
        <div hidden id="bb_assign_msg_err{{$row->ibm}}" class="alert alert-danger">
          <p></p>
        </div>

        <form id="bb_assign_form{{$row->ibm}}">
          {{ csrf_field() }}

          <input type="text" name="hiddenibm" value="{{$row->ibm}}"hidden>
          <div class="form-group">
            <label for="bb_selection" class="col-form-label">Business Builders:<span class="aesterik">*</span></label>
            <select name="bb_selection" class="form-control"required>
               <option value="" disabled selected >Select Business Builder</option>
              @foreach($admins as $admin)
              @if($row->business_builder_id == $admin->id)
                <option value="{{$admin->id}}" selected>{{$admin->name}}</option>
              @else
                <option value="{{$admin->id}}">{{$admin->name}}</option>
              @endif
              @endforeach
            </select>
          </div>       
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="#" id="bb_assign_btn{{$row->ibm}}" onclick="bb_assign_ajax('bb_assign_form{{$row->ibm}}','{{$row->ibm}}');" class="btn btn-primary">Assign</a>
      </div>
    </div>
  </div>
</div>