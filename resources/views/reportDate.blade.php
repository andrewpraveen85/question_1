@extends('app')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Report</h1>
    </div>
    <h2>Revenue</h2>
    <form method="POST" action="{{ route('report.date') }}">
        @csrf <!-- {{ csrf_field() }} -->
        <div class="form-floating mb-3 row">
            <div class="col-md-6">
                <input type="date" name="date" class="form-select" >
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-dark btn-block">Filter</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Order Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $row)
                    <tr>
                        <td>{{$row['id']}}</td>
                        @if($row['order_status'] ==true)
                            <td>Active</td>
                        @else
                            <td>Inactive</td>
                        @endif
                        <td>{{number_format($row['order_cost'], 2, '.', ',')}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <th>{{number_format($total, 2, '.', ',')}}</th>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

