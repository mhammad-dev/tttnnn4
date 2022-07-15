@extends('admin.layout.master')
@push('plugin-styles')
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style type="text/css">
    /*  input#txtDate {
        border: 1px solid;
    }*/
  </style>

@endpush
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reconcillation</div>
                <div class="card-body">
                    <form method="POST" id="reconcillation-form" >
                        @csrf
                        <div class="form-group">
                            <label for="txtDate">Select Date</label>
                             <input type='text' class="form-control" id='txtDate' name="txtDate" /> &nbsp;&nbsp;&nbsp;
                        </div>
                      
                       <a href="#" onclick="reconcile();" class="btn btn-primary">Reconcile</a>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$(document).ready(function() {

   $('#txtDate').datepicker({

     changeMonth: true,
     changeYear: true,
     dateFormat: 'MM yy',
     showButtonPanel: true,
    
     onClose: function() {
        var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
        var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
     },
       
     beforeShow: function() {
       if ((selDate = $(this).val()).length > 0) 
       {
          iYear = selDate.substring(selDate.length - 4, selDate.length);
          iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), $(this).datepicker('option', 'monthNames'));
          $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
           $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
       }
    }
  });
});
function reconcile () {
     var data = $('#reconcillation-form').serialize();
     //console.log(data);
            $.ajax({
               type:'POST',
               url:'/admin/reconcile',
               data:data,
               success:function(response) {
                   alert(response['msg']);
                   $('#reconcillation-form')[0].reset();
               },
               error:function(response){
                  alert(response);
               }
            });
         }
</script>
@endpush