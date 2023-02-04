@extends('admin.layouts.master')

@section('title', 'Change Row Page')

@section('content')

    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">

                        <div class="card-body">
                            <div class="ms-5 mt-3" >
                                <a href="{{ route('admin#list') }}">
                                    <i class="fa-solid fa-left-long text-dark fs-3" ></i>
                                </a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Role</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#change',$account->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                            @if ($account->gender == 'male')
                                                <img src="{{ asset('image/default_profile.png') }}" class="img-thumbnail shadow-sm ">
                                            @else
                                                <img src="{{ asset('image/default_female.jpg') }}" class="img-thumbnail shadow-sm ">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'. $account->image) }}" class="img-thumbnail shadow-sm"/>
                                        @endif

                                        <div class="mt-3 ">
                                            <a href="" class="d-block">
                                                <button class="btn btn-dark col-12" type="submit">
                                                   Change <i class="fa-solid fa-circle-chevron-right ms-2"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-6 ">
                                        <div class="form-group">
                                            <label  class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text" disabled value="{{ old('name',$account->name) }}"  class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Ender Your Name...">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Role</label>
                                            <select name="role" class="form-control">
                                                <option value="admin" @if($account->role == 'admin') selected @endif >Admin</option>
                                                <option value="user" @if($account->role == 'user') selected @endif >User</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="text" disabled value="{{ old('email',$account->email) }}"  class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Ender Your Email...">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="number" disabled value="{{ old('number',$account->phone) }}"  class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Ender Phone Number...">
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender" disabled class="form-control control-label mb-1 @error('gender') is-invalid @enderror">
                                                <option value="">Choose Gender...</option>
                                                <option value="male" @if($account->gender == 'male') selected @endif>Male</option>
                                                <option value="female" @if($account->gender == 'female') selected @endif>Female</option>
                                            </select>
                                            @error('gender')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1 ">Address</label>
                                            <textarea name="address" disabled class="form-control @error('address') is-invalid @enderror" cols="30" rows="10" placeholder="Ender Your Address..."> {{ old('address',$account->address) }}</textarea>
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
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
    <!-- END MAIN CONTENT-->
@endsection
