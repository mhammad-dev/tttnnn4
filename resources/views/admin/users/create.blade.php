@extends('admin.layout.master')


@section('content')
<div class="row">
    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="user-plus"></i>&nbsp;&nbsp;Create User</h5>

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
     {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
                     
                <div class="form-group col-md-4">
                    <label>Name:</label>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
                <div class="form-group col-md-4">
                  <label>Email:</label>
                  {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
                <div class="form-group col-md-4">
                  <label>Password:</label>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>

                <div class="form-group col-md-4">
                  <label>Confirm Password:</label>
                  {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>

                 <div class="form-group col-md-4">
                    <label>Role:</label>
                     {!! Form::select('roles[]', $roles,[], array('class' => 'form-control' ,null, 'placeholder' => 'Select Role')) !!}
                </div>

                <div class="form-group col-md-4">
                 
                  <button type="submit" class="btn btn-primary">
                    {{ __('Create User') }}
                  </button>
                
                </div>
       
                
    {!! Form::close() !!}

</div></div>
@endsection

