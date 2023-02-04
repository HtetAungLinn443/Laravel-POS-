@extends('user.layouts.master')

@section('title', 'Home')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class=" position-relative text-uppercase mb-3">
                    <span class="pr-3">Filter by price</span>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div
                            class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 bg-dark text-white  py-2 px-4">

                            <label class="mt-2 fs-5" for="price-all ">Categories</label>
                            <span class="badge border font-weight-normal ">{{ count($category) }}</span>
                        </div>
                        <div class="custom-control custom-checkbox  d-flex align-items-center justify-content-between mb-3 "
                            style="border-bottom: 1px solid rgba(0, 0, 0, 0.285)">
                            <a href="{{ route('user#home') }}" class="text-dark">
                                <label class="fs-5" style="cursor: pointer" for="price-1">All</label>
                            </a>
                        </div>
                        @foreach ($category as $c)
                            <div class="custom-control custom-checkbox  d-flex align-items-center justify-content-between mb-3 "
                                style="border-bottom: 1px solid rgba(0, 0, 0, 0.285)">
                                <a href="{{ route('user#filter', $c->id) }}" class="text-dark " style="cursor: pointer">
                                    <label class="fs-5" for="price-1" style="cursor: pointer">{{ $c->name }}</label>
                                </a>
                            </div>
                        @endforeach

                    </form>
                </div>
                <!-- Price End -->

                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="">
                                <a href="{{ route('user#cartList') }}">
                                    <button type="button" class="btn btn-sm btn-dark position-relative">
                                        <i class="fa-solid fa-cart-shopping me-1"></i>
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($cart) }}
                                        </span>
                                    </button>
                                </a>
                                <a href="{{ route('user#history') }}" class="ms-3">
                                    <button type="button" class="btn btn-sm btn-dark position-relative">
                                        <i class="fa-solid fa-clock-rotate-left me-2"></i> History
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($history) }}
                                        </span>
                                    </button>
                                </a>

                            </div>
                            <div class="ml-2">
                                @if (session('response'))
                                    <div class="">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fa-solid fa-check me-2"></i>  {{ session('response') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif

                                <div class="btn-group">
                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="">Choose Option...</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="row" id="dataList">
                        @if (count($pizza) != 0)
                            @foreach ($pizza as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <a href="{{ route('user#detailsPage', $p->id) }}">
                                        <div class="product-item bg-light mb-4 ">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100" src="{{ asset('storage/' . $p->image) }}"
                                                    alt="" style="height: 350px">
                                            </div>
                                            <div class="text-center py-4">
                                                <a class="h6 text-decoration-none text-truncate" href="{{ route('user#detailsPage', $p->id) }}">{{ $p->name }}</a>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>{{ $p->price }} Kyats</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
    </div>
    <!-- Shop End -->

@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();

                if ($eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/pizzaList',
                        data: {
                            'status': 'asc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                console.log(`${response[$i].name}`);
                                $list += `
                                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                            <div class="product-item bg-light mb-4 ">
                                                <div class="product-img position-relative overflow-hidden">
                                                    <img class="img-fluid w-100" src="{{ asset('storage/${response[$i].image}') }}" alt="" style="height: 300px">
                                                    <div class="product-action">
                                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                                    </div>
                                                </div>
                                                <div class="text-center py-4">
                                                    <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                                        <h5>${response[$i].price}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        `;
                            }

                            $('#dataList').html($list);
                        }
                    })

                } else if ($eventOption == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/pizzaList',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(response) {

                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                console.log(`${response[$i].name}`);
                                $list += `
                                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" >
                                            <div class="product-item bg-light mb-4 " id="myForm">
                                                <div class="product-img position-relative overflow-hidden">
                                                    <img class="img-fluid w-100" src="{{ asset('storage/${response[$i].image}') }}" alt="" style="height: 300px">
                                                    <div class="product-action">
                                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                                    </div>
                                                </div>
                                                <div class="text-center py-4">
                                                    <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                                        <h5>${response[$i].price}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        `;
                            }

                            $('#dataList').html($list);
                        }
                    })
                }
            })
        })
    </script>
@endsection
