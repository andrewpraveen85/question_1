@extends('app')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('order.insert') }}" class="btn btn-sm btn-outline-secondary">Insert</a>
            </div>
        </div>
    </div>
    <h2>Create</h2>
    <form method="POST" action="{{ route('order.insert.confirm') }}">
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
            </select>
            @if ($errors->has('item'))
                <span class="text-danger">{{$errors->first('item')}}</span>
            @endif
        </div>
        <hr class="my-4">
        <button class="w-100 btn btn-lg btn-primary" type="submit">Insert</button>
    </form>
@endsection
