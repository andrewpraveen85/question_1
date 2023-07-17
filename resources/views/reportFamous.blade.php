@extends('app')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Report</h1>
    </div>
    <h2>Famous Main Dish</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Menu</th>
                    <th scope="col">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($main as $row)
                    <tr>
                        <td>{{$row['menu']['menu_name']}}</td>
                        <td>{{$row['total']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <h2>Famous Side Dish</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Menu</th>
                    <th scope="col">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($side as $row)
                    <tr>
                        <td>{{$row['menu']['menu_name']}}</td>
                        <td>{{$row['total']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <h2>Famous Dessert Dish</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Menu</th>
                    <th scope="col">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dessert as $row)
                    <tr>
                        <td>{{$row['menu']['menu_name']}}</td>
                        <td>{{$row['total']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

