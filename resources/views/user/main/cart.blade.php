@extends('user.layouts.master')

@section('title','Cart Page')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                        <tr>
                            <td class=" ps-5 ">
                                <img src="{{ asset('storage/'.$c->pizza_image) }}" alt="" style="width: 50px;">
                                <input type="hidden" id="productId" value="{{ $c->product_id }}">
                                <input type="hidden" id="userId" value="{{ $c->user_id }}">
                                <input type="hidden" id="orderId" value="{{ $c->id }}">
                            </td>
                            <td class=" align-middle">
                                {{ $c->pizza_name }}
                            </td>
                            <td class="align-middle" id="price">{{ $c->pizza_price }} Kyats</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $c->qty }}" id="qty">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle col-2" id="total">{{ $c->qty*$c->pizza_price }} Kyats</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class=" position-relative text-uppercase mb-3"><span class=" pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $totalPrice }} Kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">3000 Kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice+3000 }} Kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To Checkout</button>
                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">Clear Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){
        // when + button click
        $('.btn-plus').click(function(){
            $partntNode = $(this).parents('tr');
            $price = Number($partntNode.find('#price').html().replace("Kyats",""));
            $qty = Number($partntNode.find('#qty').val());
            $totalPrice = $price * $qty;
            $partntNode.find('#total').html($totalPrice + ' Kyats');

            summaryCalculation();

        })

        // when - button click
        $('.btn-minus').click(function(){
            $partntNode = $(this).parents('tr');
            $price = Number($partntNode.find('#price').html().replace("Kyats",""));
            $qty = Number($partntNode.find('#qty').val());
            $totalPrice = $price * $qty;
            $partntNode.find('#total').html($totalPrice + ' Kyats');

            summaryCalculation();

        })

        // when remove button click
        $('.btnRemove').click(function(){
            $partntNode = $(this).parents('tr');
            $productId = $partntNode.find('#productId').val();
            $orderId = $partntNode.find('#orderId').val();

            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/user/ajax/clear/current/product',
                data : {'productId' : $productId, 'orderId' : $orderId},
                dataType : 'json',
            })

            $partntNode.remove();
            summaryCalculation();
        })

        function summaryCalculation(){
            $total = 0;
            $('#dataTable tbody tr').each(function(index,row){
                $total += Number($(row).find('#total').text().replace("Kyats",""));
            });
            $("#subTotalPrice").html(`${$total} Kyats`);
            $("#finalPrice").html(`${$total + 3000} Kyats`);
        }

        // when Order button click
        $('#orderBtn').click(function(){
            $userId = $('#userId').val();
            $orderList = [];

            $random = Math.floor(Math.random() * 1000000001);
            $('#dataTable tbody tr').each(function(index,row){
                $orderList.push({
                    'user_id' : $(row).find('#userId').val(),
                    'product_id' : $(row).find('#productId').val(),
                    'qty' : $(row).find('#qty').val(),
                    'total' : $(row).find('#total').text().replace('Kyats','')*1,
                    'order_code' : 'POS' + $random
                })

            })

            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/user/ajax/order',
                data : Object.assign({},$orderList),
                dataType : 'json',
                success : function(response){
                    if(response.status == "true"){
                        window.location.href = 'http://127.0.0.1:8000/user/homePage';
                    }
                }
            })
        })

        // When clear button click
        $('#clearBtn').click(function(){
            $('#dataTable tbody tr').remove();
            $('#subTotalPrice').html('0 Kyats');
            $('#finalPrice').html('3000 Kyats');

            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/user/ajax/clear/cart',
                dataType : 'json',
            })
        })

    })
</script>
@endsection
