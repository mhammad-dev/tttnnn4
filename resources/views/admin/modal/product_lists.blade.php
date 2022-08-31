<div class="modal fade" id="products_list{{$row->ibm}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Product List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive mt-3">
          <table id="user_products_list_table{{$row->ibm}}" class="table table-hover text-center">
             <thead>
              <tr>
                  <th>Product Name</th>
                  <th>Product Description</th>
                  <th>Policy Number</th>
                  @if(Route::currentRouteName() == "admin_subscribed_members")
                  <th>Business Builder</th>
                  @endif                  
              </tr>
                            
                          
            </thead>
            <tbody>
              @foreach($usersProductsDetail as $key => $singleUserProductsDetail)
              @if($singleUserProductsDetail->user_ibm == $row->ibm)
              <tr>
               <td>{{$singleUserProductsDetail->product_name}}</td>
               <td>{{$singleUserProductsDetail->product_description}}</td>
               <td>{{$singleUserProductsDetail->policy_no}}</td>
               @if(Route::currentRouteName() == "admin_subscribed_members")
               <td>{{$singleUserProductsDetail->name}}</td>
               @endif
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


