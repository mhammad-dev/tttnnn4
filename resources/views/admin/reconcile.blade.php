@extends('admin.layout.master')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <form method="POST" >
                        @csrf
                       <a href="#" onclick="reconcile();" class="btn btn-primary">Reconcile</a>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
function reconcile () {
            $.ajax({
               type:'POST',
               url:'/admin/reconcile',
               data:{"_token": "{{ csrf_token() }}"},
               success:function(data) {
                    console.log(data);
               }
            });
         }
</script>
@endpush