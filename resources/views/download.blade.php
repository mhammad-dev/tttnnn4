<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            font-family: arial, sans-serif;
            font-size: 15px;
        }
        .wrapper{
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #000;
        }
        .content-se{
      margin: 10px 6px;
    
   }
       .row{
        --bs-gutter-x: 1.5rem;
        --bs-gutter-y: 0;
         display: flex;
         flex-wrap: wrap;
         margin-bottom: 15px;         
        
   }
   .col-6{
    flex: 0 0 auto;
   /* width: 50%;*/
   }
   .justify-content-end{
     justify-content: end;
   }
   h1{
    text-align: center;
    font-size: 22px;
    margin-bottom: 20px;
    font-style: italic;
   }
   .text-end{
    text-align: end;
   }
   .wrap{
    margin-bottom: 4px;
   }
   .wrap span{
    font-family: arial, sans-serif;
    display: inline-block;
    font-weight: 400;
   }
  
   table, th, td {
    margin-top: 200px;
    border: 1px solid black;
    border-collapse: collapse;
    padding: 6px 4px;
   }
   th{
    text-decoration: underline;
    text-align: left;
   }
   .total{
    display: flex;
    justify-content: end;
   }
   .bank span{
     display: block;
   }
  
    </style>
</head>
<body>
     <div class="wrapper">
      <section class="content-se">
      <h1>COMMISION STATEMENT</h1>
       <div class="row">
            <div class="col-6" style="float:left">
                 <div class="wrap"><span>CARECOVER(PTY)Ltd</span></div>
                 <div class="wrap"><span>IBM number:</span><span>{{$user->ibm}}</span></div>
                 <div class="wrap"><span>Name:</span><span>{{$user->name}}</span></div>
                 <div class="wrap"><span>Address:</span><span>[variable]</span></div>
                 <div class="wrap"><span>Email Address:</span><span>{{$user->email}}</span></div>
                 <div class="wrap"><span>Phone:</span><span>{{$user->whatsapp_number}}</span></div> 
            </div>
        
         <div class="col-6 text-end" style="float:right;">
           <div class="wrap"><span>45 stonehedge<br> Disa Road <br> Gordon's Bay 7140</span></div>
            <div class="wrap"><span>Invoice Nr:</span><span>CNN-000{{date('dmy')}}-{{$user->ibm}}</span></div> 
            <div class="wrap"><span>Date:</span><span>{{date('d-m-Y')}}</span></div> 
            <div class="wrap"><span>Payment Terms:</span>
                @if(empty($daysInterval))
                <span> 30 Days</span>
                @else
                <span> {{$daysInterval}} Days</span>
                @endif
            </div>  
         </div>
       </div>
    
        
         <table style="width:100%">
             <tr>
               <th>IBM Number</th>
               <th>Name</th>
               <th>Amount</th>
             </tr>
        @for($i=1 ; $i<=$levels; $i++)
             <tr>
                <th>Level{{$i}}</th>
                <th></th>
                <th></th>
             </tr>
        @foreach($data as $row)
            @if($row->level==$i)
             <tr>
               <td>{{$row->ibm}}</td>
               <td>{{$row->name}}</td>
               <td>R {{$row->commission_paid}}</td>
             </tr>
            @endif
        @endforeach

        @endfor
             {{-- <tr>
               <td>IBM002</td>
               <td>John Smith</td>
               <td>R 50.00</td>
             </tr>
             <tr>
                <th>Level2</th>
                <th></th>
                <th></th>
             </tr>
             <tr>
                <td>IBM003</td>
                <td>Ephron Maralack</td>
                <td>R 60.00</td>
              </tr>
              <tr>
                <th>Level3</th>
                <th></th>
                <th></th>
             </tr> --}}
             <tr>
                <td></td>
                <td></td>
                <td></td>
             </tr>
           </table>
           <div class="total">
            <div style="width: 22%;">
            <span>Total</span><span>R:{{$total_comm}}</span>
           </div>
           </div>
           <div class="bank">  
                <span>Bank Account Details</span>
                <span>{{$user->bank_name}}</span>
          </div>

        </section>
     </div>
</body>
</html>