@extends('admin.layouts.master')

@section('title' ,'Order List Page')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Orders List</h2>
                        </div>
                    </div>

                </div>

                <form action="{{ route('admin#changeStatus') }}" method="get">
                    @csrf
                    <div class=" d-flex ">
                        <div class="input-group-text">
                             <i class="fa-solid fa-database me-2"></i> {{ $order->count() }}
                        </div>
                        <select name="orderStatus" id="orderStatus" class="form-control col-2 form-select" >
                            <option value="" selected>All</option>
                            <option value="0" @if(request('orderStatus') == '0') selected @endif>Pending</option>
                            <option value="1" @if(request('orderStatus') == '1') selected @endif>Accept</option>
                            <option value="2" @if(request('orderStatus') == '2') selected @endif>Reject</option>
                        </select>
                        <button class="btn btn-sm btn-dark ms-3" type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i>Search</button>
                    </div>
                </form>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Order Date</th>
                                <th>Order Code</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                        @foreach ($order as $o)
                        <tr class="tr-shadow ">
                            <input type="hidden" class="orderId" value="{{ $o->id }}">
                            <td class="">{{ $o->user_id }}</td>
                            <td class="">{{ $o->user_name }}</td>
                            <td class="">{{ $o->created_at->format('F-d-o g:i a') }}</td>
                            <td class="">
                                <a href="{{ route('admin#listInfo',$o->order_code) }}">{{ $o->order_code }}</a>
                            </td>
                            <td class="">{{ $o->total_price }}</td>
                            <td class="">
                                <select name="status" class="form-control statusChange">
                                    <option value="0" @if($o->status == 0 ) selected @endif>Pending</option>
                                    <option value="1" @if($o->status == 1 ) selected @endif>Accept</option>
                                    <option value="2" @if($o->status == 2 ) selected @endif>Reject</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function(){
            // $('#orderStatus').change(function(){
            //     $status = $('#orderStatus').val();
            //     $.ajax({
            //         type : 'get',
            //         url : 'http://127.0.0.1:8000/order/ajax/status',
            //         data : {'status' : $status},
            //         dataType : 'json',
            //         success : function(response){
            //             $list = '';
            //             for($i=0;$i<response.length;$i++){

            //                 $months = ['January','February','March','April','May','Jun','July','August','September','October','November','December'];
            //                 $dbDate = new Date(response[$i].created_at);

            //                 $pm = ($dbDate.getHours()>=12) ? "pm": "am";
            //                 if($dbDate.getHours() > 12 ){
            //                     $hours = $dbDate.getHours()-12
            //                 } else {
            //                     $hours = $dbDate.getHours()
            //                 }

            //                 $finalDate = $months[$dbDate.getMonth()]+"-"+$dbDate.getDate()+"-"+$dbDate.getFullYear()+" "+ $hours+":"+$dbDate.getMinutes()+" "+$pm;

            //                 if(response[$i].status == 0){
            //                     $statusMessage = `
            //                     <select name="status" class="form-control">
            //                         <option value="0" selected>Pending</option>
            //                         <option value="1" >Accept</option>
            //                         <option value="2" >Reject</option>
            //                     </select>
            //                     `;
            //                 } else if(response[$i].status == 1){
            //                     $statusMessage = `
            //                     <select name="status" class="form-control">
            //                         <option value="0" >Pending</option>
            //                         <option value="1" selected>Accept</option>
            //                         <option value="2" >Reject</option>
            //                     </select>
            //                     `;
            //                 } else if(response[$i].status == 2){
            //                     $statusMessage = `
            //                     <select name="status" class="form-control">
            //                         <option value="0" >Pending</option>
            //                         <option value="1" >Accept</option>
            //                         <option value="2" selected>Reject</option>
            //                     </select>
            //                     `;
            //                 }

            //                 $list += `
            //                     <tr class="tr-shadow ">
            //                         <td class="">${response[$i].user_id}</td>
            //                         <td class="">${response[$i].user_name}</td>
            //                         <td class="">${$finalDate}</td>
            //                         <td class="">${response[$i].order_code}</td>
            //                         <td class="">${response[$i].total_price}</td>
            //                         <td class="">
            //                             ${$statusMessage}
            //                         </td>
            //                     </tr>
            //                 `;
            //             }
            //             $('#dataList').html($list);
            //         }
            //     })
            // })

            // Change Status
            $('.statusChange').change(function(){

                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $('.orderId').val();
                $data = {
                    'orderId' : $orderId,
                    'status' : $currentStatus,
                }

                $.ajax({
                    type : 'get',
                    url : 'http://127.0.0.1:8000/order/ajax/change/status',
                    data : $data,
                    dataType : 'json',
                })
            })
        })
    </script>
@endsection
