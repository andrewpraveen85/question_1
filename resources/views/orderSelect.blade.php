@extends('app')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('order.insert') }}" class="btn btn-sm btn-outline-secondary">Insert</a>
                @if($order->order_status ==true)
                    <a href="{{ route('order.update', $order->id) }}" class="btn btn-sm btn-outline-secondary">Update</a>
                @endif
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
        <form method="POST" action="{{ route('order.item.insert') }}">
            @csrf <!-- {{ csrf_field() }} -->
            <div class="form-floating mb-3">
                <select class="form-select" id="menu" name="item" required>
                    <option value="">Choose...</option>
                    <optgroup label="Main Dish">
                        @foreach ($main as $key => $value)
                            <option value="{{ $value->id }}"> 
                                {{ $value->menu_name }} 
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Side Dish">
                        @foreach ($side as $key => $value)
                            <option value="{{ $value->id }}"> 
                                {{ $value->menu_name }} 
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Desserts">
                        @foreach ($dessert as $key => $value)
                            <option value="{{ $value->id }}"> 
                                {{ $value->menu_name }} 
                            </option>
                        @endforeach
                    </optgroup>
                </select>
                <input type="hidden" name=order_id value='{{$order->id}}'>
                @if ($errors->has('item'))
                    <span class="text-danger">{{$errors->first('item')}}</span>
                @endif
            </div>
            <hr class="my-4">
            <button class="w-100 btn btn-lg btn-primary" type="submit">Insert</button>
        </form>
    @endif
    <hr class="my-4">
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Menu</th>
                    <th scope="col">Price</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $row)
                    <tr>
                        <td>{{$row['id']}}</td>
                        <td>{{$row['menu']['menu_name']}}</td>
                        <td>{{number_format($row['menu']['menu_price'], 2, '.', ',')}}</td>
                        <td>
                            @if($order->order_status ==true)
                                <form method="POST" action="{{ route('order.item.delete') }}">
                                    @csrf <!-- {{ csrf_field() }} -->
                                    <input type="hidden" value="{{$row['id']}}" name="item_id" >
                                    <input type="hidden" name=order_id value='{{$order->id}}'>
                                    <button type="submit" class="btn btn-dark btn-block">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
