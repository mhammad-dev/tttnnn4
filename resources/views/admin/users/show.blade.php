@extends('admin.layout.master')


@section('content')
<div class="row">
    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="user-plus"></i>&nbsp;&nbsp;User Detailed</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <td>{{ $v }}</td>
                @endforeach
                @endif

                
            </tr>
        </tbody>
    </table>
    
</div>
</div>



@endsection