@extends('admin.layout.master')
@push('plugin-styles')

<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />

@endpush

@push('style')
  
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="lock"></i>&nbsp;&nbsp;All Roles</h5>
    @can('role-create')
    <a href="{{ route('roles.create') }}" class="btn btn-primary float-right mt-1"  style="border-radius: 20px; margin-top: ;">Create Role</a>
    @endcan

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="table-responsive">
          <table id="rolestable" class="table">
            <thead>
              <tr>
                <th>S#</th>
                <th>Name</th>
                <th width="240">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('roles.show',$role->id) }}">Show</a>
                            @can('role-edit')
                                <a class="ml-2 btn btn-sm btn-secondary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                            @endcan
                            @can('role-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'ml-2 btn btn-sm btn-danger']) !!}
                                {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                @endforeach
              
            </tbody>
          </table>
</div>
</div></div>
 





@endsection


@push('plugin-scripts')
 
 <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>

@endpush
@push('custom-scripts')
  

 <script type="text/javascript">
   $(document).ready( function () {
    $('#rolestable').DataTable();
} );
 </script>

 
@endpush