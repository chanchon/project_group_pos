@extends('layouts.admin')

@section('title', 'Orders List')
@section('content-header', 'Order List')
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary">รายการขาย</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{route('orders.index')}}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ชื่อลูกค้า</th>
                    <th>ราคารวม</th>
                    <th>รับเงินมาทั้งหมด</th>
                    <th>สถานะ</th>
                    <th>เงินทอน</th>
                    <th>ทำรายการเมื่อ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>{{ config('') }} {{$order->formattedTotal()}}</td>
                    <td>{{ config('') }} {{$order->formattedReceivedAmount()}}</td>
                    <td>
                        @if($order->receivedAmount() == 0)
                            <span class="badge badge-danger">ยังไม่ชำระ</span>
                        @elseif($order->receivedAmount() < $order->total())
                            <span class="badge badge-warning">ชำระบางส่วน</span>
                        @elseif($order->receivedAmount() == $order->total())
                            <span class="badge badge-success">ชำระเต็มจำนวน</span>
                        @elseif($order->receivedAmount() > $order->total())
                            <span class="badge badge-info">รอเงินทอน</span>
                        @endif
                    </td>
                    <td>{{config('')}} {{number_format($order->total() - $order->receivedAmount(), 2)}}</td>
                    <td>{{$order->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ config('') }} {{ number_format($total, 2) }}</th>
                    <th>{{ config('') }} {{ number_format($receivedAmount, 2) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        {{ $orders->render() }}
    </div>
</div>
@endsection

