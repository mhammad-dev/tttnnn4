@extends('admin.layout.master')


@section('content')
<div class="row">
    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="lock"></i>&nbsp;&nbsp;Create Role</h5>

    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There are some problems.<br><br>
        <ul class="list-unstyled">
           @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
           @endforeach
        </ul>
      </div>
    @endif


{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label>Name:</label>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <h5>Permissions:</h5>
            <br>
            @foreach($permission as $value)

                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
    </div>
    <div class="form-group col-md-4">
                 
                  <button type="submit" class="btn btn-primary">
                    {{ __('Create Role') }}
                  </button>
                
                </div>
    </div>
{!! Form::close() !!}

</div></div>

@endsection