@extends('app')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('order.insert') }}" class="btn btn-sm btn-outline-secondary">Insert</a>
                <a href="{{ route('order.select', $order->id) }}" class="btn btn-sm btn-outline-secondary">Select</a>
            </div>
        </div>
    </div>
    <h2>View</h2>
    <div class="row">
        <div class="col-md-2">#</div>
        <div class="col-md-2">{{$order->id}}</div>
        <div class="col-md-2">Status</div>
        @if($order->order_status ==true)
            <div class="col-md-2">Active</div>
        @else
            <div class="col-md-2">Inactive</div>
        @endif
        <div class="col-md-2">Total Price</div>
        <div class="col-md-2">{{number_format($order->order_cost, 2, '.', ',')}}</div>
    </div>
    @if($order->order_status ==true)
        <hr class="my-4">
        <form method="POST" action="{{ route('order.update.confirm') }}">
            @csrf <!-- {{ csrf_field() }} -->
            <div class="form-floating mb-3">
                <select class="form-select" id="menu" name="order_status" required>
                    <option value="1">Choose...</option>
                    <option value="0">Inactive</option>
                </select>
                <input type="hidden" name=order_id value='{{$order->id}}'>
                @if ($errors->has('order_status'))
                    <span class="text-danger">{{$errors->first('order_status')}}</span>
                @endif
            </div>
            <hr class="my-4">
            <button class="w-100 btn btn-lg btn-primary" type="submit">Update</button>
        </form>
    @endif
@endsection
