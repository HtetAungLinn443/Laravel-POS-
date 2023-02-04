@extends('user.layouts.master')

@section('title','History Page')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid" style="height:60vh">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5">

                <div class="">
                    <a href="{{ route('user#home') }}" class="btn btn-outline-dark btn-sm  mb-3">Back</a>
                </div>
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $o)
                        <tr>
                            <td class="align-middle" >{{ $o->created_at->format('F-d-o g:i a') }}</td>
                            <td class="align-middle" >{{ $o->order_code }}</td>
                            <td class="align-middle" >{{ $o->total_price }}</td>
                            <td class="align-middle" >
                                @if ($o->status==0)
                                    <span class="text-warning"><i class="fa-solid fa-spinner me-2 "></i> Pending</span>
                                @elseif ($o->status==1)
                                    <span class="text-success"><i class="fa-solid fa-check me-2"></i></i> Success</span>
                                @elseif($o->status==2)
                                    <span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> Reject</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $order->links() }}
                </div>
            </div>

        </div>
    </div>
    <!-- Cart End -->
@endsection


