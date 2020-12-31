@include('head')
        @include('nav')
 <div class="pages-header" style="background-image:url({{asset('images/5.jpg')}})">
            <div class="container">
                <div class="pages-title">
                 <h4>{{__('main.bookingPageHead')}}</h4>
<!--                    <p>Fitness is not a destination it is a way of life.</p>-->
                </div>
            </div>
        </div>
    </header>
    <div id="app">
<calender selectdaytobook="{{__('main.selectDayToBook')}}"></calender>
</div>
  
    
@include('footer')