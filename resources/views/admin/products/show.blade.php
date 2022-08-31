@extends('admin.layout.master')


@section('content')
<div class="row">
    <div class="col-md-12 bg-white shadow-sm px-4 py-4" style="overflow-x: scroll;">
    <h5 class="mb-4 d-inline-block"><i class="btn-icon-prepend" data-feather="product-plus"></i>&nbsp;&nbsp;Product Details</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Premium</th>
                <th>Cover Amount</th>
                <th>Administrator Name</th>
                <th>Administrator Fee</th>
                <th>Rewards Commission For Buyer</th>
                <th>Rewards Commission For Advertiser</th>
                <th>Admin Fee</th>
                <th>BB Fee</th>
                <th>Group</th>
                <th>Group Scheme Profit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->product_description }}</td>
                <td>{{$product->premium}}</td>
                <td>{{$product->cover_amount}}</td>
                <td>{{$product->administrator_name}}</td>
                <td>{{$product->administrator_fee}}</td>
                <td>{{$product->rewards_commission_for_buyer}}</td>
                <td>{{$product->rewards_commission_for_advertiser}}</td>
                <td>{{$product->admin_fee}}</td>
                <td>{{$product->bb_fee}}</td>
                <td>{{$product->intermediary}}</td>
                <td>{{$product->group_scheme_profit}}</td>                
            </tr>
        </tbody>
    </table>
    
</div>
</div>



@endsection