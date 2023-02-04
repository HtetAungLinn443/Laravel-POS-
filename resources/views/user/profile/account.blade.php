@extends('user.layouts.master')

@section('title','Account')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-lg-10 offset-1">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Profile</h3>
                        </div>
                        <hr>

                        @if (session('updateSuccess'))
                                        <div class="col-3 offset-8">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa fa-check me-2"></i>  {{ session('updateSuccess') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif
                        <form action="{{ route('user#accountChange',Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row ">
                                <div class="col-4 offset-1">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{ asset('image/default_profile.png') }}" class="img-thumbnail shadow-sm ">
                                        @else
                                            <img src="{{ asset('image/default_female.jpg') }}" class="img-thumbnail shadow-sm ">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/'. Auth::user()->image) }}" class="img-thumbnail shadow-sm"/>
                                    @endif

                                    <div class="mt-3">
                                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mt-3 ">
                                        <a href="" class="d-block">
                                            <button class="btn btn-dark col-12" type="submit">
                                                Update <i class="fa-solid fa-circle-chevron-right ms-2"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label  class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="name" type="text" value="{{ old('name',Auth::user()->name) }}"  class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Ender Your Name...">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label  class="control-label mb-1">Email</label>
                                        <input id="cc-pament" name="email" type="text" value="{{ old('email',Auth::user()->email) }}"  class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Ender Your Email...">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label  class="control-label mb-1">Phone</label>
                                        <input id="cc-pament" name="phone" type="number" value="{{ old('number',Auth::user()->phone) }}"  class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Ender Phone Number...">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control control-label mb-1 @error('gender') is-invalid @enderror">
                                            <option value="">Choose Gender...</option>
                                            <option value="male" @if(Auth::user()->gender == 'male') selected @endif>Male</option>
                                            <option value="female" @if(Auth::user()->gender == 'female') selected @endif>Female</option>
                                        </select>
                                        @error('gender')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label  class="control-label mb-1 ">Address</label>
                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="10" placeholder="Ender Your Address..."> {{ old('address',Auth::user()->address) }}</textarea>
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label  class="control-label mb-1">Role</label>
                                        <input id="cc-pament" name="role" type="text" value="{{ old('role',Auth::user()->role) }}"  class="form-control " aria-required="true" aria-invalid="false" disabled>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
