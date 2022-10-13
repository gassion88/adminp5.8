<?php

namespace App\Http\Controllers\Vendor;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Vendor;
use App\Models\OrderTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class DashboardController extends Controller
{
    public function go_del(Request $request)
    {
        
        if ($request['number'] !=''){

            $or = [
                'id' => 100000 + Order::all()->count() + 1,
                'user_id' => 8,
                'order_amount' => '999.00',
                'payment_status' => 'unpaid',
                'order_status' => 'handover',
                'payment_method' => 'cash_on_delivery',
                'transaction_reference' => null,
                'coupon_discount_amount' => '0.00',
                'coupon_code' => null,
                'delivery_address_id' => null,
                'delivery_address'=> '{"contact_person_name":"\u041e\u0444\u0444\u043b\u0430\u0439\u043d \u0417\u0430\u043a\u0430\u0437","contact_person_number":"+79290000000","address_type":"home","address":"\u041e\u0444\u0444\u043b\u0430\u0439\u043d \u0417\u0430\u043a\u0430\u0437","floor":null,"road":null,"house":null,"longitude":"43.9553117","latitude":"42.2128383","number":'.$request['number'].'}',
                'restaurant_id'=> Helpers::get_restaurant_id(),
                'restaurant_discount_amount' => 0.00,
                'zone_id'=> 1,
                'pending' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            $o_id = DB::table('orders')->insertGetId($or);

            $or_d = [
                'order_id' => $o_id,
                'food_id' => 1,
                'food_details' => '{"id":1,"name":"\u0421\u0430\u043b\u0430\u0442 \"\u0413\u0440\u0435\u0447\u0435\u0441\u043a\u0438\u0439\"","description":"\u0421\u0430\u043b\u0430\u0442 \"\u0413\u0440\u0435\u0447\u0435\u0441\u043a\u0438\u0439\"\n200 \u0433.\n\u041b\u0438\u0441\u0442 \u0441\u0430\u043b\u0430\u0442\u0430, \u0441\u044b\u0440 \u0424\u0435\u0442\u0430, \u0442\u043e\u043c\u0430\u0442\u044b \u0447\u0435\u0440\u0440\u0438, \u043e\u0433\u0443\u0440\u0435\u0446, \u0441\u043b\u0430\u0434\u043a\u0438\u0439 \u043f\u0435\u0440\u0435\u0446, \u043c\u0430\u0441\u043b\u0438\u043d\u044b, \u043e\u043b\u0438\u0432\u043a\u0438, \u043a\u0440\u0430\u0441\u043d\u044b\u0439 \u043b\u0443\u043a, \u0441\u043f\u0435\u0446\u0438\u0438 \u0441 \u0442\u0440\u0430\u0432\u0430\u043c\u0438, \u043e\u043b\u0438\u0432\u043a\u043e\u0432\u043e\u0435 \u043c\u0430\u0441\u043b\u043e, \u0441\u043e\u043a \u043b\u0438\u043c\u043e\u043d\u0430","image":"2022-06-20-62b05881ebda5.png","category_id":7,"category_ids":[{"id":"7","position":0},{"id":"0","position":1}],"variations":[],"add_ons":[],"attributes":[],"choice_options":[],"price":310,"tax":0,"tax_type":"percent","discount":5,"discount_type":"percent","available_time_starts":"10:00:00","available_time_ends":"23:00:00","veg":0,"status":1,"restaurant_id":1,"created_at":"2022-09-08T12:25:46.000000Z","updated_at":"2022-09-08T12:25:46.000000Z","order_count":0,"avg_rating":0,"rating_count":0,"restaurant_name":"Vincenzo","restaurant_discount":0,"restaurant_opening_time":"10:00","restaurant_closing_time":"23:00","schedule_order":false}',
                'quantity' => 1,
                'price' => 990.00,
                'tax_amount' => 0.00,
                'discount_on_food' => 0.00,
                'discount_type' => 'discount_on_product',
                'variant' => null,
                'variation' => '[]',
                'add_ons' => '[]',
                'created_at' => now(),
                'updated_at' => now()
            ];
            DB::table('order_details')->insert($or_d);

            /*
            $or = Order::where('id', 100001)->get();
            return '-'.Helpers::get_restaurant_id().'-';
            $or = Order::first();
            return Helpers::get_restaurant_id();
            $order = new Order;

            $order->save();*/
            Toastr::success('Курьер скоро прибудет');
            return redirect()->route('vendor.dashboard');

        }

    }

    public function dashboard(Request $request)
    {
       
        $params = [
            'statistics_type' => $request['statistics_type'] ?? 'overall'
        ];
        session()->put('dash_params', $params);

        $data = self::dashboard_order_stats_data();
        $earning = [];
        $commission = [];
        $delivery_earning= [];
        $from = Carbon::now()->startOfYear()->format('Y-m-d');
        $to = Carbon::now()->endOfYear()->format('Y-m-d');
        $restaurant_earnings = OrderTransaction::where(['vendor_id' => Helpers::get_vendor_id()])->select(
            DB::raw('IFNULL(sum(restaurant_amount),0) as earning'),
            DB::raw('IFNULL(sum(admin_commission),0) as commission'),
            DB::raw('IFNULL(sum(delivery_charge),0) as delivery_earning'),
            DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
        )->whereBetween('created_at', [$from, $to])->groupby('year', 'month')->get()->toArray();
        for ($inc = 1; $inc <= 12; $inc++) {
            $earning[$inc] = 0;
            $commission[$inc] = 0;
            $delivery_earning[$inc] = 0;
            foreach ($restaurant_earnings as $match) {
                if ($match['month'] == $inc) {
                    $earning[$inc] = $match['earning'];
                    $commission[$inc] = $match['commission'];
                    $delivery_earning[$inc] = $match['delivery_earning'];
                }
            }
        }


        $top_sell = Food::orderBy("order_count", 'desc')
            ->take(6)
            ->get();
        $most_rated_foods = Food::
        orderBy('rating_count','desc')
        ->take(6)
        ->get();
        $data['top_sell'] = $top_sell;
        $data['most_rated_foods'] = $most_rated_foods;

        return view('vendor-views.dashboard', compact('data', 'earning', 'commission', 'params','delivery_earning'));
    }

    public function restaurant_data()
    {
        $new_pending_order = DB::table('orders')->where(['checked' => 0])->where('restaurant_id', Helpers::get_restaurant_id())->where('order_status','pending');;
        if(config('order_confirmation_model') != 'restaurant' && !Helpers::get_restaurant_data()->self_delivery_system)
        {
            $new_pending_order = $new_pending_order->where('order_type', 'take_away');
        }
        $new_pending_order = $new_pending_order->count();
        $new_confirmed_order = DB::table('orders')->where(['checked' => 0])->where('restaurant_id', Helpers::get_restaurant_id())->whereIn('order_status',['confirmed', 'accepted'])->whereNotNull('confirmed')->count();
        
        $n_order = DB::table('orders')->where(['order_status' => 'pending'])->where('restaurant_id', Helpers::get_restaurant_id())->count();
        //$mess = DB::table('conversations')->where(['receiver_type' => 'vendor'])->where(['receiver_id' => Helpers::get_restaurant_id()])->where('unread_message_count','>','0')->count();

        return response()->json([
            'success' => 1,
            'data' => ['new_pending_order' => $new_pending_order, 'new_confirmed_order' => $new_confirmed_order],
            'pend' => ['pending' => $n_order]
        ]);
    }

    public function order_stats(Request $request)
    {
        $params = session('dash_params');
        foreach ($params as $key => $value) {
            if ($key == 'statistics_type') {
                $params['statistics_type'] = $request['statistics_type'];
            }
        }
        session()->put('dash_params', $params);

        $data = self::dashboard_order_stats_data();
        return response()->json([
            'view' => view('vendor-views.partials._dashboard-order-stats', compact('data'))->render()
        ], 200);
    }

    public function dashboard_order_stats_data()
    {
        $params = session('dash_params');
        $today = $params['statistics_type'] == 'today' ? 1 : 0;
        $this_month = $params['statistics_type'] == 'this_month' ? 1 : 0;

        $confirmed = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->where(['restaurant_id' => Helpers::get_restaurant_id()])->whereIn('order_status',['confirmed', 'accepted'])->whereNotNull('confirmed')->OrderScheduledIn(30)->Notpos()->count();

        $cooking = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->where(['order_status' => 'processing', 'restaurant_id' => Helpers::get_restaurant_id()])->Notpos()->count();

        $ready_for_delivery = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->where(['order_status' => 'handover', 'restaurant_id' => Helpers::get_restaurant_id()])->Notpos()->count();

        $food_on_the_way = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->FoodOnTheWay()->where(['restaurant_id' => Helpers::get_restaurant_id()])->Notpos()->count();

        $delivered = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->where(['order_status' => 'delivered', 'restaurant_id' => Helpers::get_restaurant_id()])->Notpos()->count();

        $refunded = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->where(['order_status' => 'refunded', 'restaurant_id' => Helpers::get_restaurant_id()])->Notpos()->count();

        $scheduled = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->Scheduled()->where(['restaurant_id' => Helpers::get_restaurant_id()])->where(function($query){
            $query->Scheduled()->where(function($q){
                if(config('order_confirmation_model') == 'restaurant' || Helpers::get_restaurant_data()->self_delivery_system)
                {
                    $q->whereNotIn('order_status',['failed','canceled', 'refund_requested', 'refunded']);
                }
                else
                {
                    $q->whereNotIn('order_status',['pending','failed','canceled', 'refund_requested', 'refunded'])->orWhere(function($query){
                        $query->where('order_status','pending')->where('order_type', 'take_away');
                    });
                }
            });

        })->Notpos()->count();

        $all = Order::when($today, function ($query) {
            return $query->whereDate('created_at', Carbon::today());
        })->when($this_month, function ($query) {
            return $query->whereMonth('created_at', Carbon::now());
        })->where(['restaurant_id' => Helpers::get_restaurant_id()])
        ->where(function($query){
            return $query->whereNotIn('order_status',(config('order_confirmation_model') == 'restaurant'|| \App\CentralLogics\Helpers::get_restaurant_data()->self_delivery_system)?['failed','canceled', 'refund_requested', 'refunded']:['pending','failed','canceled', 'refund_requested', 'refunded'])
            ->orWhere(function($query){
                return $query->where('order_status','pending')->where('order_type', 'take_away');
            });
        })
        ->Notpos()->count();

        $data = [
            'confirmed' => $confirmed,
            'cooking' => $cooking,
            'ready_for_delivery' => $ready_for_delivery,
            'food_on_the_way' => $food_on_the_way,
            'delivered' => $delivered,
            'refunded' => $refunded,
            'scheduled' => $scheduled,
            'all' => $all,
        ];

        return $data;
    }

    public function updateDeviceToken(Request $request)
    {
        $vendor = Vendor::find(Helpers::get_vendor_id());
        $vendor->firebase_token =  $request->token;

        $vendor->save();

        return response()->json(['Token successfully stored.']);
    }
}
