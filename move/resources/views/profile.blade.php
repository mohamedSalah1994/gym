@include('head')   
   @include('nav')
 <div class="pages-header" style="background-image:url({{asset('images/5.jpg')}})">
            <div class="container">
                <div class="pages-title">
                   @yield('profileHead')
<!--                    <p>Fitness is not a destination it is a way of life.</p>-->
                </div>
            </div>
        </div>
    </header>
   <section>
<div class="container  @if(app()->getLocale() == 'ar') rtlpage @endif">
<div class="row">
<div class="col-lg-3">

<div class="card">
<div class="card__header">
<h4>{{__('profile.My Account')}}</h4>
</div>
<div class="card__content">
<div class="df-account-navigation">
<ul>
    <li class="df-account-navigation__link @if(Route::currentRouteName() == 'profile.view' ) active @endif">
           <a href="{{route('profile.view')}}">{{__('profile.Personal Information')}}</a>
</li>
      <li class="df-account-navigation__link @if(Route::currentRouteName() == 'profile.mybooking' ) active @endif">
           <a href="{{route('profile.mybooking')}}">{{__('profile.Personal booking')}}</a>
</li>
    <li class="df-account-navigation__link @if(Route::currentRouteName() == 'profile.Subscription' ) active @endif">
           <a href="{{route('profile.Subscription')}}">{{__('profile.Subscription')}}</a>
    </li>
     <li class="df-account-navigation__link  @if(Route::currentRouteName() == 'profile.password' ) active @endif">
            <a href="{{route('profile.password')}}">{{__('profile.passwordChange')}}</a>
     </li>
     <li class="df-account-navigation__link  @if(Route::currentRouteName() == 'profile.accountStatus.view' ) active @endif">
            <a href="{{route('profile.accountStatus.view')}}">{{__('profile.profileStatus')}}</a>
     </li>
     <li class="df-account-navigation__link  @if(Route::currentRouteName() == 'profile.payments.view' ) active @endif">
            <a href="{{route('profile.payments.view')}}">{{__('profile.LastPayments')}}</a>
     </li>
</ul>
    </div>
</div>
</div>

</div>
@yield('content')
</div>

</div>
    </section>
@include('footer')