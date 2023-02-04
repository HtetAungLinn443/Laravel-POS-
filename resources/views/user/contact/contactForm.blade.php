@extends('user.layouts.master')

@section('title','Contact Page')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid" >
        <div class="row px-xl-5">
            <div class="col-lg-4 offset-4 table-responsive mb-5 ">
                <div class="title">
                    <h3 class="text-center">Contact Page </h3>
                </div>
                <div class="mb-3">
                    <a href="{{ route('user#home') }}" class="btn btn-outline-dark btn-sm  mb-3">Back</a>
                </div>



                <form action="{{ route('user#contactInfo') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Ender Your Name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="eamil" class="form-label">Email</label>
                        <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" id="eamil" placeholder="Ender Your Email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" cols="30" rows="10" placeholder="Ender Message">{{ old('message') }}</textarea>
                        @error('message')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button class="btn btn-dark col-2 offset-5 mt-2" type="submit">Send</button>
                </form>


            </div>

        </div>
    </div>
    <!-- Cart End -->
@endsection


