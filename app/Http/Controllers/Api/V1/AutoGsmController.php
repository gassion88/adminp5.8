<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\DeliveryMan;
use App\Models\UserInfo;
use App\Models\Message;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Gsm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AutoGsmController extends Controller
{

    public function sms_port(Request $request)
    {
        $data = Gsm::all();





        return response()->json($data, 200);
    }

    public function status(Request $request)
    {
        $data = Gsm::find($request['id']);
        $data->status = $request['status'];
        $data->save();

        return response()->json('OK', 200);
    }
}
