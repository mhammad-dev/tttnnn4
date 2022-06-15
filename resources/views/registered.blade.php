@extends('user.layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
         {{--  <div class="col-md-4 pr-md-0">
            <div class="auth-left-wrapper" style="background-image: url({{ url('https://via.placeholder.com/219x452') }})">

            </div>
          </div> --}}
          <div class="col-md-12 pl-md-0">
            <div class="auth-form-wrapper px-4 py-5">

              @if($message = Session::get('success'))
                <div class="alert alert-success">
                    {!!html_entity_decode($message)!!}
                </div>
              @endif

               
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection


