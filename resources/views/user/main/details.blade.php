@extends('user.layouts.master')

@section('title', 'Details Page')

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">


        <div class="row px-xl-5">
            <div class="mb-4 fs-3 ">
                <a href="{{ route('user#home') }}" class="text-dark text-decoration-none">
                    <i class="fa-solid fa-left-long me-2"></i>Back
                </a>
            </div>
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class=" img-thumbnail" src="{{ asset('storage/' . $pizza->image) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $pizza->name }}</h3>
                    <div class="d-flex mb-3">
                        {{-- <div class="text-gold mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div> --}}
                        <small class="pt-1">( {{ $pizza->view_count + 1 }} ) <i class="fa-solid fa-eye"></i> </small>
                    </div>

                    <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                    <input type="hidden" value="{{ $pizza->id }}" id="pizzaId">

                    <h3 class="font-weight-semi-bold mb-4">{{ $pizza->price }} Kyats</h3>
                    <p class="mb-4">{{ $pizza->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control  border-0 text-center" id="orderCount" value="1">

                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary px-3" id="addCardBtn"><i
                                class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class=" position-relative text-uppercase mx-xl-5 mb-4"><span class=" pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($pizzaList as $p)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <a href="{{ route('user#detailsPage', $p->id) }}">
                                    <img class=" " src="{{ asset('storage/' . $p->image) }}" height="280px"
                                        alt="">
                                </a>

                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $p->price }} Kyats</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-gold mr-1"></small>
                                    <small class="fa fa-star text-gold mr-1"></small>
                                    <small class="fa fa-star text-gold mr-1"></small>
                                    <small class="fa fa-star text-gold mr-1"></small>
                                    <small class="fa fa-star-half-alt text-gold mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            // increase view count
            $.ajax({
                type: 'get',
                url: '/user/ajax/increase/viewCount',
                data: {
                    'productId': $('#pizzaId').val()
                },
                dataType: 'json',

            })

            $('#addCardBtn').click(function() {
                $source = {
                    'userId': $("#userId").val(),
                    'pizzaId': $('#pizzaId').val(),
                    'count': $('#orderCount').val(),
                };
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/addToCard',
                    data: $source,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = '/user/homePage';
                        }
                    }
                })
            })
        })
    </script>
@endsection
