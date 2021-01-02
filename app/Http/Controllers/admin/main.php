<?php

namespace App\Http\Controllers\admin;
use App\payments;
use App\booking;
use App\User;
use App\plans;
use App\subscriptions;
use App\tags;
use App\categories;
use App\posts;
use App\settings;
use App\post_categories;
use App\post_tags;
use App\contact;
use App\trainers;
use App\slider;
use App\gallery;
use App\gallery_categories;
use App\customersComments;
use App\roles;
use App\permissions;
use App\role_permissions;
use App\Admin;
use App\user_role;
use App\home_second;
use App\services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;
use Hash;
use DB;
use App\Exports\UsersExport;
use App\Exports\PaymentsExport;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\subscriptions as subscriptionsResource;
use App\Http\Resources\payments as paymentsResource;
use App\Http\Resources\bookings as bookingsResource;
use PDF;
class main extends Controller
{
    private $numOfUsers = 2;
    private $sessionHours = 2;
    private $gymStart = '10 am';
    private $gymEnd = 12;
    private $siteTitle = '';
    private $sitedesc = '';
    public function __construct(){
        $this->numOfUsers = $this->setting('numOfUsers');
        $this->sessionHours = $this->setting('sessionHours');
        $this->gymStart = $this->setting('gym_start');
        $this->gymEnd = $this->setting('no_of_hours_gym_works');
        $this->siteTitle = $this->setting('site_title');
        $this->sitedesc = $this->setting('sitedesc');
    }
    function setting($key)
    {
        $setting = settings::where('key',$key)->firstOrFail();

        return $setting->value;
    }
    public function printpayment($id){
         $payment = payments::find($id);
        if(!$payment){return abort(404);}
        $pdf = PDF::loadView('pdf.payment', compact('payment'));
	    return $pdf->download($payment->userObj->name . '.pdf');
    }
    public function login(){
        return view('admin.login');
    }
    public function deleteUser($id){
        $user = User::find($id);
        if(!$user){return abort(404);}
        $user->delete();
        return back()->with('message',__('admin.successedRemovedUser'));
    }
    public function profile(){
        $totalpaid = payments::where('status','PAID')->sum('amount');
        $totalpaidcount = payments::where('status','PAID')->count();
        $totalpayment = payments::all()->count();
        $Userscount = User::all()->count();
        $totalbookingscount = booking::all()->count();
        $newbookingscount = booking::where('day',carbon::today())->count();
        $subscriptionsCount = subscriptions::where('end_to','>',Carbon::now())->count();
        return view('admin.home',compact('totalpaid','totalpayment','totalpaidcount','Userscount','subscriptionsCount','newbookingscount','totalbookingscount'));
    }
    public function users(){
        $allUsers = User::all();
        return view('admin.users',compact('allUsers'));
    }
     public function addusers(){
        $allUsers = User::all();
        return view('admin.addusers',compact('allUsers'));
    }
      public function subscriptions(Request $request){
          if($request->ajax()){
              if($request->datatable['pagination']['page'] != null){
                  $page = $request->datatable['pagination']['page'];
              }else{
                  $page = 1;
              }
              if($request->datatable['pagination']['perpage'] != null){
                  $perpage = $request->datatable['pagination']['perpage'];
              }else{
                  $perpage = 50;
              }
               if($request->datatable['query']['generalSearch'] != null){
                  $search = $request->datatable['query']['generalSearch'];
                  $allSubscriptions = subscriptions::with('User')->whereHas('User' , function ($query) use ($search) {
                       $query->where('mobile',$search)
                             ->orWhere('identity',$search)
                             ->orWhere('name','like','%'.$search.'%')
                             ->orWhere('email',$search);
                    })->orderBy('id','desc')->paginate($perpage, ['*'], 'page', $page);
                  return response()->json(new subscriptionsResource($allSubscriptions),200);
              }
               $allSubscriptions = subscriptions::with('User')->orderBy('id','desc')->paginate($perpage, ['*'], 'page', $page);
               return response()->json(new subscriptionsResource($allSubscriptions),200);
             
          }
        return view('admin.subscriptions');
    }
     public function addsubscriptions(){
        $allUsers = subscriptions::all();
        $allplans = plans::where('status','1')->get();
        return view('admin.addsubscriptions',compact('allUsers','allplans'));
    }
    public function usersearch(Request $request){
        $result = User::where('name', 'LIKE', "%{$request->q}%")->orWhere('email', 'LIKE', "%{$request->q}%")->orWhere('mobile', 'LIKE', "%{$request->q}%")->orWhere('identity', 'LIKE', "%{$request->q}%")->get();
        return response()->json($result,200);
    }
     public function categories(){
         $categories = categories::all();
        return view('admin.categories',compact('categories'));
    }
     public function tags(){
         $tags = tags::all();
        return view('admin.tags',compact('tags'));
    }
      public function posts(){
          $allposts = posts::all();
        return view('admin.posts',compact('allposts'));
    }
    
      public function addPost(){
          $tags = tags::all();
          $categories = categories::all();
        return view('admin.addpost',compact('categories','tags'));
    }
     public function settings(){
         $site_title = $this->siteTitle;
         $numOfUsers = $this->numOfUsers;
         $sessionHours = $this->sessionHours;
         $gymStart = $this->gymStart;
         $gymEnd = $this->gymEnd;
         $sitedesc = $this->sitedesc;
        return view('admin.settings',compact('site_title','numOfUsers','sessionHours','gymStart','gymEnd','sitedesc'));
    }
    public function settingsUpdate(Request $request){
         $messages = [
          'title.required' => __('admin.site_title_required'),
          'number_of_users_in_slot.required' => __('admin.number_of_users_in_slot_required'),
          'number_of_users_in_slot.number' => __('admin.number_of_users_in_slot_number'),
          'number_of_hours_in_slot.required' => __('admin.number_of_hours_in_slot_required'),
          'number_of_hours_in_slot.number' => __('admin.number_of_hours_in_slot_number'),
          'work_start_at.required' => __('admin.work_start_at_required'),
          'number_of_work_hours.required' => __('admin.number_of_work_hours_required'),
          'number_of_work_hours.number' => __('admin.number_of_work_hours_number'),
          'desc.required' => __('admin.desc_required'),
          'desc.string' => __('admin.desc_string'),
          'desc.max' => __('admin.desc_max'),
            
        ];
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'number_of_users_in_slot' => 'required|numeric',
            'number_of_hours_in_slot' => 'required|numeric',
            'work_start_at' => 'required',
            'number_of_work_hours' => 'required|numeric',
            'desc' => 'required|string|max:350',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        else{
            $setting_title = settings::where('key','site_title')->firstOrFail();
            $setting_title->value = $request->title;
            $setting_title->save();
            $setting_number_of_users_in_slot = settings::where('key','numOfUsers')->firstOrFail();
            $setting_number_of_users_in_slot->value = $request->number_of_users_in_slot;
            $setting_number_of_users_in_slot->save();
            $setting_number_of_hours_in_slot = settings::where('key','sessionHours')->firstOrFail();
            $setting_number_of_hours_in_slot->value = $request->number_of_hours_in_slot;
            $setting_number_of_hours_in_slot->save();
            $setting_work_start_at = settings::where('key','gym_start')->firstOrFail();
            $setting_work_start_at->value = $request->work_start_at;
            $setting_work_start_at->save();
            $setting_number_of_work_hours = settings::where('key','no_of_hours_gym_works')->firstOrFail();
            $setting_number_of_work_hours->value = $request->number_of_work_hours;
            $setting_number_of_work_hours->save();
            $setting_sitedesc = settings::where('key','sitedesc')->firstOrFail();
            $setting_sitedesc->value = $request->desc;
            $setting_sitedesc->save();
            
            return back()->with('message',__('admin.successedSavedData'));
        }
    }
    public function insertPost(Request $request){
          $messages = [
           'title.required' => __('admin.post_title_required'),
           'title.string' => __('admin.post_title_string'),
           'cats.required' => __('admin.post_cats_required'),
           'cats.array' => __('admin.post_cats_array'),
           'cats.exists' => __('admin.post_cats_array'),
           'tags.array' => __('admin.post_tags_array'),
           'tags.exists' => __('admin.post_tags_array'),
           'image.required' => __('admin.image_required'),
           'image.file' => __('admin.image_file'),
           'image.mimes' => __('admin.image_mimes'),
           'image.max' => __('admin.image_max'),
           'content.required' => __('admin.content_required'),
           'content.string' => __('admin.content_string'),
            
        ];
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'cats' => 'required|array',
            'cats.*' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'image' => 'required|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            'content' => 'required|string',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        else{
            $slug = Str::slug($request->title);
            $count = posts::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $fileName = ($count ? "{$slug}-{$count}" : $slug) .'.'.$request->image->extension();  
            $request->image->move(public_path('uploads'), $fileName);
            
            
            $newPost = new posts();
            $newPost->title = $request->title;
            $newPost->slug = $count ? "{$slug}-{$count}" : $slug;
            $newPost->image = $fileName;
            $newPost->content = $request->content;
            $newPost->save();
            if(isset($request->cats) && count($request->cats) > 0){
                foreach($request->cats as $cat){
                    $new_post_cat = new post_categories();
                    $new_post_cat->post = $newPost->id;
                    $new_post_cat->category = $cat;
                    $new_post_cat->save();
                }
            }
             if(isset($request->tags) && count($request->tags) > 0){
                foreach($request->tags as $tag){
                    $new_post_tag = new post_tags();
                    $new_post_tag->post = $newPost->id;
                    $new_post_tag->tag = $tag;
                    $new_post_tag->save();
                }
            }
              return back()->with('message',__('admin.successedpostsaved'));
        }
    }
    public function addCategory(Request $request){
            $messages = [
           'name.required' => __('admin.cat_name_required'),
           'name.string' => __('admin.cat_name_string'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
              $slug = Str::slug($request->name);
              $count = categories::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
              $newCat = new categories();
              $newCat->name = $request->name;
              $newCat->slug = $count ? "{$slug}-{$count}" : $slug;
              $newCat->save();
             return back()->with('message',__('admin.successedcatsaved'));
        }
    }
      public function addTags(Request $request){
            $messages = [
           'name.required' => __('admin.cat_name_required'),
           'name.string' => __('admin.cat_name_string'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
              $slug = Str::slug($request->name);
              $count = tags::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
              $newTag = new tags();
              $newTag->name = $request->name;
              $newTag->slug = $count ? "{$slug}-{$count}" : $slug;
              $newTag->save();
             return back()->with('message',__('admin.successedtagsaved'));
        }
    }
    public function showUser($id){
        $user = User::findOrFail($id);
        return view('admin.showUser',compact('user'));
    }
    public function updateUser(Request $request,$id){
        $user = User::findOrFail($id);
        if(!$user){
            return abort(404);
        }
            $messages = [
           'name.required' => __('admin.user_name_required'),
           'name.string' => __('admin.user_name_string'),
           'email.required' => __('admin.user_email_required'),
           'email.email' => __('admin.user_email_email'),
           'email.unique' => __('admin.user_email_unique'),
           'identity.required' => __('admin.user_identity_required'),
           'identity.string' => __('admin.user_identity_numeric'),
            'identity.unique' => __('admin.user_identity_unique'),    
           'mobile.required' => __('admin.user_mobile_required'),
           'mobile.numeric' => __('admin.user_mobile_numeric'),
           'mobile.unique' => __('admin.user_mobile_unique'),
            'birth.required' => __('auth.birth_required'),
            'birth.date_format' => __('auth.birth_date_format'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'identity' => 'required|string|unique:users,identity,' . $id,
            'mobile' => 'required|numeric|unique:users,mobile,' . $id,
            'password' => 'nullable|string',
            'birth' => 'required|date_format:Y-m-d',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            if($request->password){
                 $user->password  = Hash::make($request->password);
            }
                $user->name  = $request->name;
                $user->birth  = $request->birth;
                $user->identity  = $request->identity;
                $user->mobile  = $request->mobile;
                $user->save();
                return back()->with('message',__('admin.userUpdatedSuccessfully'));
        }
    }
    public function adduser(Request $request){
            $messages = [
           'name.required' => __('admin.user_name_required'),
           'name.string' => __('admin.user_name_string'),
           'email.required' => __('admin.user_email_required'),
           'email.email' => __('admin.user_email_email'),
           'email.unique' => __('admin.user_email_unique'),
           'identity.required' => __('admin.user_identity_required'),
           'identity.string' => __('admin.user_identity_numeric'),
           'identity.unique' => __('admin.user_identity_unique'),
           'mobile.required' => __('admin.user_mobile_required'),
           'countryCode.required' => __('admin.user_countryCode_required'),
           'mobile.numeric' => __('admin.user_mobile_numeric'),
           'mobile.unique' => __('admin.user_mobile_unique'),
           'password.required' => __('admin.user_password_required'),
           'password.min' => __('admin.user_password_min'),
                'birth.required' => __('auth.birth_required'),
            'birth.date_format' => __('auth.birth_date_format'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'identity' => 'required|string|unique:users,identity',
            'mobile' => 'required|numeric|unique:users,mobile',
            'password' => 'required|min:8',
             'birth' => 'required|date_format:Y-m-d',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
                $user = new User();
                $user->name  = $request->name;
                $user->birth  = $request->birth;
                $user->identity  = $request->identity;
                $user->mobile  = $request->mobile;
                $user->password  = Hash::make($request->password);
                $user->save();
                return back()->with('message',__('admin.userAddedSuccessfully'));
        }
    }
    
    public function editsubscriptions($id){
        $subscription = subscriptions::findOrFail($id);
         $allplans = plans::where('status','1')->get();
        return view('admin.subscriptionsEdit',compact('subscription','allplans'));
    }
      public function updatesubscriptions(Request $request,$id){
        $subscription = subscriptions::findOrFail($id);
          if(!$subscription){
             return  abort(404);
          }
                     $messages = [
                      'plan.required' => __('admin.plan_required') ,
                      'plan.exists' => __('admin.plan_exists') ,
                      'payment.required' => __('admin.payment_required') ,
            
        ];
        $validator = Validator::make($request->all(),[
             'plan' => 'required|exists:plans,id',
             'payment' => 'required|in:1,2'
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            $plan = plans::findOrFail($request->plan);
            if(Carbon::parse($subscription->end_to) >= Carbon::now()){
                $subscription->end_to = Carbon::parse($subscription->end_to)->addDays($plan->days);
            }else{
                $subscription->end_to = Carbon::now()->addDays($plan->days);
            }
            $subscription->save();
                $newPaymentInitial = new payments();
                        $newPaymentInitial->user = $subscription->User->id;
                        $newPaymentInitial->plan = $plan->id;
                        $newPaymentInitial->status = 'PAID';
                        $newPaymentInitial->amount = $plan->price;
                        $newPaymentInitial->currency = 'KWD';
                        $newPaymentInitial->created_by = auth()->guard('admin')->user()->id;
                        $newPaymentInitial->paid = ($request->payment == '1') ? 'cash' : 'ke.net' ;
                        $newPaymentInitial->save();
             return back()->with('message',__('admin.subscriptionUpdatedSuccessfully'));
        }
    }
    public function removesubscriptions($id){
         $subscription = subscriptions::findOrFail($id);
          if(!$subscription){
            return  abort(404);
          }
        $subscription->delete();
        return back()->with('message',__('admin.subscriptionremovedSuccessfully'));
    }
     public function insertsubscriptions(Request $request){
                      $messages = [
                      'user.required' => __('admin.user_required') ,
                      'user.exists' => __('admin.user_exists') ,
                      'plan.required' => __('admin.plan_required') ,
                      'plan.exists' => __('admin.plan_exists') ,
                      'payment.required' => __('admin.payment_required') ,
            
        ];
        $validator = Validator::make($request->all(),[
            'user' => ['required','exists:users,id',function ($attribute, $value, $fail) {
                $user = User::findOrFail($value);
            if ($user->subscriptionOb) {
                $fail(__('admin.thisUserHavesubscription'));
            }
        }],
            'plan' => 'required|exists:plans,id',
            'payment' => 'required|in:1,2'
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            $user = User::findOrFail($request->user);
            $plan = plans::findOrFail($request->plan);
            $new_subscription = new subscriptions();
            $new_subscription->user = $user->id;
            $new_subscription->main_price = $plan->price;
            $new_subscription->main_days = $plan->days;
            $new_subscription->plan = $plan->id;
            $new_subscription->start_from = Carbon::now();
            $new_subscription->end_to = Carbon::now()->addDays($plan->days);
            $new_subscription->save();
            
                        $newPaymentInitial = new payments();
                        $newPaymentInitial->user = $user->id;
                        $newPaymentInitial->plan = $plan->id;
                        $newPaymentInitial->status = 'PAID';
                        $newPaymentInitial->amount = $plan->price;
                        $newPaymentInitial->currency = 'KWD';
                        $newPaymentInitial->created_by = auth()->guard('admin')->user()->id;
                        $newPaymentInitial->paid = ($request->payment == '1') ? 'cash' : 'ke.net' ;
                        $newPaymentInitial->save();
               return back()->with('message',__('admin.subscriptionAddedSuccessfully'));
        }
     
    }
    public function plans(){
        $plans = plans::where('status',1)->get();
        return view('admin.plans',compact('plans'));
    }
    public function addPlan(){
        return view('admin.addPlan');
    }
    public function insertPlan(Request $request){
                     $messages = [
               
            'name.required' => __('admin.plan_name_required') , 
            'name.string' => __('admin.plan_name_string') , 
            'days.required' => __('admin.plan_days_required') , 
            'days.numeric' => __('admin.plan_days_numeric') , 
            'days.min' => __('admin.plan_days_min') , 
            'price.required' => __('admin.plan_price_required') , 
            'price.numeric' => __('admin.plan_price_numeric') , 
            'price.min' => __('admin.plan_price_min') , 
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'days' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            $new_plan = new plans();
            $new_plan->name = $request->name;
            $new_plan->price = $request->price;
            $new_plan->days = $request->days;
            $new_plan->save();
            return back()->with('message',__('admin.planAddedSuccessfully'));
        }
    }
    public function Editplan($id){
        $plan = plans::findOrFail($id);
        if(!$plan){ return abort(404);}
        return view('admin.editPlan',compact('plan'));
    }
    public function updatePlan(Request $request,$id){
         $plan = plans::findOrFail($id);
        if(!$plan){ return abort(404);}
                 $messages = [
               
            'name.required' => __('admin.plan_name_required') , 
            'name.string' => __('admin.plan_name_string') , 
            'days.required' => __('admin.plan_days_required') , 
            'days.numeric' => __('admin.plan_days_numeric') , 
            'days.min' => __('admin.plan_days_min') , 
            'price.required' => __('admin.plan_price_required') , 
            'price.numeric' => __('admin.plan_price_numeric') , 
            'price.min' => __('admin.plan_price_min') , 
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'days' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            $plan->name = $request->name;
            $plan->price = $request->price;
            $plan->days = $request->days;
            $plan->save();
            return back()->with('message',__('admin.planeditSuccessfully'));
        }
    }
    public function Removeplan($id){
         $plan = plans::findOrFail($id);
        if(!$plan){ return abort(404);}
        $plan->status = 0;
        $plan->save();
         return back()->with('message',__('admin.planDeletedSuccessfully'));
    }
    public function bookings(Request $request){
         if($request->ajax()){
              if($request->datatable['pagination']['page'] != null){
                  $page = $request->datatable['pagination']['page'];
              }else{
                  $page = 1;
              }
              if($request->datatable['pagination']['perpage'] != null){
                  $perpage = $request->datatable['pagination']['perpage'];
              }else{
                  $perpage = 50;
              }
               if($request->datatable['query']['generalSearch'] != null){
                  $search = $request->datatable['query']['generalSearch'];
                  $payments = booking::with('User')->whereHas('User' , function ($query) use ($search) {
                       $query->where('mobile',$search)
                             ->orWhere('identity',$search)
                             ->orWhere('name','like','%'.$search.'%')
                             ->orWhere('email',$search);
                    })->orderBy('day','desc')->paginate($perpage, ['*'], 'page', $page);
                  return response()->json(new bookingsResource($payments),200);
              }
               $bookings = booking::with('User')->orderBy('day','desc')->paginate($perpage, ['*'], 'page', $page);
               return response()->json(new bookingsResource($bookings),200);
             
          }
        return view('admin.bookings');
    }
     public function contactInfo(){
        return view('admin.contactInfo');
    }
    
    public function bookingsConfirm($id){
        $booking = booking::findOrFail($id);
         if(!$booking){ return abort(404);}
        $booking->status = 1;
        $booking->save();
        return response()->json(['status' => 'done' , 'message' => __('admin.book confirmed')],200);
    }
    public function contactInfoUpdate(Request $request){
                 $messages = [
               'email.required' => __('admin.contact_email_required') , 
               'email.email' => __('admin.contact_email_email') , 
               'address.required' => __('admin.contact_address_required') , 
               'address.string' => __('admin.contact_address_string') , 
               'mobile.required' => __('admin.contact_mobile_required') , 
               'mobile.string' => __('admin.contact_mobile_string') , 
      
        ];
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'address' => 'required|string',
            'mobile' => 'required|string',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            $contactEmail = contact::where('key','email')->firstOrFail();
            $contactEmail->value = $request->email;
            $contactEmail->save();
            $contactAddress = contact::where('key','address')->firstOrFail();
            $contactAddress->value = $request->address;
            $contactAddress->save();
            $contactMobile = contact::where('key','mobile')->firstOrFail();
            $contactMobile->value = $request->mobile;
            $contactMobile->save();
            return back()->with('message',__('admin.successedSavedData'));
        }
    }
    public function export() 
        {
            return Excel::download(new UsersExport(), 'invoices.xlsx');
    }
      public function editPost($id){
          $post = posts::findOrFail($id);
         if(!$post){abort(404);}
          $tags = tags::all();
          $categories = categories::all();
          $post_categories = post_categories::where('post',$id)->pluck('category')->toArray();
          $post_tags = post_tags::where('post',$id)->pluck('tag')->toArray();
        return view('admin.editpost',compact('categories','tags','post','post_categories','post_tags'));
    }
      public function updatePost(Request $request,$id){
       // return $request->all();
          $post = posts::findOrFail($id);
          if(!$post){abort(404);}
          $messages = [
           'title.required' => __('admin.post_title_required'),
           'title.string' => __('admin.post_title_string'),
           'cats.required' => __('admin.post_cats_required'),
           'cats.array' => __('admin.post_cats_array'),
           'cats.exists' => __('admin.post_cats_array'),
           'tags.array' => __('admin.post_tags_array'),
           'tags.exists' => __('admin.post_tags_array'),
           'image.required' => __('admin.image_required'),
           'image.file' => __('admin.image_file'),
           'image.mimes' => __('admin.image_mimes'),
           'image.max' => __('admin.image_max'),
           'content.required' => __('admin.content_required'),
           'content.string' => __('admin.content_string'),
            
        ];
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'cats' => 'required|array',
            'cats.*' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            'content' => 'required|string',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        else{
            if($request->image){
                    $slug = Str::slug($request->title);
                    $fileName = $slug .'.'.$request->image->extension();  
                    $request->image->move(public_path('uploads'), $fileName);
            }
            
            
            
   
            $post->title = $request->title;
            if($request->image){
                 $post->image = $fileName;
            }
            $post->content = $request->content;
            $post->save();
            if(isset($request->cats) && count($request->cats) > 0){
                
                foreach($post->post_cats as $cat){
                    $cat->delete();
                }
                foreach($request->cats as $cat){
                    $new_post_cat = new post_categories();
                    $new_post_cat->post = $post->id;
                    $new_post_cat->category = $cat;
                    $new_post_cat->save();
                }
            }
             if(isset($request->tags) && count($request->tags) > 0){
                 foreach($post->post_tags as $tag){
                    $tag->delete();
                }
                foreach($request->tags as $tag){
                    $new_post_tag = new post_tags();
                    $new_post_tag->post = $post->id;
                    $new_post_tag->tag = $tag;
                    $new_post_tag->save();
                }
            }
              return back()->with('message',__('admin.successedpostedited'));
        }
    }
    public function trainers(){
        $trainers = trainers::all();
        return view('admin.trainers',compact('trainers'));
    }
     public function addtrainer(){
        return view('admin.addtrainer');
    }
     public function inserttrainer(Request $request){
           $messages = [
           'name.required' => __('admin.trainer_name_required'),
           'name.string' => __('admin.trainer_name_string'),
           'job.required' => __('admin.trainer_job_required'),
           'job.string' => __('admin.trainer_job_string'),
           'desc.required' => __('admin.trainer_desc_required'),
           'desc.string' => __('admin.trainer_desc_string'),
           'desc.max' => __('admin.trainer_desc_max'),
           'facebook.required' => __('admin.trainer_facebook_required'),
           'facebook.string' => __('admin.trainer_facebook_string'),
           'twitter.required' => __('admin.trainer_twitter_required'),
           'twitter.string' => __('admin.trainer_twitter_string'),
           'insta.required' => __('admin.trainer_insta_required'),
           'insta.string' => __('admin.trainer_insta_string'),
           'image.required' => __('admin.trainer_image_required'),
           'image.file' => __('admin.trainer_image_file'),
           'image.mimes' => __('admin.trainer_image_mimes'),
           'image.max' => __('admin.trainer_image_max'),

            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'job' => 'required|string',
            'desc' => 'required|string|max:120',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'insta' => 'nullable|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
         $fileName = time() . '-' . Str::slug($request->name) .'.'.$request->image->extension();  
         $request->image->move(public_path('uploads/trainers'), $fileName);
         $new_trainer = new trainers();
         $new_trainer->name = $request->name;
         $new_trainer->jobTitle = $request->job;
         $new_trainer->desc = $request->desc;
         $new_trainer->facebook = $request->facebook;
         $new_trainer->twitter = $request->twitter;
         $new_trainer->insta = $request->insta;
         $new_trainer->image = $fileName;
         $new_trainer->save();
         return back()->with('message',__('admin.successedtrainerAdded'));
    }
     public function edittrainer($id){
        $trainer = trainers::findOrFail($id);
         if(!$trainer){ return abort(404);}
        return view('admin.edittrainer',compact('trainer'));
    }
     public function updatetrainer(Request $request,$id){
           $trainer = trainers::findOrFail($id);
           if(!$trainer){ return abort(404);}
           $messages = [
           'name.required' => __('admin.trainer_name_required'),
           'name.string' => __('admin.trainer_name_string'),
           'job.required' => __('admin.trainer_job_required'),
           'job.string' => __('admin.trainer_job_string'),
           'desc.required' => __('admin.trainer_desc_required'),
           'desc.string' => __('admin.trainer_desc_string'),
           'desc.max' => __('admin.trainer_desc_max'),
           'facebook.required' => __('admin.trainer_facebook_required'),
           'facebook.string' => __('admin.trainer_facebook_string'),
           'twitter.required' => __('admin.trainer_twitter_required'),
           'twitter.string' => __('admin.trainer_twitter_string'),
           'insta.required' => __('admin.trainer_insta_required'),
           'insta.string' => __('admin.trainer_insta_string'),
           'image.required' => __('admin.trainer_image_required'),
           'image.file' => __('admin.trainer_image_file'),
           'image.mimes' => __('admin.trainer_image_mimes'),
           'image.max' => __('admin.trainer_image_max'),

            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'job' => 'required|string',
            'desc' => 'required|string|max:120',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'insta' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
     
         if($request->image){
                 $fileName = time() . '-' . Str::slug($request->name) .'.'.$request->image->extension();  
                 $request->image->move(public_path('uploads/trainers'), $fileName);
         }
         $trainer->name = $request->name;
         $trainer->jobTitle = $request->job;
         $trainer->desc = $request->desc;
         $trainer->facebook = $request->facebook;
         $trainer->twitter = $request->twitter;
         $trainer->insta = $request->insta;
         if($request->image){
              $trainer->image = $fileName;
         }
         $trainer->save();
         return back()->with('message',__('admin.successedtrainerEdited'));
    }
    public function opinions(){
        $opinions = customersComments::all();
        return view('admin.opinions',compact('opinions'));
    }
     public function addopinions(){
        return view('admin.addopinions');
    }
      public function insertopinions(Request $request){
           $messages = [
           'name.required' => __('admin.comment_name_required'),
           'name.string' => __('admin.comment_name_string'),
           'comment.required' => __('admin.comment_comment_required'),
           'comment.string' => __('admin.comment_comment_string'),
           'image.file' => __('admin.comment_image_file'),
           'image.mimes' => __('admin.comment_image_mimes'),
           'image.max' => __('admin.comment_image_max'),

            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'comment' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
           if($request->image){
                 $fileName = time() . '-' . Str::slug($request->name) .'.'.$request->image->extension();  
                 $request->image->move(public_path('uploads/comments'), $fileName);
         }
          $newcustomersComment = new customersComments();
          $newcustomersComment->cName = $request->name;
          $newcustomersComment->cComment = $request->comment;
          if($request->image){
              $newcustomersComment->image = $fileName;
          }
          $newcustomersComment->save();
          return back()->with('message',__('admin.successedcommentAdded'));
      }
      public function editopinions($id){
         $opinion = customersComments::findOrFail($id);
         if(!$opinion){ return abort(404);}
         return view('admin.editopinion',compact('opinion'));
    }
      public function updateopinions(Request $request ,$id){
           $opinion = customersComments::findOrFail($id);
           if(!$opinion){ return abort(404);}
           $messages = [
           'name.required' => __('admin.comment_name_required'),
           'name.string' => __('admin.comment_name_string'),
           'comment.required' => __('admin.comment_comment_required'),
           'comment.string' => __('admin.comment_comment_string'),
           'image.file' => __('admin.comment_image_file'),
           'image.mimes' => __('admin.comment_image_mimes'),
           'image.max' => __('admin.comment_image_max'),

            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'comment' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
           if($request->image){
                 $fileName = time() . '-' . Str::slug($request->name) .'.'.$request->image->extension();  
                 $request->image->move(public_path('uploads/comments'), $fileName);
         }
          $opinion->cName = $request->name;
          $opinion->cComment = $request->comment;
          if($request->image){
              $opinion->image = $fileName;
          }
          $opinion->save();
          return back()->with('message',__('admin.successedcommentEdit'));
      }
     public function slider(){
         $slider = slider::all();
         return view('admin.slider',compact('slider'));
    }
     public function addslider(){
         return view('admin.addslider');
    }
    public function insertslider(Request $request){
           $messages = [
           'title.required' => __('admin.slider_title_required'),
           'title.string' => __('admin.slider_title_string'),
           'subtitle.required' => __('admin.slider_subtitle_required'),
           'subtitle.string' => __('admin.slider_subtitle_string'),
           'image.file' => __('admin.slider_image_file'),
           'image.mimes' => __('admin.slider_image_mimes'),
           'image.max' => __('admin.slider_image_max'),
           'image.required' => __('admin.slider_image_required'),

            
        ];
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
         $fileName = time() . '-' . Str::slug($request->title) .'.'.$request->image->extension();  
         $request->image->move(public_path('uploads/slider'), $fileName);
        $newslider = new slider();
        $newslider->title = $request->title;
        $newslider->subtitle = $request->subtitle;
        $newslider->image = $fileName;
        $newslider->save();
        return back()->with('message',__('admin.successedsliderAdded'));
    }
      public function editslider($id){
         $slider = slider::findOrFail($id);
         if(!$slider){ return abort(404);}
         return view('admin.editslider',compact('slider'));
    }
      public function updateslider(Request $request,$id){
            $slider = slider::findOrFail($id);
           if(!$slider){ return abort(404);}
           $messages = [
           'title.required' => __('admin.slider_title_required'),
           'title.string' => __('admin.slider_title_string'),
           'subtitle.required' => __('admin.slider_subtitle_required'),
           'subtitle.string' => __('admin.slider_subtitle_string'),
           'image.file' => __('admin.slider_image_file'),
           'image.mimes' => __('admin.slider_image_mimes'),
           'image.max' => __('admin.slider_image_max'),
           'image.required' => __('admin.slider_image_required'),

            
        ];
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
          if($request->image){
              $fileName = time() . '-' . Str::slug($request->title) .'.'.$request->image->extension();  
              $request->image->move(public_path('uploads/slider'), $fileName);
          }
        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        if($request->image){
         $slider->image = $fileName;
        }
        $slider->save();
        return back()->with('message',__('admin.successedsliderEdited'));
    }
    
    public function gallery(){
        $gallery_categories = gallery_categories::all();
        return view('admin.gallery',compact('gallery_categories'));
    }
     public function addgallery(){
        return view('admin.addgallery');
    }
        public function insertgallery(Request $request){
           $messages = [
           'name.required' => __('admin.gallery_name_required'),
           'name.string' => __('admin.gallery_name_string'),
           'name.max' => __('admin.gallery_name_max'),
            ];
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:15',
            ],$messages);
            if($validator->fails()){
                return back()->withErrors($validator);
            }
             $newgallery_category = new gallery_categories();
             $newgallery_category->name = $request->name;
             $newgallery_category->save();
        return back()->with('message',__('admin.successedAddedGallery'));
    }
      public function editgallery($id){
         $gallery_categories = gallery_categories::findOrFail($id);
         if(!$gallery_categories){ return abort(404);}
         return view('admin.editgallery',compact('gallery_categories'));
    }
       public function updategallery(Request $request,$id){
           $gallery_categories = gallery_categories::findOrFail($id);
           if(!$gallery_categories){ return abort(404);}
           $messages = [
           'name.required' => __('admin.gallery_name_required'),
           'name.string' => __('admin.gallery_name_string'),
           'name.max' => __('admin.gallery_name_max'),
            ];
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:15',
            ],$messages);
            if($validator->fails()){
                return back()->withErrors($validator);
            }
             $gallery_categories->name = $request->name;
             $gallery_categories->save();
        return back()->with('message',__('admin.successededitedGallery'));
    }
    public function gallery_images_show($id){
        $gallery = gallery_categories::findOrFail($id);
        if(!$gallery){ return abort(404);}
        return view('admin.gallery_images',compact('gallery'));
    }
    public function upload_image_gallery(Request $request,$id){
         $gallery = gallery_categories::findOrFail($id);
         if(!$gallery){ return response()->json(['status' => 'error'],200);}
            $messages = [
           'image.file' => __('admin.'),
           'image.mimes' => __('admin.'),
           'image.max' => __('admin.'),
           'image.required' => __('admin.'),  
        ];
        $validator = Validator::make($request->all(),[
            'image' => 'nullable|file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $allcounted = gallery::all()->count();
        $allcounted += 1;
        $fileName = time() . '-' . $allcounted .'.'.$request->image->extension();  
        $request->image->move(public_path('uploads/gallery'), $fileName);
        
        $newgallery = new gallery();
        $newgallery->category = $id;
        $newgallery->image = $fileName;
        $newgallery->save();
        return response()->json(['status' => 'success' , 'image' => $newgallery->id],200);
    }
    public function remove_image_gallery($cat,$id){
          $category = gallery_categories::findOrFail($cat);
          $gallery = gallery::where('id',$id)->where('category',$cat)->firstOrFail();
          if(!$gallery || !$category){ return response()->json(['status' => 'error'],200);}
          $gallery->delete();
          return response()->json(['status' => 'success'],200);
    }
    
      
    public function roles(){
        $roles = roles::where('id','!=',1)->get();
        return view('admin.roles',compact('roles'));
    }
     public function addroles(){
        $permissions = permissions::all();
        return view('admin.addRole',compact('permissions'));
    }
    public function insertroles(Request $request){
        $messages = [
           'name.required' => __('admin.roles_name_required'),  
           'name.string' => __('admin.roles_name_string'),  
           'roles.required' => __('admin.roles_roles_required'),  
           'roles.*' => __('admin.roles_roles_exists'),  
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'roles' => 'required',
            'roles.*' => 'exists:permissions,id',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $newrole = new roles();
        $newrole->name = $request->name;
        $newrole->save();
        foreach($request->roles as $role){
            $new_role_permissions  = new role_permissions();
            $new_role_permissions->role = $newrole->id;
            $new_role_permissions->permission = $role;
            $new_role_permissions->save();
        }
         return back()->with('message',__('admin.successedRoleAdded'));
    }
    public function updateroles(Request $request,$id){
        $role = roles::findOrFail($id);
        if(!$role){ return abort(404);}
        $messages = [
           'name.required' => __('admin.roles_name_required'),  
           'name.string' => __('admin.roles_name_string'),  
           'roles.required' => __('admin.roles_roles_required'),  
           'roles.*' => __('admin.roles_roles_exists'),  
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'roles' => 'required',
            'roles.*' => 'exists:permissions,id',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $role->name = $request->name;
        $role->save();
        $getrole_permissions = role_permissions::where('role',$id)->get();
        foreach($getrole_permissions as $role_per){
            $role_per->delete();
        }
        foreach($request->roles as $role){
            $new_role_permissions  = new role_permissions();
            $new_role_permissions->role = $id;
            $new_role_permissions->permission = $role;
            $new_role_permissions->save();
        }
         return back()->with('message',__('admin.successedRoleEddited'));
    }
    
     public function moderators(){
        $moderators = Admin::all();
        return view('admin.moderators',compact('moderators'));
    }
     public function addmoderators(){
        $roles = roles::all();
        return view('admin.addmoderator',compact('roles'));
    }
     public function insertmoderators(Request $request){
          $messages = [
           'name.required' => __('admin.user_name_required'),
           'name.string' => __('admin.user_name_string'),
           'email.required' => __('admin.user_email_required'),
           'email.email' => __('admin.user_email_email'),
           'email.unique' => __('admin.user_email_unique'),
           'identity.required' => __('admin.user_identity_required'),
           'identity.string' => __('admin.user_identity_numeric'),
           'mobile.required' => __('admin.user_mobile_required'),
           'countryCode.required' => __('admin.user_countryCode_required'),
           'mobile.numeric' => __('admin.user_mobile_numeric'),
           'mobile.unique' => __('admin.user_mobile_unique'),
           'password.required' => __('admin.user_password_required'),
           'password.min' => __('admin.user_password_min'),
           'role.required' => __('admin.user_role_required'),
           'role.exists' => __('admin.user_role_exists'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email',
            'identity' => 'required|string',
            'mobile' => 'required|numeric|unique:admins,mobile',
            'password' => 'required|min:8',
            'role' => 'required|exists:roles,id',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
                $user = new Admin();
                $user->name  = $request->name;
                $user->email  = $request->email;
                $user->identity  = $request->identity;
                $user->mobile  = $request->mobile;
                $user->password  = Hash::make($request->password);
                $user->save();
                if($user){
                    $newUserRole = new user_role();
                    $newUserRole->user =  $user->id;
                    $newUserRole->role =  $request->role;
                    $newUserRole->save();
                }
                return back()->with('message',__('admin.moderatorAddedSuccessfully'));
        }
     }
     public function showmoderator($id){
        $moderator = Admin::findOrFail($id);
        if(!$moderator){ return abort(404);}
        $roles = roles::all();
        return view('admin.editmoderator',compact('moderator','roles'));
    }
       public function updatemoderator(Request $request,$id){
        $user = Admin::findOrFail($id);
        if(!$user){
            return abort(404);
        }
            $messages = [
           'name.required' => __('admin.user_name_required'),
           'name.string' => __('admin.user_name_string'),
           'email.required' => __('admin.user_email_required'),
           'email.email' => __('admin.user_email_email'),
           'email.unique' => __('admin.user_email_unique'),
           'identity.required' => __('admin.user_identity_required'),
           'identity.string' => __('admin.user_identity_numeric'),
           'mobile.required' => __('admin.user_mobile_required'),
           'mobile.numeric' => __('admin.user_mobile_numeric'),
           'mobile.unique' => __('admin.user_mobile_unique'),
            'role.required' => __('admin.user_role_required'),
           'role.exists' => __('admin.user_role_exists'),
            
        ];
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:admins,email,' . $id,
            'identity' => 'required|string',
            'mobile' => 'required|numeric|unique:admins,mobile,' . $id,
            'password' => 'nullable|string',
            'role' => 'required|exists:roles,id',
            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }else{
            if($request->password){
                 $user->password  = Hash::make($request->password);
            }
                $user->name  = $request->name;
                $user->email  = $request->email;
                $user->identity  = $request->identity;
                $user->mobile  = $request->mobile;
                $user->save();
                    $userRole = user_role::where('user',$id)->first();
                    $userRole->role =  $request->role;
                    $userRole->save();
                return back()->with('message',__('admin.moderatorUpdatedSuccessfully'));
        }
    }
     public function editroles($id){
         
         $role = roles::where('id',$id)->where('id','!=',1)->first();
        if(!$role){
            return abort(404);
        }
        $permissions = permissions::all();
        return view('admin.editRole',compact('permissions','role'));
    }
    public function dologin(Request $request){
         auth()->guard('admin')->attempt(['email' => $request->email , 'password' => $request->password],$request->remember);
            if(auth()->guard('admin')->check()){
                return response()->json(['status' => 'done','message'=> __('admin.successedSignin')],200);
            }else{
                return response()->json(['status' => 'failed','message'=>__('admin.passwordNotCorrect')],200);
            }
    }
    public function logout(){
        auth()->guard('admin')->logout();
        return redirect(route('admin.login.show'));
    }
    
    public function homesectiontwo(){
        return view('admin.HomeSectionTwo');
    }
    public function inserthomesectiontwo(Request $request){
     
        $messages = [
           'title.required' => __('admin.second_section_title_required'),
           'title.string' => __('admin.second_section_title_string'),
           'subtitle.required' => __('admin.second_section_subtitle_required'),
           'subtitle.string' => __('admin.second_section_subtitle_string'),
           'firstImage.required' => __('admin.second_section_firstImage_required'),
           'firstImage.file' => __('admin.second_section_firstImage_file'),
           'firstImage.mimes' => __('admin.second_section_firstImage_mimes'),
           'firstImage.max' => __('admin.second_section_firstImage_max'),
           'secondImage.required' => __('admin.second_section_secondImage_required'),
           'secondImage.file' => __('admin.second_section_secondImage_file'),
           'secondImage.mimes' => __('admin.second_section_secondImage_mimes'),
           'secondImage.max' => __('admin.second_section_secondImage_max'),
           'thirdImage.required' => __('admin.second_section_thirdImage_required'),
           'thirdImage.file' => __('admin.second_section_thirdImage_file'),
           'thirdImage.mimes' => __('admin.second_section_thirdImage_mimes'),
           'thirdImage.max' => __('admin.second_section_thirdImage_max'),
 
            
        ];
        $rules = [
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'first' => 'file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            'second' => 'file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            'third' => 'file|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            
        ];
        $count = home_second::all()->count();
        if($count == 0){
            $rules['first'] = '|required';
            $rules['second'] = '|required';
            $rules['third'] = '|required';
        }else{
            $rules['first'] = '|nullable';
            $rules['second'] = '|nullable';
            $rules['third'] = '|nullable';
        }
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        if($request->first){
             $fileNameFirst = time() . '-' . Str::slug($request->title) .'-1'.'.'.$request->first->extension();  
             $request->first->move(public_path('uploads/home_second_section'), $fileNameFirst);
        }
        if($request->second){
            $fileNameSecond = time() . '-' . Str::slug($request->title) .'-2'.'.'.$request->second->extension();  
            $request->second->move(public_path('uploads/home_second_section'), $fileNameSecond);
        }
        if($request->third){
                $fileNameThird = time() . '-' . Str::slug($request->title) .'-3'.'.'.$request->third->extension();  
                $request->third->move(public_path('uploads/home_second_section'), $fileNameThird);
        }
        
          
        if($count == 0){
            $newhome_second = new home_second();
            $newhome_second->title = $request->title;
            $newhome_second->subtitle = $request->subtitle;
            $newhome_second->firstImage = $fileNameFirst;
            $newhome_second->secondImage = $fileNameSecond;
            $newhome_second->thiedImage = $fileNameThird;
            $newhome_second->save();
            return back()->with('message',__('admin.home_second_sectionAdded'));
        }else{
            $home_second = home_second::find(1);
            $home_second->title = $request->title;
            $home_second->subtitle = $request->subtitle;
             if($request->first){
                $home_second->firstImage = $fileNameFirst;
            }
            if($request->second){
                $home_second->secondImage = $fileNameSecond;
            }
             if($request->third){
                $home_second->thiedImage = $fileNameThird;
            }
            $home_second->save();
            return back()->with('message',__('admin.home_second_sectionEdit'));
        }
         
   
    }
    public function services(){
        $services = services::all();
        return view('admin.services',compact('services'));
    }
      public function addservices(){
        return view('admin.addService');
    }
      public function editservices($id){
          $service = services::find($id);
          if(!$service){
              return abort(404);
          }
        return view('admin.editService',compact('service'));
    }
     public function insertservices(Request $request){

            $messages = [
           'title.required' => __('admin.service_title_required'),
           'title.string' => __('admin.service_title_string'),
           'subtitle.required' => __('admin.service_subtitle_required'),
           'subtitle.string' => __('admin.service_subtitle_string'),

            
        ];
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'subtitle' => 'required|string',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
         $newservice = new services();
         $newservice->title = $request->title;
         $newservice->description = $request->subtitle;
         $newservice->save();
         return back()->with('message',__('admin.service_createdSuccessfully'));
     }
     public function updateservices(Request $request,$id){
          $service = services::find($id);
          if(!$service){
              return abort(404);
          }
            $messages = [
           'title.required' => __('admin.service_title_required'),
           'title.string' => __('admin.service_title_string'),
           'subtitle.required' => __('admin.service_subtitle_required'),
           'subtitle.string' => __('admin.service_subtitle_string'),

            
        ];
        $validator = Validator::make($request->all(),[
            'title' => 'required|string',
            'subtitle' => 'required|string',

            
        ],$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
         $service->title = $request->title;
         $service->description = $request->subtitle;
         $service->save();
         return back()->with('message',__('admin.service_editSuccessfully'));
     }
    
    public function payments(Request $request){
          if($request->ajax()){
              if($request->datatable['pagination']['page'] != null){
                  $page = $request->datatable['pagination']['page'];
              }else{
                  $page = 1;
              }
              if($request->datatable['pagination']['perpage'] != null){
                  $perpage = $request->datatable['pagination']['perpage'];
              }else{
                  $perpage = 50;
              }
               if($request->datatable['query']['generalSearch'] != null){
                  $search = $request->datatable['query']['generalSearch'];
                  $payments = payments::with('userObj','planOb','adminOb')->whereHas('userObj' , function ($query) use ($search) {
                       $query->where('mobile',$search)
                             ->orWhere('identity',$search)
                             ->orWhere('name','like','%'.$search.'%')
                             ->orWhere('email',$search);
                    })->orWhereHas('adminOb' , function ($query) use ($search) {
                       $query->where('name',$search);
                           
                    })->orderBy('id','desc')->paginate($perpage, ['*'], 'page', $page);
                  return response()->json(new subscriptionsResource($payments),200);
              }
               $payments = payments::with('userObj','planOb','adminOb')->where('status','PAID')->orderBy('id','desc')->paginate($perpage, ['*'], 'page', $page);
               return response()->json(new paymentsResource($payments),200);
             
          }
        return view('admin.payments');
    }
     public function exportPayments(Request $request){ 
         session()->put('start',$request->start);
         session()->put('end',$request->end);
         
          return response()->json(['status' => 'done'],200);
     }
       public function exportPaymentsDownload(){ 
        return Excel::download(new PaymentsExport(), 'Payments-'.Carbon::now().'-.xlsx');
     }
   
    
    
    
    
    
    
    
    
    
    
}
