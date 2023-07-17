<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Item;
use DB;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
      
    public function loginConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->withSuccess('Signed in');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
    
    public function dashboard()
    {
        if(Auth::check()){
            $orders = Order::orderBy('id', 'DESC')->get()->toArray();
            return view('dashboard',['orders'=>$orders,]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function orderInsert()
    {
        if(Auth::check()){
            $main = Menu::select('menu_name', 'id')->where('menu_type', 'main')->get();
            return view('orderInsert',['main'=>$main]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function orderInsertConfirm(Request $request)
    {
        if(Auth::check()){
            $request->validate([
                'item' => 'required',
            ]);
            $menu = Menu::where('id', $request->input('item'))->first();
            $order = Order::create(['order_cost'=>$menu->menu_price, 'order_status'=>true]);
            Item::create(['order_id'=> $order->id, 'menu_id'=>  $request->input('item')]);
            return redirect()->route('order.select', ['id'=>$order->id]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function orderSelect($id)
    {
        if(Auth::check()){
            $main = Menu::select('menu_name', 'id')->where('menu_type', 'main')->get();
            $side = Menu::select('menu_name', 'id')->where('menu_type', 'side')->get();
            $dessert = Menu::select('menu_name', 'id')->where('menu_type', 'dessert')->get();
            $orderItems = Item::where('order_id', $id)->with(['menu' => function ($query) {
                $query->select('id', 'menu_name', 'menu_price');
            }])->get()->toArray();
            $order = Order::where('id', $id)->first();
            return view('orderSelect',['order'=>$order,'main'=>$main, 'side'=>$side, 'dessert'=>$dessert, 'orderItems'=>$orderItems]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function orderItemInsert(Request $request)
    {
        if(Auth::check()){
            $request->validate([
                'item' => 'required',
                'order_id' => 'required',
            ]);
            Item::create(['order_id'=> $request->input('order_id'), 'menu_id'=>  $request->input('item')]);
            $orderItems = Item::where('order_id', $request->input('order_id'))->get();
            $total = 0;
            foreach($orderItems as $item){
                $menu = Menu::where('id', $item->menu_id)->first();
                $total = $total + $menu->menu_price;
            }
            Order::where('id', $request->input('order_id'))->update([
                'order_cost' => $total
            ]);
            return redirect()->route('order.select', ['id'=>$request->input('order_id')]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function orderItemDelete(Request $request)
    {
        if(Auth::check()){
            $request->validate([
                'item_id' => 'required',
                'order_id' => 'required'
            ]);
            Item::where('id', $request->input('item_id'))->delete();
            $orderItems = Item::where('order_id', $request->input('order_id'))->get();
            $total = 0;
            foreach($orderItems as $item){
                $menu = Menu::where('id', $item->menu_id)->first();
                $total = $total + $menu->menu_price;
            }
            Order::where('id', $request->input('order_id'))->update([
                'order_cost' => $total
            ]);
            return redirect()->route('order.select', ['id'=>$request->input('order_id')]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function orderUpdate($id)
    {
        if(Auth::check()){
            $order = Order::where('id', $id)->first();
            return view('orderUpdate',['order'=>$order]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function orderUpdateConfirm(Request $request)
    {
        if(Auth::check()){
            $request->validate([
                'order_status' => 'required',
                'order_id' => 'required',
            ]);
            Order::where('id', $request->input('order_id'))->update([
                'order_status' => $request->input('order_status')
            ]);
            return redirect()->route('order.select', ['id'=>$request->input('order_id')]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function reportToday($date)
    {
        if(Auth::check()){
            $from = $date.' 00:00:00';
            $to = $date.' 23:59:59';
            $orders = Order::where('created_at', '>=', $from)->where('updated_at','<=', $to)->get();
            $total = 0;
            foreach($orders as $row){
                $total = $total + $row->order_cost;
            }
            return view('reportDate',['orders'=>$orders->toArray(), 'total'=>$total]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function reportDate(Request $request)
    {
        if(Auth::check()){
             $request->validate([
                'date' => 'required',
            ]);
            $from = $request->input('date').' 00:00:00';
            $to = $request->input('date').' 23:59:59';
            $orders = Order::where('created_at', '>=', $from)->where('updated_at','<=', $to)->get();
            $total = 0;
            foreach($orders as $row){
                $total = $total + $row->order_cost;
            }
            return view('reportDate',['orders'=>$orders->toArray(), 'total'=>$total]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function reportFamous()
    {
        if(Auth::check()){
            $main = Item::select('menu_id', DB::raw('count(id) as total'))
                    ->groupBy('menu_id')
                    ->with(['menu' => function ($query){$query->select('id', 'menu_name');}])
                    ->whereIn('menu_id', Menu::select('id')->where('menu_type', 'main')->get()->toArray())
                    ->orderBy('total', 'desc')
                    ->get()->toArray();
            $side = Item::select('menu_id', DB::raw('count(id) as total'))
                    ->groupBy('menu_id')
                    ->with(['menu' => function ($query){$query->select('id', 'menu_name', 'menu_type');}])
                    ->whereIn('menu_id', Menu::select('id')->where('menu_type', 'side')->get()->toArray())
                    ->orderBy('total', 'desc')
                    ->get()->toArray(); 
            $dessert = Item::select('menu_id', DB::raw('count(id) as total'))
                    ->groupBy('menu_id')
                    ->with(['menu' => function ($query) {$query->select('id', 'menu_name', 'menu_type');}])
                    ->whereIn('menu_id', Menu::select('id')->where('menu_type', 'dessert')->get()->toArray())
                    ->orderBy('total', 'desc')
                    ->get()->toArray();
            return view('reportFamous',['main'=>$main, 'side'=>$side, 'dessert'=>$dessert, ]);
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    } 
}
