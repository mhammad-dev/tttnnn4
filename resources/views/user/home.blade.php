@extends('user.layout.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(Auth::user()->scheme_type == 2)
                    {{ __('You are logged in as Scheme Group Member!') }}
                    @else
                    {{ __('You are logged in as User!') }}
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
