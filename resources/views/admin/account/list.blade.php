@extends('admin.layouts.master')

@section('title', 'Admin List Page')

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
                                <h2 class="title-1">Admin List</h2>

                            </div>
                        </div>

                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-3">
                            <h4>Search Key : <span class="text-danger">{{ request('key') }}</span> </h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search"
                                        value="{{ request('key') }}">
                                    <button class="btn btn-dark" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-1 offset-10 bg-white shadow-sm p-2 text-center border-radious">
                            <h3> {{ $admin->total() }} <i class="fa fa-users ms-2"></i> </h3>
                        </div>
                    </div>
                    @if (count($admin) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $a)
                                        <tr class="tr-shadow ">
                                            <td style="width: 150px !important">
                                                @if ($a->image == null)
                                                    @if ($a->gender == 'male')
                                                        <img src="{{ asset('image/default_profile.png') }}"
                                                            class="img-thumbnail shadow-sm ">
                                                    @else
                                                        <img src="{{ asset('image/default_female.jpg') }}"
                                                            class="img-thumbnail shadow-sm ">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/' . $a->image) }}"
                                                        class="img-thumbnail shadow-sm ">
                                                @endif
                                            </td>
                                            <td style="text-transform: capitalize">{{ $a->name }}</td>
                                            <td>{{ $a->email }}</td>
                                            <td>{{ $a->phone }}</td>
                                            <td style="text-transform: capitalize">{{ $a->gender }}</td>
                                            <td>{{ $a->address }}</td>
                                            <input type="hidden" value="{{ $a->id }}" id="userId">
                                            <td>
                                                <div class="table-data-feature">
                                                    @if (Auth::user()->id == $a->id)
                                                    @else
                                                        {{-- <a href="{{ route('admin#changeRole',$a->id) }}">
                                                            <button class="item me-3" data-toggle="tooltip" data-placement="top" title="Change Admin Role">
                                                                <i class="fa-solid fa-person-circle-minus "></i>
                                                            </button>
                                                        </a> --}}
                                                        <select class="form-control statusChange me-3" id="">
                                                            <option value="admin">Admin</option>
                                                            <option value="user">User</option>
                                                        </select>

                                                        <a href="{{ route('admin#delete', $a->id) }}">
                                                            <button class="item me-2" data-toggle="tooltip"
                                                                data-placement="top" title="Delete">
                                                                <i class="fa-solid fa-trash-can "></i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $admin->links() }}
                            </div>
                        </div>
                    @else
                        <h3 class="text-secondary text-center my-5 ">There is no Admin Here!</h3>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->

@endsection

@section('scriptSection')
    <script>
        $(document).ready(function() {
            // Change Status
            $('.statusChange').change(function() {
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find('#userId').val();

                $data = {
                    'userId': $userId,
                    'role': $currentStatus

                }

                $.ajax({
                    type: 'get',
                    url: '/admin/role/changes',
                    data: $data,
                    dataType: 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
