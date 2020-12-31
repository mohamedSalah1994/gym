<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\booking;
use App\subscriptions;
use App\User;
use App\plans;
use App\posts;
use App\categories;
use App\payments;
use App\settings;
use App\Freezed;
use Validator;
use Hash;
use Mail;
use App\contact;
use App\Mail\contactUs;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
class main extends Controller
{
    private $numOfUsers = 2;
    private $sessionHours = 2;
    private $gymStart = '10 am';
    private $gymEnd = 12;
    public function __construct(){
        $this->numOfUsers = $this->setting('numOfUsers');
        $this->sessionHours = $this->setting('sessionHours');
        $this->gymStart = $this->setting('gym_start');
        $this->gymEnd = $this->setting('no_of_hours_gym_works');
    }
    public function subsc(){
    //   $su =  booking::whereDate('day','2020-09-03')->where('from' ,'>=','2020-09-03 23:59:59')->where('to','>=','2020-09-03 02:00:00')->get();
    //   $booking = [];
    //   foreach($su as $book){
    //       $booking[] = array($book->User->name,$book->User->mobile,$book->User->identity,$book->day,Carbon::parse($book->from)->format('h:i a'),Carbon::parse($book->to)->format('h:i a'));
    //   }
     $su =  booking::whereDate('day','2020-09-04')->where('from' ,'<','2020-09-04 14:00:00')->where('to','<','2020-09-04 16:00:00')->get();
       $booking = [];
       foreach($su as $book){
           $booking[] = array($book->User->name,$book->User->mobile,$book->User->identity,$book->day,Carbon::parse($book->from)->format('h:i a'),Carbon::parse($book->to)->format('h:i a'));
       }
        return (Array) $booking;
    }
    function setting($key)
    {
        $setting = settings::where('key',$key)->firstOrFail();

        return $setting->value;
    }
    public function login(Request $request){
        $messages = [
            'identity.required' => __('auth.identityRequired'),
            'identity.exists' => __('auth.identityShouldExists'),
            'password.required' => __('auth.passwordRequired'),
            'password.min' => __('auth.passwordMin'),
            
        ];
        $validator = Validator::make($request->all(),[
            'identity' => 'required|exists:users,identity',
            'password' => 'required'
        ],$messages);
        if($validator->fails()){
            return response()->json(['status' => 'failed','errors'=>$validator->errors()->all()],200);
        }else{
           $checkUser = User::where('identity',$request->identity)->first();
            if($checkUser){
                 if(Hash::check($request->password,$checkUser->password)){
                     auth()->guard('user')->login($checkUser);
                    return response()->json(['status' => 'done','message'=> __('auth.successedSignin')],200);
                    }else{
                        return response()->json(['status' => 'failed','errors'=>[__('auth.passwordNotCorrect')]],200);
                    }
            }else{
                return response()->json(['status' => 'failed','errors'=>[__('auth.usernotfound')]],200);
            }
           
        }
    }
    public function signup(Request $request){
        $request['birthgt18'] = Carbon::now()->diffInYears(Carbon::parse($request->birth));
        $messages = [
            'name.required' => __('auth.nameRequired'),
            'email.required' => __('auth.emailRequired'),
            'email.email' => __('auth.emailShouldEmail'),
            'email.unique' => __('auth.emailUnique'),
            'password.required' => __('auth.passwordRequired'),
            'password.min' => __('auth.passwordMin'),
            'identity.required' => __('auth.identityRequired'),
            'identity.unique' => __('auth.identityUnique'),
            'country.required' => __('auth.countryRequired'),
            'mobile.required' => __('auth.mobileRequired'),
            'mobile.unique' => __('auth.mobileUnique'),
            'password.required' => __('auth.passwordRequired'),
            'password.min' => __('auth.passwordMin'),
            'birth.required' => __('auth.birth_required'),
            'birth.date_format' => __('auth.birth_date_format'),
            'birthgt18.gt' => __('auth.birthgt18_gt'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'password' => 'required|min:8',
            'identity' => 'required|unique:users,identity',
            'mobile' => 'required|unique:users,mobile',
            'birth' => 'required|date_format:Y-m-d',
            'birthgt18' => 'gt:18',
        ],$messages);
        if($validator->fails()){
            return response()->json(['status' => 'failed','errors'=>$validator->errors()->all()],200);
        }else{
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->identity = $request->identity;
            $newUser->mobile = $request->mobile;
            $newUser->email = $request->email;
            $newUser->birth = $request->birth;
            $newUser->password = Hash::make($request->password);
            $newUser->save();
            auth()->guard('user')->login($newUser);
            if(auth()->guard('user')->check()){
                return response()->json(['status' => 'done','message'=> __('auth.successedSignup')],200);
            }
        }
    }
    public function logout(){
        auth()->guard('user')->logout();
        return redirect('/');
    }
    public function timeslots(Request $request){
        $date = Carbon::parse($request->day)->format('Y-m-d');
        $start = Carbon::parse($date .' '.$this->gymStart)->addHours($this->gymEnd);
        $workhours = Carbon::parse($date .' '.$this->gymStart)->diffInHours($start);
        $allowedTimeSlots = $workhours / 2;
        $day_slots = [];
        
        array_push($day_slots,Carbon::parse($date .' '.$this->gymStart));
        for($i = 1 ; $i < $allowedTimeSlots ; $i++){
            array_push($day_slots,Carbon::parse($date .' '.$this->gymStart)->addHours($i * $this->sessionHours));
        }
        $available = [];
        foreach($day_slots as $slot){
            $start_slot = $slot->format('Y-m-d H:i:s');
            $end_slot = $slot->addHours($this->sessionHours)->format('Y-m-d H:i:s');
            if(Carbon::parse($request->day)->format('l') == 'Thursday'){
                  if(Carbon::parse($start_slot)->format('H:i') == '00:00' && Carbon::parse($end_slot)->format('H:i') == '02:00'){
                      break;
                  }
            
        }else if(Carbon::parse($request->day)->format('l') == 'Friday'){
            if((Carbon::parse($start_slot)->format('H:i') ==  Carbon::parse('04:00')->format('H:i') && Carbon::parse($end_slot)->format('H:i') == Carbon::parse('06:00')->format('H:i')) || (Carbon::parse($start_slot)->format('H:i') ==  Carbon::parse('06:00')->format('H:i') && Carbon::parse($end_slot)->format('H:i') == Carbon::parse('08:00')->format('H:i')) || (Carbon::parse($start_slot)->format('H:i') ==  Carbon::parse('08:00')->format('H:i') && Carbon::parse($end_slot)->format('H:i') == Carbon::parse('10:00')->format('H:i')) || (Carbon::parse($start_slot)->format('H:i') ==  Carbon::parse('10:00')->format('H:i') && Carbon::parse($end_slot)->format('H:i') == Carbon::parse('12:00')->format('H:i')) || (Carbon::parse($start_slot)->format('H:i') ==  Carbon::parse('12:00')->format('H:i') && Carbon::parse($end_slot)->format('H:i') == Carbon::parse('14:00')->format('H:i'))){
                 continue;
            }
            
        }
         $count_booking = booking::where('day',Carbon::parse($request->day))->where('from',$start_slot)->where('to',$end_slot)->count();
            $check_booked = booking::where('user',auth()->guard('user')->user()->id)->where('day',Carbon::parse($request->day))->where('from',$start_slot)->where('to',$end_slot)->count();
            $finalslot = ['from' => $start_slot , 'to' => $end_slot , 'available' => $this->numOfUsers - $count_booking , 'day' => $date , 'booked' => $check_booked , 'fr' => Carbon::parse($end_slot)->addHours(20)->format('H:i')];
            array_push($available,$finalslot);
          
        }
        return response()->json(['available' => $available , 'bookBtnText' => __('booking.booknowBtn') ,'cancelBtnText' => __('booking.cancelnowBtn')],200);
    }
    public function canceltimeslot(Request $request){
        $check_booked = booking::where('user',auth()->guard('user')->user()->id)->where('day',Carbon::parse($request->day))->where('from',Carbon::parse($request->from))->where('to',Carbon::parse($request->to))->first();
        if($check_booked){
            $check_booked->delete();
            $count_booking = booking::where('day',Carbon::parse($request->day))->where('from',Carbon::parse($request->from))->where('to',Carbon::parse($request->to))->count();
             return response()->json(['available' => $this->numOfUsers - $count_booking , 'bookBtnText' => __('booking.booknowBtn') ,'cancelBtnText' => __('booking.cancelnowBtn') , 'status' => 'done'],200);
        }
       
    }
    
    public function cancelBook(Request $request){
         $messages = [
        
            
        ];
        $validator = Validator::make($request->all(),[
            'booking' => ['required','exists:bookings,id',function ($attribute, $value, $fail) {
                $checkBooking = booking::where('user',auth()->guard('user')->id())->where('id',$value)->first();
            if (!$checkBooking) {
                $fail(__('profile.sorry'));
            }
        }],
     
        ],$messages);
        if($validator->fails()){
            return response()->json(['status' => 'failed','errors'=>$validator->errors()->all()],200);
        }else{
            $checkBooking = booking::where('user',auth()->guard('user')->id())->where('id',$request->booking)->first();
            if($checkBooking){
                $checkBooking->status = 2;
                $checkBooking->save();
                return response()->json(['status' => 'done','text'=> __('profile.bookcancelled')],200);
            }
        }
    }
    public function booktimeslot(Request $request){
        $day = $request->day;
        $from = $request->from;
        $to = $request->to;
        $count_booking = booking::where('day',Carbon::parse($day))->where('from',$from)->where('to',$to)->count();
        $check_user_booking = booking::where('user',auth()->guard('user')->id())->where('day',Carbon::parse($day))->count();
        if($check_user_booking > 0){
            return response()->json(['status' => 'failed' , 'message' => __('booking.existBooking') , 'closebtn' => __('main.CLOSE')],200);
        }
        else if(auth()->guard('user')->user()->FreezedObj){
            return response()->json(['status' => 'failed' , 'message' => __('booking.accountFreezedMessage') , 'closebtn' => __('main.CLOSE')],200);
        }
        else if(!auth()->guard('user')->user()->subscriptionOb){
            return response()->json(['status' => 'failed' , 'message' => __('booking.notHaveSubscription') , 'closebtn' => __('main.CLOSE')],200);
        }
        else if(auth()->guard('user')->user()->subscriptionOb && Carbon::parse(auth()->guard('user')->user()->subscriptionOb->end_to) < Carbon::now()){
             return response()->json(['status' => 'failed' , 'message' => __('booking.currentSubscriptionIsinvalide') , 'closebtn' => __('main.CLOSE')],200);
        }else if(Carbon::parse($day) > Carbon::parse(auth()->guard('user')->user()->subscriptionOb->end_to)){
             return response()->json(['status' => 'failed' , 'message' => __('booking.outOfYourPlan') , 'closebtn' => __('main.CLOSE')],200);
        }
        else if(Carbon::parse($from)->format('Y-m-d H:i:s') < Carbon::now()->format('Y-m-d H:i:s') && Carbon::parse($to)->format('Y-m-d H:i:s') < Carbon::now()->format('Y-m-d H:i:s')){
             return response()->json(['status' => 'failed' , 'message' => __('booking.thistimenotavailable') , 'closebtn' => __('main.CLOSE') , 'ff' => Carbon::now()->format('Y-m-d H:i:s')],200);
        }
        else if($count_booking < $this->numOfUsers){
            $newbooking = new booking();
            $newbooking->day = $day;
            $newbooking->from = $from;
            $newbooking->to = $to;
            $newbooking->user = auth()->guard('user')->id();
            $newbooking->save();
            return response()->json(['status' => 'done' , 'message' => __('booking.bookingDone') , 'cancelBtnText' => __('booking.cancelnowBtn') , 'booked' => 1 , 'closebtn' => __('main.CLOSE')],200);
        }
        else if($count_booking == $this->numOfUsers){
            return response()->json(['status' => 'failed' , 'message' => __('booking.notavailableSlot') , 'closebtn' => __('main.CLOSE')],200);
        }
         
    }
    public function subscribe(Request $request){
        if(!auth()->guard('user')->check()){
             return response()->json(['status' => 'failed','errors'=>[__('auth.loginRequired')]],200);
        }else{
             $messages = [
            'plan.required' => __('main.planRequired'),
            'plan.exists' => __('main.planexists'),
            
        ];
        $validator = Validator::make($request->all(),[
            'plan' => 'required|exists:plans,id',
        ],$messages);
        if($validator->fails()){
             return response()->json(['status' => 'failed','errors'=>$validator->errors()->all()],200);
        }else{
                    $plan = plans::find($request->plan);
                    $res = $this->initialPayment($plan->id); 
                    if($res){
                        $newPaymentInitial = new payments();
                        $newPaymentInitial->invoicenumber = $res['invoice_number'];
                        $newPaymentInitial->invoiceid = $res['id'];
                        $newPaymentInitial->user = auth()->guard('user')->id();
                        $newPaymentInitial->plan = $plan->id;
                        $newPaymentInitial->status = $res['status'];
                        $newPaymentInitial->amount = $res['amount'];
                        $newPaymentInitial->currency = $res['currency'];
                        $newPaymentInitial->save();
                        if($newPaymentInitial){
                             return response()->json(['status' => 'done','message'=> $res['url']],200);
                        }
                    }

        }
     }
    }
    protected function initialPayment($plan){
            $planbyid = plans::find($plan);
            $plansPrice  = $planbyid->price;
            $desc = $planbyid->name;
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.tap.company/v2/invoices",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS =>'{
              "draft": false,
              "due": 1604728943000,
              "expiry": 1604728943000,
              "description": "'.$desc.'",
              "mode": "INVOICE",
              "note": "'.$desc.'",
              "notifications": {
                "channels": [
                  "SMS",
                  "EMAIL"
                ],
                "dispatch": true
              },
              "currencies": [
                "KWD"
              ],
              "metadata": {
                "plan_id": "'.$plan.'",
                "user" : "'.auth()->guard('user')->user()->identity.'"
              },
              "charge": {
                "receipt": {
                  "email": true,
                  "sms": false
                },
                "statement_descriptor": "test"
              },
              "customer": {
                "email" : "info@powergym-kw.com",
                "first_name": "'.auth()->guard('user')->user()->name.'"
              },
              "order": {
                "amount": "'.$plansPrice.'",
                "currency": "KWD",
                "items": [
                  {
                    "amount": "'.$plansPrice.'",
                    "currency": "KWD",
                    "description": "test",
                    "image": "",
                    "name": "'.$desc.'",
                    "quantity": 1
                  }
                ]
              },
              "payment_methods": [
                ""
              ],
              "post": {
                "url": "http://your_website.com/post_url"
              },
              "redirect": {
                "url": "'.url('/verifyPayment').'"
              },
              "reference": {
                "invoice": "INV_00001",
                "order": "ORD_00001"
              }
            }',
              CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . env('TAP_KEY'),
                "content-type: application/json"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {

               $json = json_decode($response, true); 
                return $json;

            }
    }
    public function verifyPayment(Request $request){
         if(!auth()->guard('user')->check()){
             return response()->json(['status' => 'failed','errors'=>[__('auth.loginRequired')]],200);
        }else{
             $messages = [
            'tap_id.required' => __('booking.tap_idRequired'),
            'tap_id.exists' => __('booking.tap_idexists'),
            
        ];
        $validator = Validator::make($request->all(),[
            'tap_id' => 'required|exists:payments,invoiceid',
        ],$messages);
        if($validator->fails()){
             return response()->json(['status' => 'failed','errors'=>$validator->errors()->all()],200);
        }
             $res =  $this->verifyInvoice($request->tap_id);
             $updateinvoice = payments::where('invoiceid' , $request->tap_id)->first();
             if($res && $res['status'] == 'PAID' && $updateinvoice && $updateinvoice->status != 'PAID'){
                $updateinvoice->status = $res['status'];
                $updateinvoice->save();
                if($updateinvoice){
                    $plan = plans::find($updateinvoice->plan);
                    if(!$updateinvoice->userObj->subscriptionOb){
                            $newsubscription = new subscriptions();
                            $newsubscription->user = $updateinvoice->userObj->id;
                            $newsubscription->main_price = $plan->price;
                            $newsubscription->main_days = $plan->days;
                            $newsubscription->plan = $plan->id;
                            $newsubscription->start_from = Carbon::now();
                            $newsubscription->end_to = Carbon::now()->addDays($plan->days);
                            $newsubscription->save();
                    }
                    else if($updateinvoice->userObj->subscriptionOb && Carbon::parse($updateinvoice->userObj->subscriptionOb->end_to) < Carbon::now()){
                         if($updateinvoice->userObj->FreezedObj){
                             $updateinvoice->userObj->FreezedObj->remaining = $updateinvoice->userObj->FreezedObj->remaining + $plan->days;
                             $updateinvoice->userObj->FreezedObj->save();
                         }
                         $updateinvoice->userObj->subscriptionOb->plan = $plan->id;
                         $updateinvoice->userObj->subscriptionOb->start_from = Carbon::now();
                         $updateinvoice->userObj->subscriptionOb->end_to = Carbon::now()->addDays($plan->days);
                         $updateinvoice->userObj->subscriptionOb->save();
                    }
                    else if($updateinvoice->userObj->subscriptionOb && Carbon::parse($updateinvoice->userObj->subscriptionOb->end_to) > Carbon::now()){
                          if($updateinvoice->userObj->FreezedObj){
                                 $updateinvoice->userObj->FreezedObj->remaining = $updateinvoice->userObj->FreezedObj->remaining + $plan->days;
                                 $updateinvoice->userObj->FreezedObj->save();
                          }
                          $updateinvoice->userObj->subscriptionOb->plan = $plan->id;
                          $updateinvoice->userObj->subscriptionOb->end_to = Carbon::parse($updateinvoice->userObj->subscriptionOb->end_to)->addDays($plan->days);
                          $updateinvoice->userObj->subscriptionOb->save();
                    }
                   
                }
                return redirect('/profile')->with('invoice',$updateinvoice->invoicenumber); 
            } 
            
      
    }
    }
    protected function verifyInvoice($invoice){
         $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.tap.company/v2/invoices/".$invoice,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "{}",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer " . env('TAP_KEY')
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
             $json = json_decode($response, true); 
            return $json;
        }
    }
    public function profile(){
        return view('profilePersonal');
    }
    public function profilePassword(){
        return view('profilePassword');
    }
    
    public function profileUpdate(Request $request){
           $messages = [
            'name.required' => __('auth.nameRequired'),
            'email.required' => __('auth.emailRequired'),
            'email.email' => __('auth.emailShouldEmail'),
            'email.unique' => __('auth.emailUnique'),
            'identity.required' => __('auth.identityRequired'),
            'identity.unique' => __('auth.identityUnique'),
            'country.required' => __('auth.countryRequired'),
            'mobile.required' => __('auth.mobileRequired'),
            'mobile.unique' => __('auth.mobileUnique'),
            'birth.required' => __('auth.birth_required'),
            'birth.date_format' => __('auth.birth_date_format'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'identity' => 'required|unique:users,identity,' . auth()->guard('user')->id(),
            'mobile' => 'required|unique:users,mobile,' . auth()->guard('user')->id(),
             'birth' => 'required|date_format:Y-m-d',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            auth()->guard('user')->user()->name  = $request->name;
            auth()->guard('user')->user()->identity  = $request->identity;
            auth()->guard('user')->user()->mobile  = $request->mobile;
            auth()->guard('user')->user()->birth  = $request->birth;
            auth()->guard('user')->user()->save();
            return back()->with('message',__('profile.personalDataChengedSuccess'));
        }
        
    }
     public function profilePasswordUpdate(Request $request){
            $messages = [
                'confirm.same' => __('auth.newpasswordnotsame'),
                'current.min' => __('auth.currentpasswordmin'),
                'new.min' => __('auth.newpasswordmin'),
                'confirm.min' => __('auth.confirmpasswordmin'),
            
        ];
        $validator = Validator::make($request->all(),[
            'current' => ['required','min:8',function ($attribute, $value, $fail) {
            if (!Hash::check($value,auth()->guard('user')->user()->password)) {
                $fail(__('auth.currentPasswordNotCorrect'));
            }
        }],
            'new' => 'required|min:8',
            'confirm' => 'required|same:new|min:8',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            auth()->guard('user')->user()->password  = Hash::make($request->confirm);
            auth()->guard('user')->user()->save();
            return back()->with('message',__('profile.passwordChengedSuccess'));
        }
     }
    public function profileSubscription(){
        return view('profileSubscriptions');
    }
    public function profileStatus(){
        return view('profileStatus');
    }
    public function profilePayments(){
        return view('profileLastPayments');
    }
     public function profilebookings(){
        return view('profileBookings');
    }
    
    
    public function profileFreeze(){
        $userSubscription = auth()->guard('user')->user()->subscriptionOb;
        if($userSubscription){
            $parseEndTo = Carbon::parse($userSubscription->end_to);
            $now = Carbon::now();
            $diff = $parseEndTo->diffInDays($now);
                if(auth()->guard('user')->user()->FreezedObj){
                  if($parseEndTo > $now){
                    $freezeStartAt = Carbon::parse(auth()->guard('user')->user()->FreezedObj->created_at);
                    $freezedDays = $now->diffInDays($freezeStartAt);
                    auth()->guard('user')->user()->subscriptionOb->start_from = Carbon::parse(auth()->guard('user')->user()->subscriptionOb->start_from)->addDays($freezedDays);
                    auth()->guard('user')->user()->subscriptionOb->end_to = Carbon::parse(auth()->guard('user')->user()->subscriptionOb->end_to)->addDays($freezedDays);
                    auth()->guard('user')->user()->subscriptionOb->save();
                    auth()->guard('user')->user()->FreezedObj->delete();
                        return back()->with('message',__('profile.accountUnFreezed'));
                  }else{
                    auth()->guard('user')->user()->subscriptionOb->start_from = Carbon::now();
                    auth()->guard('user')->user()->subscriptionOb->end_to = Carbon::now()->addDays(auth()->guard('user')->user()->FreezedObj->remaining);
                    auth()->guard('user')->user()->subscriptionOb->save();
                    auth()->guard('user')->user()->FreezedObj->delete();
                        return back()->with('message',__('profile.accountUnFreezed'));
                  }
                }else{
                    $userSubscription = auth()->guard('user')->user()->subscriptionOb->end_to;
                    $newFreezed = new Freezed();
                    $newFreezed->user = auth()->guard('user')->id();
                    $newFreezed->remaining = $diff;
                    $newFreezed->save();
                     return back()->with('message',__('profile.accountFreezed'));
                }
        }
       
        
    }
    public function post($slug){
        $post = posts::where('slug',$slug)->firstOrFail();
        return view('post',compact('post'));
    }
    public function category($slug){
        $category = categories::where('slug',$slug)->firstOrFail();
        return view('category',compact('category'));
    }
     public function blog(){
        $posts = posts::orderBy('id','DESC')->get()->take(10);
        return view('blog',compact('posts'));
    }
    public function contactSend(Request $request){
             $messages = [
            'name.required' => __('main.contact_name_required'),
            'name.string' => __('main.contact_name_string'),
            'email.required' => __('main.contact_email_required'),
            'email.email' => __('main.contact_email_email'),
            'message.required' => __('main.contact_message_required'),
            'message.string' => __('main.contact_message_string'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $email = contact::where('key','email')->firstOrFail()->value;
        $title = settings::where('key','site_title')->firstOrFail()->value;
       try{
            Mail::to($email)->send(new contactUs(['name' => $request->name , 'email' => $request->email , 'message' => $request->message , 'title' => $title]));
            return back()->with('message',__('main.messageMailSent'));
       }
        catch(\Exception $e){
            return $e;
        }
    }
    public function import(){
        return view('import');
    }
    
    public function saveimport(Request $request)
    {
        set_time_limit(0);
        $data = Excel::toArray(new UsersImport,request()->file('file'));
        array_shift($data[0]);
        foreach($data[0] as $key=>$x){
                $newsubscription = new subscriptions();
                $newsubscription->user = $key+1;
                $newsubscription->main_price = 0;
                $newsubscription->main_days = 0;
                $newsubscription->plan = 1;
                $newsubscription->start_from = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($x[5]));
                $newsubscription->end_to = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($x[6]));
                $newsubscription->save();
     
//            $newuser = new User();
//            $newuser->name = $x[0];
//            $newuser->identity = $x[1];
//            $newuser->mobile = $x[2];
//            $newuser->password = Hash::make($x[2]);
//            $newuser->birth = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($x[3]));
//            $newuser->created_at = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($x[4]));
//            $newuser->save();
        }
      
    }
    
}
