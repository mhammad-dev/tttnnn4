<div class="modal fade" id="productassign{{$row->ibm}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product Assign</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div hidden id="product_assign_msg{{$row->ibm}}" class="alert alert-success">
          <p></p>
        </div>
        <div hidden id="product_assign_msg_err{{$row->ibm}}" class="alert alert-danger">
          <p></p>
        </div>

        <form id="product_assign_form{{$row->ibm}}">
          {{ csrf_field() }}

          <input type="text" name="hiddenibm" value="{{$row->ibm}}"hidden>
          <div class="form-group">
            <label for="member_intention" class="col-form-label">Member Intentions:<span class="aesterik">*</span></label>
            <select name="member_intention" class="form-control" onchange="showDiv('product_name{{$row->ibm}}','identification_number{{$row->ibm}}', this)" required>
              @if($row->member_intention == NULL)
               <option value="" disabled selected >Select Member Intention</option>
               <option value="1">Buy product & advertise</option>
               <option value="2">Only advertise</option>
              @elseif($row->member_intention == '1')
               <option value="1" selected>Buy product & advertise</option>
               <option value="2">Only advertise</option>
              @elseif($row->member_intention =='2')
                <option value="1">Buy product & advertise</option>
               <option value="2" selected>Only advertise</option>
              @endif
    
            </select>
          </div>

          @if($row->member_intention == '2')
          <div class="form-group" id="product_name{{$row->ibm}}" style="display:none;">
          @else
          <div class="form-group" id="product_name{{$row->ibm}}" style="display:block;">
          @endif
            <label for="product" class="col-form-label">Product Name:<span class="aesterik">*</span></label>
            <select name="product" class="form-control" required>
              @if($row->product_id == NULL)
               <option value="" disabled selected >Select Product</option>
              @else
               <option value="{{$row->product_id}}">{{$row->product_name}}</option>
              @endif
              @foreach($products as $product )
                @if($row->product_id != $product->product_id)
                 <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                @endif
              @endforeach
            </select>
          </div>
          
          @if($row->member_intention == '2')
          <div class="form-group" id="identification_number{{$row->ibm}}" style="display:none;">
          @else
          <div class="form-group" id="identification_number{{$row->ibm}}" style="display:block;">
          @endif
            <label for="identification_number" class="col-form-label">Identification Number: <span class="aesterik">*</span></label>
            <input name="identification_number" type="text" class="form-control" placeholder="Identification Number" value="{{$row->identification_number}}" required />
          </div>
          <div class="form-group">
            <label for="provider_policy_number" class="col-form-label">Provider Policy Number:</label>
            <input name="provider_policy_number" type="text" class="form-control" placeholder="Provider Policy Number" value="{{$row->provider_policy_number}}" />
          </div>
          <div class="form-group">
            <label for="premium_amount" class="col-form-label">Premium Amount:</label>
            <input name="premium_amount" type="text" class="form-control" placeholder="Premium Amount" value="{{$row->premium_amount}}" required />
          </div>
          
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="#" id="product_assign_btn{{$row->ibm}}" onclick="product_ajax('product_assign_form{{$row->ibm}}','{{$row->ibm}}');" class="btn btn-primary">Update</a>
        {{-- <button type="button" class="btn btn-primary">Send message</button> --}}
      </div>
    </div>
  </div>
</div>