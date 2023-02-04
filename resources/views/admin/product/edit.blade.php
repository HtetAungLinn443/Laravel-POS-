@extends('admin.layouts.master')

@section('title', 'Edit Page')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5" style="cursor: pointer">
                                <i class="fa-solid fa-left-long" onclick="history.back()"></i>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-1">
                                    <img src="{{ asset('storage/'.$pizza->image) }}" class="img-thumbnail shadow-sm"/>
                                </div>
                                <div class="col-8  ">
                                    <h3 class="my-3 text-danger">{{ $pizza->name }}</h3>
                                    <span class="me-1 my-2 btn btn-dark"> <i class="fa-solid fa-money-bill-1-wave  me-1 text-primary"></i> {{ $pizza->price }}</span>
                                    <span class="me-1 my-2 btn btn-dark"> <i class="fa-regular fa-clock  me-1 text-primary"></i> {{ $pizza->waiting_time }}</span>
                                    <span class="me-1 my-2 btn btn-dark"> <i class="fa-solid fa-eye  me-1 text-primary"></i> {{ $pizza->view_count }}</span>
                                    <span class="me-1 my-2 btn btn-dark"> <i class="fa-solid fa-coins  text-primary"></i> {{ $pizza->category_name }}</span>
                                    <span class="me-1 my-2 btn btn-dark"> <i class="fa-solid fa-user-clock  me-1 text-primary"></i> {{ $pizza->created_at->format('j F Y') }}</span>
                                    <div class="mt-3 "> <i class="fa-regular fa-file-lines me-1 text-primary h4"></i> Details</div>
                                    <h5 class=""> {{ $pizza->description }} </h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
