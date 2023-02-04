@extends('admin.layouts.master')

@section('title' ,'Order Product List Page')

@section('content')
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-responsive table-responsive-data2">
                    <div class="btn btn-sm btn-outline-dark mb-3">
                        <a href="{{ route('admin#orderList') }}" class="text-dark ">Back</a>
                    </div>

                    <div class="row col-5" >
                        <div class="card " style="border-radius: 20px !important;">
                            <div class="card-body">
                                <h3><i class="fa-solid fa-clipboard me-2"></i> Order Info</h3>

                                <small class="text-warning "><i class="fa-solid fa-triangle-exclamation me-2"></i> Include Delivery Charges</small>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-user me-2"></i> Name</div>
                                    <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i> Order Code</div>
                                    <div class="col">{{ $orderList[0]->order_code }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-regular fa-clock me-2"></i> Order Date</div>
                                    <div class="col">{{ $orderList[0]->created_at->format('F-j-Y') }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-money-bill-wave me-2"></i> Total Price</div>
                                    <div class="col">{{ $order->total_price }} Kyats</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th class="col-0"></th>
                                <th >User ID</th>
                                <th class="col-2">Product Image</th>
                                <th >Product Name</th>
                                <th >Quantity</th>
                                <th >Amount</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                           @foreach ($orderList as $o)
                           <tr>
                                <td class="col-0"></td>
                                <td>{{ $o->user_id }}</td>
                                <td>
                                    <img src="{{ asset('storage/'.$o->product_image) }}" class="img-thumbnail ">
                                </td>
                                <td>{{ $o->product_name }}</td>
                                <td>{{ $o->qty }}</td>
                                <td>{{ $o->total }}</td>
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

