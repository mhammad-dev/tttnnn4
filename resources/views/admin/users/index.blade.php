@extends('admin.layout.master')
@push('plugin-styles')

<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />

@endpush

@push('style')
  
@endpush

@section('content')
<div class="row">

    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="users"></i>&nbsp;&nbsp;All Users</h5>
    <a href="{{ route('users.create') }}" class="btn btn-primary float-right mt-1"  style="border-radius: 20px; margin-top: ;">Create User</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
          <p>{{ $message }}</p>
        </div>
    @endif
    <div class="table-responsive">
          <table id="usertable" class="table">
            <thead>
              <tr>
                <th>S#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="240">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $user)
                @foreach($user->getRoleNames() as $v)
                @if(!empty($v))
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                      {{-- @if(!empty($user->getRoleNames())) --}}
                       {{--  @foreach($user->getRoleNames() as $v) --}}
                           <label class="badge badge-success">{{ $v }}</label>
                       {{--  @endforeach
                      @endif --}}
                    </td>
                    <td>
                       <a class="btn btn-sm btn-primary" href="{{ route('users.show',$user->id) }}">Show</a>
                       <a class="ml-2 btn btn-sm btn-secondary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'ml-2 btn btn-sm btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                  </tr>
                  @endif
                @endforeach
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
    $('#usertable').DataTable();
} );
 </script>

 
@endpush