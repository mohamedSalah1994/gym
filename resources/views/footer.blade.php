  <footer>
        <div class="container">
            <div class="row">
              <div class="col-lg-5"> 
                <figure class="footer-logo"><img src="img/master/logo.png" alt=""></figure>
                <div class="footer-about">
                     @php
        $sitedesc = \App\settings::where('key','sitedesc')->first();
        @endphp
                    <p>{!! $sitedesc->value ?? '' !!}</p>
                </div>
                <hr class="footer">
<!--
                <div class="social-footer">
                    <div class="social-items"><p><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></p></div>
                    <div class="social-items"><p><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></p></div>
                    <div class="social-items"><p><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></p></div>
                </div>
-->
              </div>
              <div class="col-lg-3 footer-center-col">
                <div class="popular-sites">
                    <h4>{{__('main.QUICK URLS')}}</h4> 
                    <div class="left-side">
                        <p><a href="{{url('/')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp; {{__('main.HOME')}}</a></p> 
                        <p><a href="{{route('getPosts')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp; {{__('main.Blogs')}}</a></p>  
                        <p><a href="{{route('contact.view')}}"><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp; {{__('main.CONTACT US')}}</a></p>
                          
                    </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="grid-bottom-gallery">
                    <h4>{{__('main.GALLERY')}}</h4> 
                    <div class="row">
                        @php
                           $getlast6gallery = \App\gallery::all()->take(6);
                        @endphp
                        @foreach($getlast6gallery as $gallery)
                      <div class="col-6 col-sm-4 col-md-4 grid-thumb"><a><img src="{{asset('uploads/gallery/'.$gallery->image)}}" alt=""></a></div>
                        @endforeach
                    </div> 
                  </div>
              </div>
            </div>
        </div>
        <div class="bottom-footer">
             @php
        $title = \App\settings::where('key','site_title')->first();
        @endphp
            <p style="text-transform: uppercase;">© {{\Carbon\Carbon::now()->format('yy')}} -  {{$title->value ?? ''}}</p>
        </div>
    </footer>
    <div class="modal fade rtl text-right" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalEx" aria-modal="true" style="padding-right: 17px;">
	  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header border-bottom-0">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">×</span>
	        </button>
	      </div>
	      <div class="modal-body px-0">
	        
					<div class="col-12 mb-3 d-flex justify-content-center tabsNavs">
						<ul class="col-lg-8 nav nav-tabs border-0">
			        <li class="col-6 nav-item px-0">
			          <a href="#loginForm" class="d-block text-center nav-link tab left-tab active" data-toggle="tab">{{__('sign.login')}}</a>
			        </li>
			        <li class="col-6 nav-item px-0">
			          <a href="#signupForm" class="d-block text-center nav-link tab right-tab" data-toggle="tab">{{__('sign.signup')}}</a>
			        </li>
						</ul>
					</div>

					<div class="col-12 tab-content mb-3">
		        <!-- login -->
		        <div class="tab-pane fade justify-content-center active show" id="loginForm">
							<form class="col-lg-8" id="loginForm_submit" method="post" action="{{route('login.post')}}">
                                <div class="form-group">
									<label>{{__('sign.identity')}}</label>
									<input type="text" name="identity" class="form-control" required>
								</div>
								<div class="form-group position-relative">
									<div class="inner-addon left-addon pass-addon">
										<span class="glyphicon">
											<svg class="bi bi-eye-fill" width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
											  <path d="M10.5 8a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
											  <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" clip-rule="evenodd"></path>
											</svg>
										</span>
									</div>
									<label>{{__('sign.password')}}</label>
									<input type="password" name="password" class="form-control" required>
								</div>

								<div class="d-flex justify-content-between">
									{{-- <div class="form-group">
									 	<a href="/forget_password" class="hover-main forgettext">{{__('sign.forgetpasswordText')}}</a>
									 </div> --}}
									 <div class="form-group">
							      <div class="form-check custom-check">
								      <input class="form-check-input" type="checkbox" name="remember" id="remember"> 
								      <label class="form-check-label" for="remember">
								        {{__('sign.remember')}}
								      </label>
								    </div>
							    </div>
								</div>
                                <div class="alert alert-danger" style="display:none" id="login_errors"></div>
                                <div class="alert alert-success" style="display:none" id="login_success"></div>
								<div class="form-group mt-3">
									<input type="submit" name="submit" class="form-control btn-custom" value="{{__('sign.login')}}">
								</div>

							</form>
		        </div>

		        <!-- sign up -->
		        <div class="tab-pane fade justify-content-center" id="signupForm">
		          <form class="col-lg-8" method="post"  id="signup_form_submit" action="{{route('signup.post')}}">
                      <div class="form-group">
									<label>{{__('sign.name')}}</label>
									<input type="text" name="name" class="form-control" required>
								</div>
								{{--<div class="form-group">
									<label>{{__('sign.email')}}</label>
									<input type="email" name="email" class="form-control" required>
								</div> --}}
                      	<div class="form-group">
									<label>{{__('sign.identity')}}</label>
									<input type="number" name="identity" class="form-control" required>
								</div>
	                       <div class="form-group">
										<label>{{__('sign.mobile')}}</label>
										<input type="mobile" name="mobile" class="form-control" required>
									</div>
                      <div class="form-group">
									<label>{{__('sign.birth')}}</label>
									<input type="date" name="birth" class="form-control" required>
								</div>
								<div class="form-group position-relative">
									<div class="inner-addon left-addon pass-addon">
										<span class="glyphicon">
											<svg class="bi bi-eye-fill" width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
											  <path d="M10.5 8a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
											  <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" clip-rule="evenodd"></path>
											</svg>
										</span>
									</div>
									<label>{{__('sign.password')}}</label>
									<input type="password" name="password" class="form-control" required>
								</div>
                            <div class="alert alert-danger" style="display:none" id="signup_form_errors"></div>
                            <div class="alert alert-success" style="display:none" id="signup_form_success"></div>
								<div class="form-group mt-3">
									<input type="submit" name="submit" class="form-control btn-custom" value="{{__('sign.signup')}}">
								</div>

							</form>
		        </div>
					</div>


					
					
					
					
	      </div>
	    </div>
	  </div>
	</div>
       <div class="modal fade" id="json_reponses" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="error_response_mess">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{__('main.CLOSE')}}</button>
        </div>
      </div>
      
    </div>
  </div>
<div id="paymentSuccess" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="fa fa-check" aria-hidden="true"></i>
				</div>				
				<h4 class="modal-title w-100">{{__('booking.subscribtionSuccess')}}</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center">{{__('booking.subscribtionconfimed')}}</p>
				<p class="text-center" style="margin-bottom:2px;">{{__('booking.subscribtionInvoiceNumber')}}</p>
				<p class="text-center" style="margin-bottom:2px;">{{(session()->get( 'invoice' ) ?? '')}}</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>

    <a href="#0" class="cd-top">Top</a>
	<!-- ==============================================
	JAVASCRIPTS
	=============================================== -->
    <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    @if(Request::path() != 'booking')
   <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    @endif
    <script src="{{asset('assets/js/loader.js')}}"></script>
    <script src="{{asset('assets/js/flickity.pkgd.min.js')}}"></script> 
    <script src="{{asset('assets/js/testimonials.js')}}"></script>
    <script src="{{asset('assets/js/top.js')}}"></script>
    <script src="{{asset('assets/js/counter.js')}}"></script>    
    <script src="{{asset('assets/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.counterup.js')}}"></script>
    <script src="{{asset('assets/js/jquery.isotope.pkgd.js')}}"></script>
    <script src="{{asset('assets/js/filter.js')}}"></script>
    <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets/js/magnific.popup.gallery.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
        @if(session()->get( 'invoice' ))
          <script>
           $('#paymentSuccess').modal('show');
        </script>
        @endif
    @if(Request::path() == 'booking')
    <script src="{{asset('js/app.js')}}"></script>
    @endif
  <script>
      var flkty = new Flickity( '.trainers-carousel', {
  cellAlign: 'left',
  contain: true,
  wrapAround: true,
  prevNextButtons: false,
  autoPlay: 2000,
verticalCells: true
});

</script>

    
    </body>
    
</html>