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

Route::group(["prefix" => 'admin'],function(){
    Route::get('login','main@login')->name('admin.login.show');
    Route::post('login','main@dologin')->name('admin.login.post');
    Route::get('logout','main@logout')->name('admin.logout');
    
    Route::group(['middleware' => 'adminCheck'],function (){
    Route::get('','main@profile')->name('main');
    Route::get('users','main@users')->name('users');
    Route::get('subscriptions','main@subscriptions')->name('subscriptions');
    Route::get('subscriptions/add','main@addsubscriptions')->name('subscriptions.add');
    Route::post('subscriptions/insert','main@insertsubscriptions')->name('subscriptions.insert');
    Route::get('subscriptions/edit/{id}','main@editsubscriptions')->name('subscriptions.edit');
    Route::post('subscriptions/update/{id}','main@updatesubscriptions')->name('subscription.update');
    Route::get('subscriptions/remove/{id}','main@removesubscriptions')->name('subscriptions.remove');
    Route::get('users/add','main@addusers')->name('user.add.show');
    Route::post('users/add','main@adduser')->name('user.add');
    Route::get('users/show/{id}','main@showUser')->name('user.show');
    Route::get('users/delete/{id}','main@deleteUser')->name('user.delete');
    Route::post('users/update/{id}','main@updateUser')->name('user.update');
    Route::get('payments/print/{id}','main@printpayment')->name('payment.print');
    Route::get('categories','main@categories')->name('categories');
    Route::get('tags','main@tags')->name('tags');
    Route::post('tags/add','main@addTags')->name('tags.add');
    Route::get('posts/add','main@addPost')->name('post.add.show');
    Route::post('posts/add','main@insertPost')->name('post.insert');
    Route::get('posts','main@posts')->name('posts');
    Route::get('settings','main@settings')->name('main.settings');
    Route::post('users/search','main@usersearch')->name('SearchUser');
    Route::post('settings/update','main@settingsUpdate')->name('settings.update');
    Route::post('category/add','main@addCategory')->name('category.add');
    Route::get('plans','main@plans')->name('plans');
    Route::get('plans/add','main@addPlan')->name('plans.add');
    Route::post('plans/insert','main@insertPlan')->name('plans.insert');
    Route::post('plans/update/{id}','main@updatePlan')->name('plans.update');
    Route::get('plans/edit/{id}','main@Editplan')->name('plan.edit');
    Route::get('plans/remove/{id}','main@Removeplan')->name('plan.remove');
    Route::get('bookings','main@bookings')->name('bookings');
    Route::post('bookings/confirm/{id}','main@bookingsConfirm')->name('booking.confirm');
    Route::get('contact','main@contactInfo')->name('contact.info');
    Route::post('contact/update','main@contactInfoUpdate')->name('contact.update');
    Route::get('export','main@export')->name('export');
    Route::get('post/edit/{id}','main@editPost')->name('post.edit');
    Route::post('post/update/{id}','main@updatePost')->name('post.update');
    Route::get('trainers','main@trainers')->name('trainers');
    Route::get('trainer/add','main@addtrainer')->name('trainers.add');
    Route::post('trainer/add','main@inserttrainer')->name('trainer.insert');
    Route::get('trainer/edit/{id}','main@edittrainer')->name('trainer.edit');
    Route::post('trainer/edit/{id}','main@updatetrainer')->name('trainer.update');
    Route::get('opinions','main@opinions')->name('opinions');
    Route::get('opinions/add','main@addopinions')->name('opinion.add');
    Route::post('opinions/add','main@insertopinions')->name('opinion.insert');
    Route::get('opinions/edit/{id}','main@editopinions')->name('opinion.edit');
    Route::post('opinions/edit/{id}','main@updateopinions')->name('opinion.update');
    Route::get('slider','main@slider')->name('slider');
    Route::get('slider/add','main@addslider')->name('slider.add');
    Route::post('slider/add','main@insertslider')->name('slider.insert');
    Route::get('slider/edit/{id}','main@editslider')->name('slider.edit');
    Route::post('slider/edit/{id}','main@updateslider')->name('slider.update');
    Route::get('gallery','main@gallery')->name('gallery');
    Route::get('gallery/add','main@addgallery')->name('gallery.add');
    Route::post('gallery/add','main@insertgallery')->name('gallery.insert');
    Route::get('gallery/edit/{id}','main@editgallery')->name('gallery.edit');
    Route::post('gallery/edit/{id}','main@updategallery')->name('gallery.update');
    Route::get('gallery/images/{id}','main@gallery_images_show')->name('gallery.images.show');
    Route::post('gallery/images/{id}','main@upload_image_gallery')->name('gallery.upload');
    Route::post('gallery/images/remove/{cat}/{id}','main@remove_image_gallery')->name('gallery.image.remove');
    Route::get('roles','main@roles')->name('roles');
    Route::get('roles/add','main@addroles')->name('role.add');
    Route::get('roles/edit/{id}','main@editroles')->name('role.edit');
    Route::post('roles/edit/{id}','main@updateroles')->name('role.update');
    Route::post('roles/add','main@insertroles')->name('role.insert');
    Route::get('moderators','main@moderators')->name('moderators');
    Route::get('moderators/add','main@addmoderators')->name('moderator.add');
    Route::post('moderators/add','main@insertmoderators')->name('moderator.insert');
    Route::get('moderators/{id}','main@showmoderator')->name('moderator.show');
    Route::post('moderators/{id}','main@updatemoderator')->name('moderator.update');
    Route::get('section/two','main@homesectiontwo')->name('home.section.two');
    Route::post('section/two','main@inserthomesectiontwo')->name('home.section.two.insert');
    Route::get('services','main@services')->name('services');
    Route::get('services/add','main@addservices')->name('services.add');
    Route::get('services/edit/{id}','main@editservices')->name('services.edit');
    Route::post('services/add','main@insertservices')->name('services.insert');
    Route::post('services/edit/{id}','main@updateservices')->name('services.update');
    Route::get('payments/','main@payments')->name('payments');
    Route::post('export/','main@exportPayments')->name('export.payment');
    Route::get('export/','main@exportPaymentsDownload')->name('export.payment.download');
    });
    
});

