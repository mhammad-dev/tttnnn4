@extends('admin.layout.master')
@section('content')
<nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Transactions</li>
            <li class="breadcrumb-item">Import Transactions</li>
             <li class="breadcrumb-item">Data Mapping</li>
            <li class="breadcrumb-item active" aria-current="page">Confirm Transaction</li>
        </ol>
    </nav>
	  @if ( $message = Session::get('errors'))
    <div class="alert alert-danger">
      <p>{{$message}}</p>
    </div>
    @elseif($message = Session::get('success'))
    <div class="alert alert-success">
       <p>{{$message}}</p>
    </div>
    @endif

    <div class="row d-flex">
    	 <div class="col-md-12 float-right mt-3 mb-4 d-flex justify-content-center">
    		<form action="{{ route('admin.transactions.confirm') }}" method="POST">
    			@csrf
    			<button class="transaction-btn btn btn-primary">
    				Confirm
    			</button>
    		</form> 
    		&nbsp;
    		&nbsp;
    		<form action="{{ route('admin.transactions.rollback') }}" method="POST">
    			@csrf
    			<button class="transaction-btn btn btn-secondary">
    				Rollback
    			</button>
    		</form> 
    	 	
			

            	
        </div>
    </div>
    
    <div class="row card py-4 px-3">
        <div class="col-md-12 transactions-card-respo">
           {{--  <form action="{{ route('import_parse') }}" method="POST" class="mb-4" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="csv_file">CSV file to Import</label>
                    <input id="csv_file" class="form-control" type="file" name="csv_file" required />
                </div>

                <div class="form-group">
                    <label for="header">File Contains Header row? </label>
                    <input id="header" class="ml-2 form-check-input" type="checkbox" name="header" checked />
                </div>

                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </form> --}}


            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Identification no</th>
                            <th>Description</th>
                            <th>Policy_no</th>
                            <th>Status</th>
                            <th>Title</th>
                            <th>Initials</th>
                            <th>Client</th>
                            <th>
                            	Risk amt 
                            	<span class="table-data-extra">(ex vat)</span>
                            </th>
                            <th>
                            	Comm Fee 
                            	<span class="table-data-extra">(ex vat)</span>
                            </th>
                            <th>
                            	Comm Fee 
                            	<span class="table-data-extra">(with vat)</span>
                            </th> 
                            <th>
                            	Balance Brought Forward 
                            	<span class="table-data-extra">(ex vat)</span>
                            </th>
                            <th>
                            	Total Owed 
                            	<span class="table-data-extra">(ex vat)</span>
                            </th>
                            <th>
                            	Total Paid 
                            	<span class="table-data-extra">(ex vat)</span>
                            </th>
                            <th>
                            	Balance Carried Forward 
                            	<span class="table-data-extra">(ex vat)</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{$transaction->identification_no}}</td>
                                <td>{{$transaction->description}}</td>
                                <td>{{$transaction->policy_no}}</td>
                                <td>{{$transaction->status}}</td>
                                <td>{{$transaction->title}}</td>
                                <td>{{$transaction->initials}}</td>
                                <td>{{$transaction->client}}</td>
                                <td>{{$transaction->risk_amt_ex_vat}}</td>
                                <td>{{$transaction->comm_fee_ex_vat}}</td>
                                <td>{{$transaction->comm_fee_vat}}</td>
                                <td>{{$transaction->balance_brought_forward_ex_vat}}</td>
                                <td>{{$transaction->total_owed_ex_vat}}</td>
                                <td>{{$transaction->total_paid_ex_vat}}</td>
                                <td>{{$transaction->balance_carried_forward_ex_vat}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="float-left mt-4">
                 {{ $transactions->links() }}
            </div>
           

        </div>
    </div>
@endsection