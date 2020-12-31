@include('head')
@include('nav')
 <div class="pages-header" style="background-image:url({{asset('images/5.jpg')}})">
            <div class="container">
                <div class="pages-title">
                  <h4>{{__('main.CONTACT US')}}</h4>
<!--                    <p>Fitness is not a destination it is a way of life.</p>-->
                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container">
            <div class="section-title">
                <h2>{{__('main.Get in Touch')}}</h2>
                
            </div>
            <div class="row">
                   @php
                    $email = \App\contact::where('key','email')->firstOrFail()->value;
                    $mobile = \App\contact::where('key','mobile')->firstOrFail()->value;
                    $address = \App\contact::where('key','address')->firstOrFail()->value;
                    @endphp
              <div class="col-md-6 col-lg-3 contact-col">
                <div class="contact-box">
                  <figure class="contact-icon"><img src="{{asset('assets/img/master/location.png')}}" alt=""></figure>
                  <h3>{{__('main.Visit Us')}}</h3>
                  <hr class="center">
                 <p>{{$address ?? ''}}</p>
    
                </div>
              </div>
              <div class="col-md-6 col-lg-3 contact-col">
                <div class="contact-box">
                  <figure class="contact-icon"><img src="{{asset('assets/img/master/email.png')}}" alt=""></figure>
                  <h3>{{__('main.Email Us')}}</h3>
                  <hr class="center">
                  <p>{{$email ?? ''}}</p>
                </div>
              </div>
              <div class="col-md-6 col-lg-3 contact-col">
                <div class="contact-box">
                  <figure class="contact-icon"><img src="{{asset('assets/img/master/phone2.png')}}" alt=""></figure>
                  <h3>{{__('main.Call Us')}}</h3>
                  <hr class="center">
                  <p>{{$mobile ?? ''}}</p>
            
                </div>
              </div>
              <div class="col-md-6 col-lg-3 contact-col">
                <div class="contact-box">
                  <figure class="contact-icon"><img src="{{asset('assets/img/master/clock.png')}}" alt=""></figure>
                  <h3>{{__('main.Online Support')}}</h3>
                  <hr class="center">
                  <p>{{$mobile ?? ''}}</p>
                 
                </div>
              </div>
            </div>
        </div>
        <div class="container">
            <div class="section-title">
                <h3>{{__('main.SEND US A MESSAGE')}}</h3>
            
            </div>
            <div class="contact-form">
              <form id="contact-form" method="post" action="{{route('contact.send')}}">
                  {{csrf_field()}}
  @if($errors->any())
    <div class="alert alert-danger danger-errors">
      @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
            @endforeach
    </div>
    @endif
    @if(session()->has('message'))
     <div class="alert alert-success danger-errors">
      <p>{{session()->get('message')}}</p>
    </div>
    @endif
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="form_name" type="text" name="name" class="form-control custome-form" placeholder="{{__('main.mail name')}}" data-error="Firstname is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input id="form_email" type="email" name="email" class="form-control custome-form" placeholder="{{__('main.mail email')}}" data-error="Valid email is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea id="form_message" name="message" class="form-control custome-form" placeholder="{{__('main.mail message')}}" rows="3"  data-error="Please,leave us a message."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-send"><p><input type="submit" class="btn btn-custom btn-custom-small" value="{{__('main.mail send')}}"></p></div>
                    </div>
                </form>
            </div> 
        </div>
        <div class="maps"><iframe src="https://snazzymaps.com/embed/113777" width="100%" height="500px" style="border:none;"></iframe></div>
    </section>
    
@include('footer')