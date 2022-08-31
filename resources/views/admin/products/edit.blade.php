@extends('admin.layout.master')


@section('content')
<div class="row">
    <div class="col-md-12 bg-white shadow-sm px-4 py-4">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="edit"></i>&nbsp;&nbsp;Edit Product</h5>
    <h5 class="float-right"><a class="btn btn-sm btn-secondary text-white" href="{{ route('products.index') }}">Go Back</a></h5>
    
    <br>

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

    {!! Form::model($product, ['method' => 'PATCH','route' => ['products.update', $product->id]]) !!}
                     
                <div class="form-group col-md-4">
                    <label>Product Name:</label>
                    {!! Form::text('product_name', null, array('placeholder' => 'Product Name','class' => 'form-control', 'required' => 'required')) !!}
                </div>
                <div class="form-group col-md-4">
                  <label>Product Description:</label>
                  {!! Form::textarea('product_description', null, array('placeholder' => 'Product Description','class' => 'form-control' , 'required' => 'required' , 'rows' => 3 )) !!}
                </div>
                <div class="form-group col-md-4">
                  <label>Administrator Name:</label>
                  {!! Form::text('administrator_name', null, array('placeholder' => 'Administrator Name','class' => 'form-control' , 'required' => 'required')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>Premium:</label>
                    {!! Form::number('premium', null, array('placeholder' => 'Premium','class' => 'form-control' , 'required' => 'required' , 'min'=>0 , 'step' =>'any')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>Cover Amount:</label>
                    {!! Form::number('cover_amount', null, array('placeholder' => 'Cover Amount','class' => 'form-control' , 'required' => 'required' , 'min'=>0 , 'step' =>'any')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>Administrator fee:</label>
                    {!! Form::number('administrator_fee', null, array('placeholder' => 'Administrator fee','class' => 'form-control' , 'required' => 'required' , 'min'=>0 , 'step' =>'any')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>Rewards Commission For Buyer %:</label>
                    {!! Form::number('rewards_commission_for_buyer', null, array('placeholder' => 'Rewards Commission For Buyer','class' => 'form-control' , 'required' => 'required' , 'min'=>0 , 'step' =>'any')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>Rewards Commission For Advertiser %:</label>
                    {!! Form::number('rewards_commission_for_advertiser', null, array('placeholder' => 'Rewards Commission For Advertiser','class' => 'form-control' , 'required' => 'required' , 'min'=>0 , 'step' =>'any')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>Admin Fee %:</label>
                    {!! Form::number('admin_fee', null, array('placeholder' => 'Admin Fee','class' => 'form-control' , 'required' => 'required' , 'min'=>0 , 'step' =>'any')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>BB Fee %:</label>
                    {!! Form::number('bb_fee', null, array('placeholder' => 'BB Fee','class' => 'form-control' , 'required' => 'required' , 'min'=>0 , 'step' =>'any')) !!}
                </div>
                <div class="form-group col-md-4">
                    <label>Groups :</label>
                     <select name="intermediary">
                       <option>Select Group</option>
                       @foreach($groups as $group)
                       @if($group->id  == $product->intermediary)
                       <option selected value="{{$group->id}}">{{$group->name}}</option>
                       @else
                       <option value="{{$group->id}}">{{$group->name}}</option>
                       @endif
                       @endforeach
                   </select>
                </div>
                <div class="form-group col-md-4">
                    <label>Group scheme Profit:</label>
                    {!! Form::text('group_scheme_profit', null, array('placeholder' => 'Group scheme Profit','class' => 'form-control' , 'readonly')) !!}

                </div>
                <div class="form-group col-md-4">
                 
                  <button type="submit" class="btn btn-primary">
                    {{ __('Update product') }}
                  </button>
                
                </div>
       
                
    {!! Form::close() !!}

</div>
</div>

@endsection