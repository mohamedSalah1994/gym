<!-- LOADER -->
<div id="loader-wrapper">
<div class="loader"></div>
</div>
<!-- LOADER -->

    <header class="section-header">
        <div class="top-header">
            <div class="container">
                <div class="leftside">
                      @php
                    $email = \App\contact::where('key','email')->first();
                    $mobile = \App\contact::where('key','mobile')->first();
                    $address = \App\contact::where('key','address')->first();
                    @endphp
                    <div class="email-top"><p>{{$email->value ?? ''}}</p></div>
                    <div class="phone-top"><p>{{$mobile->value ?? ''}}</p></div>
                    <div class="address-top"><p>{{$address->value ?? ''}}</p></div>
                </div>
            </div>
        </div>
<nav>
            <div class="container">
                <hr class="top">
                <nav class="navbar navbar-expand-lg">
                  <a class="navbar-brand" href="{{url('/')}}"><div class="logo-brand"><img src="{{asset('assets/img/master/logo.png')}}" alt=""></div></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/')}}">{{__('main.HOME')}}</a>
                        </li>

                           <li class="nav-item">
                            <a class="nav-link" href="{{route('getPosts')}}">{{__('main.Blogs')}}</a>
                        </li>



                        </li>
                           <li class="nav-item">
                            <a class="nav-link" href="{{route('packages')}}">{{__('main.packagesPageHead')}}</a>
                        </li>
                        @if(Auth::guard('user')->check())
                        <li class="nav-item active dropdown">
                            <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">{{Auth::guard('user')->user()->name}}<span class="caret-drop"></span></a>
                            <ul class="dropdown-menu">
                              <li class="divider-top"></li>
                              <li><a class="dropdown-item" href="{{route('profile.view')}}">{{__('main.PROFILE')}}</a></li>
                               <li><a class="dropdown-item" href="{{route('booking')}}">{{__('main.bookingPageHead')}}</a></li>
                              <li><a class="dropdown-item" href="{{route('logout')}}">{{__('main.Logout')}}</a></li>
                            </ul>
                        </li>
                        @else
                            <li class="nav-item">
                            <a class="nav-link"  href="#loginModal" data-toggle="modal">{{__('main.SIGN')}}</a>
                        </li>

                        @endif

                    </ul>
                  </div>
                </nav>
            </div>
        </nav>
