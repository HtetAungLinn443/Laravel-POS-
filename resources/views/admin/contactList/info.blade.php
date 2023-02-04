@extends('admin.layouts.master')

@section('title', 'Order List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="">
                        <a href="{{ route('admin#contactListPage') }}" class="btn btn-outline-dark btn-sm  mb-3">Back</a>
                    </div>
                    <div class="row">
                        <div class="col-4 bg-light shadow-sm bg-radius" >
                            <div class="row my-3">
                                <div class="col-3"><i class="fa-solid fa-user me-2"></i> Name</div>
                                <div class="col-1">:</div>
                                <div class="col">{{ $contactData->name }}</div>
                            </div>
                            <div class="row my-3">
                                <div class="col-3"><i class="fa-solid fa-envelope me-2"></i> Email</div>
                                <div class="col-1">:</div>
                                <div class="col">{{ $contactData->email }}</div>
                            </div>
                            <div class="row my-3">
                                <div class="col-3"><i class="fa-solid fa-clock me-2"></i></i> Date</div>
                                <div class="col-1">:</div>
                                <div class="col">{{ $contactData->created_at->format('F-j-Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-10 offset-1 mt-5 bg-light shadow-sm bg-radius" style="padding: 30px;">
                        <div class="h3"><i class="fa-solid fa-message me-2"></i> Message</div>
                        <div class="">{{ $contactData->message }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
