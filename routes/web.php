<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('routes',function (){
   
//    $routeCollection = Route::getRoutes();
//$arr = [];
//foreach ($routeCollection as $value) {
//    array_push($arr, $value->getName()) ;
//}
//    return (Array)$arr;
    $y = [
"admin.login.show",
"admin.login.post",
"admin.logout",
"main",
"users",
"subscriptions",
"subscriptions.add",
"subscriptions.insert",
"subscriptions.edit",
"subscription.update",
"subscriptions.remove",
"user.add.show",
"user.add",
"user.show",
"user.delete",
"user.update",
"payment.print",
"categories",
"tags",
"tags.add",
"post.add.show",
"post.insert",
"posts",
"main.settings",
"SearchUser",
"settings.update",
"category.add",
"plans",
"plans.add",
"plans.insert",
"plans.update",
"plan.edit",
"plan.remove",
"bookings",
"booking.confirm",
"contact.info",
"contact.update",
"export.payment.download",
"post.edit",
"post.update",
"trainers",
"trainers.add",
"trainer.insert",
"trainer.edit",
"trainer.update",
"opinions",
"opinion.add",
"opinion.insert",
"opinion.edit",
"opinion.update",
"slider",
"slider.add",
"slider.insert",
"slider.edit",
"slider.update",
"gallery",
"gallery.add",
"gallery.insert",
"gallery.edit",
"gallery.update",
"gallery.images.show",
"gallery.upload",
"gallery.image.remove",
"roles",
"role.add",
"role.edit",
"role.update",
"role.insert",
"moderators",
"moderator.add",
"moderator.insert",
"moderator.show",
"moderator.update",
"home.section.two",
"home.section.two.insert",
"services",
"services.add",
"services.edit",
"services.insert",
"services.update",
"payments",
"export.payment"];
    // foreach($y as $x){
    //     $news =new \App\permissions();
    //     $news->name = $x;
    //     $news->route = $x;
    //     $news->save();
        
    // }
    
});

Route::group(['namespace' => 'users'],function (){
  //  Route::get('subsc','main@subsc');
   Route::post('/timeslots','main@timeslots'); 
   Route::post('/bookTimeSlot','main@booktimeslot'); 
   Route::post('/cancelTimeSlot','main@canceltimeslot'); 
   Route::post('/login','main@login')->name('login.post');
   Route::post('/signup','main@signup')->name('signup.post');
   Route::get('/logout','main@logout')->name('logout');
   Route::get('/', function () { return view('index');})->name('index');
   Route::get('/contact', function () { return view('contact');})->name('contact.view');
 
   Route::get('/packages', function () { return view('packages');})->name('packages');
   Route::post('/subscribe', 'main@subscribe')->name('subscribe.plan');
   Route::get('/verifyPayment', 'main@verifyPayment')->name('subscribe.verifyPayment');
   Route::get('/post/{slug}', 'main@post')->name('post.show');
   Route::get('/category/{slug}', 'main@category')->name('catBySlug');
   Route::get('/blog', 'main@blog')->name('getPosts');
   Route::post('/contact', 'main@contactSend')->name('contact.send');
   Route::get('/import', 'main@import')->name('import');
   Route::post('/import', 'main@saveimport')->name('import.save');
    
Route::group(['middleware' => 'authUser'],function (){
      Route::get('/booking', function () { return view('booking');})->name('booking');
   Route::get('/profile','main@profile')->name('profile.view');
   Route::get('/profile/bookings','main@profilebookings')->name('profile.mybooking');
   Route::get('/profile/password','main@profilePassword')->name('profile.password');
   Route::get('/profile/subscription','main@profileSubscription')->name('profile.Subscription');
   Route::get('/profile/update/freeze','main@profileFreeze')->name('profile.freeze.updateStatus');
   Route::get('/profile/status','main@profileStatus')->name('profile.accountStatus.view');
   Route::get('/profile/payments','main@profilePayments')->name('profile.payments.view');
   Route::post('/profile/password/update','main@profilePasswordUpdate')->name('profile.update.password');
   Route::post('/profile/update','main@profileUpdate')->name('profile.update');
   Route::post('/profile/cancelBook','main@cancelBook')->name('profile.cancelBook');
    });
});

