<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;

use App\Models\OrderPurchPaymentSenangpay;
use App\Models\Donation;
use App\Models\EventRegister;
use App\Models\User;
use App\Models\UsersInfo;
use App\Models\UserSubscribe;
use App\Models\Event;
use Auth;

class SenangpayController extends Controller
{
    public function index()
    {
        return view('senangpay.payment');
    }

    public function return()
    {
        return view('senangpay.return');
    }

    public function returnRecurring()
    {
        return view('senangpay.return_recurring');
    }

    public function senangpayRegisterEvent($id,$order_id)
    {
        $getUser  = User::where('id', Auth::user()->id)->first();

        $getEvent = Event::where('id', $id)->first();

        $detail = "Otata Event:".$getEvent->event;

        $amount = $getEvent->price;
        
        $detail = str_replace(' ', '_', $detail);

        $order_id = $order_id;
        
        $name = $getUser->name;

        $email = $getUser->email;

        $phone = $getUser->userinfo->hpnum;

        $hash_str = "32145-562".$detail."".$amount."".$order_id;
        $hash=hash_hmac('sha256', $hash_str, '32145-562');
        
        return view('senangpay.payment', compact('detail','amount', 'order_id', 'name', 'email','phone', 'hash'));
    }
    
    public function senangpayDonation($donation,$order_id)
    {
        $getUser  = User::where('id', Auth::user()->id)->first();

        $getDonation = Donation::where('id', $donation)->first();

        $detail = "Otata Donation";

        $amount = $getDonation->cost;
        
        $detail = str_replace(' ', '_', $detail);

        $order_id = $order_id;
        
        $name = $getUser->name;

        $email = $getUser->email;

        $phone = $getUser->userinfo->hpnum;

        $hash_str = "32145-562".$detail."".$amount."".$order_id;
        $hash=hash_hmac('sha256', $hash_str, '32145-562');
        
        return view('senangpay.payment', compact('detail','amount', 'order_id', 'name', 'email','phone', 'hash'));
    }

    public function senangpayRegistration()
    {

        $getUser  = User::where('id', Auth::user()->id)->first();

        $getUserInfo = UsersInfo::where('user_id', $getUser->id)->first();

        $detail = "Membership Registration";

        $amount ='20.00';
        
        $detail = str_replace(' ', '_', $detail);

        $order_id = $getUserInfo->order_id;
        
        $name = $getUser->name;

        $email = $getUser->email;

        $phone = $getUser->userinfo->hpnum;

        $hash_str = "32145-562".$detail."".$amount."".$order_id;
        $hash=hash_hmac('sha256', $hash_str, '32145-562');
        
        return view('senangpay.payment', compact('detail','amount', 'order_id', 'name', 'email','phone', 'hash'));
    }

    public function senangpaySubscription($order_id)
    {
        $getUser  = User::where('id', Auth::user()->id)->first();

        //$recurring_id = "163763734065";
        $recurring_id = "163912343293";

        $detail = "Otata Monthly Subscription";
        
        $detail = str_replace(' ', '_', $detail);

        $order_id = $order_id;
        
        $name = $getUser->name;

        $email = $getUser->email;

        $phone = $getUser->userinfo->hpnum;

        $hash_str = "32145-562".$recurring_id."".$order_id;
        $hash=hash('sha256', $hash_str);
        
        return view('senangpay.recurring', compact('detail','recurring_id', 'order_id', 'name', 'email','phone', 'hash'));
    }
//----------------------------------------------------------------- API ---------------------------------------------------------------------------------------------

    public function updateSenangpay(Request $request){
        try{

            $getSenangpay = OrderPurchPaymentSenangpay::where('order_id',$request->order_id)->first();

            $getSenangpay->transaction_id   = $request->transaction_id;
            $getSenangpay->status           = $request->status;
            if($getSenangpay->status == 1){
                $getSenangpay->state          = 'success';
            }else if($getSenangpay->status == 0){
                $getSenangpay->state          = 'failed';
            }
            $getSenangpay->save();

            //dd($request->order_id);
            if($request->status == 1){
                if($getSenangpay->type == "event"){

                    $getEvent = EventRegister::where('order_id',$request->order_id)->first();
                    $getEvent->status = 'success';
                    $url = "member/event/list";
                    $status = "Event Succesfully Register";
                    $getEvent->save();

                }else if($getSenangpay->type == "donation"){

                    $getEvent = Donation::where('order_id',$request->order_id)->first();
                    $getEvent->status = 'success';
                    $url = "member/donation";
                    $status = "Donation Success";
                    $getEvent->save();

                }
                return redirect($url)->with('message', $status);
            }else if($request->status == 1){
                if($getSenangpay->type == "event"){

                    $getEvent = EventRegister::where('order_id',$request->order_id)->first();
                    $getEvent->status = 'failed';
                    $url = "member/event/list";
                    $status = "Event Succesfully Failed. Please Try Again or call us";
                    $getEvent->save();

                }else if($getSenangpay->type == "donation"){

                    $getEvent = Donation::where('order_id',$request->order_id)->first();
                    $getEvent->status = 'failed';
                    $url = "member/donation";
                    $status = "Donation Failed. Please try again or call us.";
                    $getEvent->save();

                }
                return redirect($url)->withErrors(['msg' => $status]);;
            }

            $object['senangpay'] = $request->status;

            // return response()->json([
            //     "status"  => true,
            //     "message" => "success",
            //     "object"  => $object
            // ]);
        } catch (Exception $exception){
            return response()->json([
                "status"  => false,
                "message" => "error"
            ]);
        }
    }

    public function updateRecurringSenangpay(Request $request){
        try{
            
            $getSenangpay = OrderPurchPaymentSenangpay::where('order_id',$request->order_id)->first();

            $getSenangpay->transaction_id   = $request->transaction_id;
            $getSenangpay->status           = $request->status;
            if($getSenangpay->status == 1){
                $getSenangpay->state          = 'success';
            }else if($getSenangpay->status == 0){
                $getSenangpay->state          = 'failed';
            }
            $getSenangpay->save();
            
            $message = $request->msg;
            $url     = route('member.subscription');

            $valid_start = date("Y-m-d H:i:s");
            $valid_start = strtotime($valid_start);
            $valid_end = date('Y-m-d H:i:s', strtotime('+1 month', $valid_start));

            if($getSenangpay->status == 1){
                $getUserSubscribe = UserSubscribe::where('order_id',$request->order_id)->first();
                $getUserSubscribe->valid_start   = $valid_start;
                $getUserSubscribe->valid_end     = $valid_end;
                $getUserSubscribe->status        = 'active';
                $status = "You Have Succesfully Subscribe";
                $getUserSubscribe->save();
                return redirect($url)->with('message', $status);
            }else if($getSenangpay->status == 0){
                $getUserSubscribe = UserSubscribe::where('order_id',$request->order_id)->first();
                $getUserSubscribe->status        = 'not active';
                $getUserSubscribe->save();

                return redirect($url)->withErrors(['msg' => $message]);;
            }

            return response()->json([
                "status"  => true,
                "message" => "success",
                "object"  => $object
            ]);
        } catch (Exception $exception){
            return response()->json([
                "status"  => false,
                "message" => "error"
            ]);
        }
    }

}

