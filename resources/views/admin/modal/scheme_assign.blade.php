<div class="modal fade" id="scheme_type_assign{{$row->ibm}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Scheme Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div hidden id="scheme_assign_msg{{$row->ibm}}" class="alert alert-success">
          <p></p>
        </div>
        <div hidden id="scheme_assign_msg_err{{$row->ibm}}" class="alert alert-danger">
          <p></p>
        </div>

        <form id="scheme_assign_form{{$row->ibm}}">
          {{ csrf_field() }}

          <input type="text" name="hiddenibm" value="{{$row->ibm}}"hidden>
          <div class="form-group">
            <label for="scheme_type" class="col-form-label">Scheme type:<span class="aesterik">*</span></label>
            <select name="scheme_type" class="form-control"required>
              @if($row->scheme_type == NULL)
               <option value="" disabled selected >Select Scheme Type</option>
               <option value="1">Individual</option>
               <option value="2">Group Type</option>
              @elseif($row->scheme_type == '1')
               <option value="1" selected>Individual</option>
               <option value="2">Group Type</option>
              @elseif($row->scheme_type =='2')
                <option value="1">Individual</option>
               <option value="2" selected>Group Type</option>
              @endif
    
            </select>
          </div>       
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="#" id="scheme_assign_btn{{$row->ibm}}" onclick="scheme_assign_ajax('scheme_assign_form{{$row->ibm}}','{{$row->ibm}}');" class="btn btn-primary">Update</a>
      </div>
    </div>
  </div>
</div>