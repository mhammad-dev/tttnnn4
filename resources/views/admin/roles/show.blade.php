@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="edit"></i>&nbsp;&nbsp;Role Details</h5>
    <h5 class="float-right"><a class="btn btn-sm btn-secondary text-white" href="{{ route('roles.index') }}">Go Back</a></h5>
    
    <br>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:&nbsp;</strong>
            {{ $role->name }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <h5 class="mb-2">Permissions:</h5>
            @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                    <label>{{ $v->name }}</label><br>
                @endforeach
            @endif
        </div>
    </div>
</div>
</div></div>
@endsection