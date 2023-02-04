@extends('admin.layouts.master')

@section('title' ,'Order List Page')

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
                            <h2 class="title-1">User List</h2>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">

                    <div class="offset-10 mb-3 btn btn-dark btn-sm">
                        <i class="fa-solid fa-users me-2"></i> Total  - {{ $userList->total() }}
                    </div>

                    <table class="table table-data2 text-center">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($userList as $u)
                            <tr>
                                <td  style="width: 120px !important">
                                    @if ( $u->image == null)
                                        @if ($u->gender == 'male')
                                            <img src="{{ asset('image/default_profile.png') }}" class="img-thumbnail shadow-sm ">
                                        @else
                                            <img src="{{ asset('image/default_female.jpg') }}" class="img-thumbnail shadow-sm ">
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/'.$u->image) }}" class="img-thumbnail shadow-sm ">
                                    @endif
                                </td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->phone }}</td>
                                <td>{{ $u->gender }}</td>
                                <td>{{ $u->address }}</td>

                                <input type="hidden" id="userId" value="{{ $u->id }}">
                                <td >
                                    <select class="form-control statusChange me-3" >
                                        <option value="admin" @if($u->role == 'admin' ) selected @endif >Admin</option>
                                        <option value="user" @if($u->role == 'user' ) selected @endif >User</option>
                                    </select>

                                </td>
                                <td>
                                    <a href="{{ route('admin#delete',$u->id) }}">
                                        <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fa-solid fa-trash-can "></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $userList->links() }}
                    </div>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function(){
            // Change Status
            $('.statusChange').change(function(){
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find('#userId').val();

                $data = {
                        'userId' : $userId,
                        'role' : $currentStatus
                    }

                $.ajax({
                    type : 'get',
                    url : 'http://127.0.0.1:8000/user/change/role',
                    data : $data,
                    dataType : 'json',
                })
                location.reload();
            })
        })
    </script>
@endsection
