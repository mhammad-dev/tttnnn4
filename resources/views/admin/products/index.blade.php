@extends('admin.layout.master')
@push('plugin-styles')

<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />

@endpush

@push('style')
  
@endpush

@section('content')
<div class="row">

    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="products"></i>&nbsp;&nbsp;All Products</h5>
    @can('product-create')
    <a href="{{ route('products.create') }}" class="btn btn-primary float-right mt-1"  style="border-radius: 20px; margin-top: ;">Create Product</a>
    @endcan

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
    @endif
    <div class="table-responsive">
          <table id="producttable" class="table">
            <thead>
              <tr>
                <th>S#</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th width="240">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $product)
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_description }}</td>
                    <td>
                      @can('product-list')
                       <a class="btn btn-sm btn-primary" href="{{ route('products.show',$product->id) }}">Show</a>
                       @endcan
                       @can('product-edit')
                       <a class="ml-2 btn btn-sm btn-secondary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                       @endcan
                       @can('product-edit')
                        {!! Form::open(['method' => 'DELETE','route' => ['products.destroy', $product->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'ml-2 btn btn-sm btn-danger']) !!}
                       @endcan
                        {!! Form::close() !!}
                    </td>
                  </tr>
                @endforeach

              
            </tbody>
          </table>
        </div>

  </div>
</div>

@endsection

@push('plugin-scripts')
 
 <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>

@endpush
@push('custom-scripts')
  

 <script type="text/javascript">
   $(document).ready( function () {
    $('#producttable').DataTable();
} );
 </script>

 
@endpush