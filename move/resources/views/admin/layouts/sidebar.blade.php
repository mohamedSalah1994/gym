	<!-- BEGIN: Aside Menu -->
	<div 
		id="m_ver_menu" 
		class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " 
		data-menu-vertical="true"
		 data-menu-scrollable="false" data-menu-dropdown-timeout="500"  
		>
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
							@if(checkRole('main'))
                            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true" >
								<a  href="{{route('main')}}" class="m-menu__link ">
									<i class="m-menu__link-icon flaticon-line-graph"></i>
									<span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{__('admin.dashboard')}}
											</span>
<!--
											<span class="m-menu__link-badge">
												<span class="m-badge m-badge--danger">
													2
												</span>
											</span>
-->
										</span>
									</span>
								</a>
							</li>
                            @endif
							<li class="m-menu__section">
								<h4 class="m-menu__section-text">
									{{__('admin.Components')}}
								</h4>
								<i class="m-menu__section-icon flaticon-more-v3"></i>
							</li>
                              @if(checkRole('slider') || checkRole('home.section.two') || checkRole('services') || checkRole('trainers') || checkRole('opinions') || checkRole('gallery'))
							<li class="m-menu__item  @if(Request::is('admin/slider') || Request::is('admin/slider/*') || Request::is('admin/traniners') || Request::is('admin/traniners/*') || Request::is('admin/opinions') || Request::is('admin/opinions/*') || Request::is('admin/gallery') || Request::is('admin/gallery/*') || Request::is('admin/services') || Request::is('admin/services/*')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.front end')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
                                        @if(checkRole('slider'))
                                         <li class="m-menu__item  @if(Request::is('admin/slider')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('slider')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.slider')}}
												</span>
											</a>
										</li>
                                        @endif
                                         @if(checkRole('home.section.two'))
                                          <li class="m-menu__item  @if(Request::is('admin/section/two')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('home.section.two')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.secondsection')}}
												</span>
											</a>
										</li>
                                        @endif
                                          @if(checkRole('services'))
                                           <li class="m-menu__item  @if(Request::is('admin/services') || Request::is('admin/services/add')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('services')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.services')}}
												</span>
											</a>
										</li>
                                        @endif
                                          @if(checkRole('trainers'))
										<li class="m-menu__item @if(Request::is('admin/trainers')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('trainers')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.traniners')}}
												</span>
											</a>
										</li>
                                         @endif
                                          @if(checkRole('opinions'))
                                        <li class="m-menu__item @if(Request::is('admin/opinions')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('opinions')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.opinions')}}
												</span>
											</a>
										</li>
                                         @endif
                                          @if(checkRole('gallery'))
                                           <li class="m-menu__item @if(Request::is('admin/gallery')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('gallery')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.gallery')}}
												</span>
											</a>
										</li>
                                        @endif
								
									</ul>
								</div>
							</li>
                            @endif
                                  @if(checkRole('contact.info'))
                            	<li class="m-menu__item  m-menu__item--submenu  @if(Request::is('admin/contact')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.contact info')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
                                      
                                          @if(checkRole('contact.info'))
										<li class="m-menu__item @if(Request::is('admin/contact')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('contact.info')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.contact info')}}
												</span>
											</a>
										</li>
								@endif
									</ul>
								</div>
							</li>
                            @endif
                             @if(checkRole('categories') || checkRole('tags') || checkRole('posts'))
                                	<li class="m-menu__item  m-menu__item--submenu  @if(Request::is('admin/posts') || Request::is('admin/categories') || Request::is('admin/tags')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.blogs')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									
                                          @if(checkRole('categories'))
										<li class="m-menu__item @if(Request::is('admin/categories')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('categories')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.categories')}}
												</span>
											</a>
										</li>
                                         @endif
                                          @if(checkRole('tags'))
                                        <li class="m-menu__item @if(Request::is('admin/tags')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('tags')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.tags')}}
												</span>
											</a>
										</li>
                                         @endif
                                          @if(checkRole('posts'))
                                          <li class="m-menu__item @if(Request::is('admin/posts')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('posts')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.posts')}}
												</span>
											</a>
										</li>
								 @endif
                                       
									</ul>
								</div>
							</li>
                            @endif
                            @if(checkRole('bookings'))
                            <li class="m-menu__item  m-menu__item--submenu  @if(Request::is('admin/bookings')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.bookings')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									
                                          @if(checkRole('bookings'))
										<li class="m-menu__item @if(Request::is('admin/bookings')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('bookings')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.bookings')}}
												</span>
											</a>
										</li>
                        @endif
                                         
								
									</ul>
								</div>
							</li>
                            @endif
                             @if(checkRole('subscriptions') || checkRole('subscriptions.add'))
                                	<li class="m-menu__item  m-menu__item--submenu @if(Request::is('admin/subscriptions') || Request::is('admin/subscriptions/*')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.subscriptions')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
								
                                          @if(checkRole('subscriptions'))
										<li class="m-menu__item  @if(Request::is('admin/subscriptions')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('subscriptions')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.subscriptions')}}
												</span>
											</a>
										</li>
                                         @endif
                                          @if(checkRole('subscriptions.add'))
                                        <li class="m-menu__item  @if(Request::is('admin/subscriptions/add')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('subscriptions.add')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.addSubscription')}}
												</span>
											</a>
										</li>
								 @endif
                                         
									</ul>
								</div>
							</li>
                            @endif
                            @if(checkRole('payments'))
                            <li class="m-menu__item  m-menu__item--submenu @if(Request::is('admin/payments')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.payments')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									 
                                        @if(checkRole('payments'))
										<li class="m-menu__item  @if(Request::is('admin/payments')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('payments')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.payments')}}
												</span>
											</a>
										</li>
                                
								@endif
									</ul>
								</div>
							</li>
                          @endif
                             @if(checkRole('users') || checkRole('user.add.show'))
                            <li class="m-menu__item  m-menu__item--submenu @if(Request::is('admin/users') || Request::is('admin/users/*')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.users')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									   @if(checkRole('users'))
										<li class="m-menu__item @if(Request::is('admin/users')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('users')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.users')}}
												</span>
											</a>
										</li>
                                        @endif
                                           @if(checkRole('user.add.show'))
                                        	<li class="m-menu__item @if(Request::is('admin/users/add')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('user.add.show')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.addusers')}}
												</span>
											</a>
										</li>
								@endif
									</ul>
								</div>
							</li>
                            @endif
                              {{--       <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.reports')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
										<li class="m-menu__item  m-menu__item--parent" aria-haspopup="true" >
											<a  href="#" class="m-menu__link ">
												<span class="m-menu__link-text">
													Base
												</span>
											</a>
										</li>
										<li class="m-menu__item " aria-haspopup="true" >
											<a  href="components/base/state.html" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													State Colors
												</span>
											</a>
										</li>
								
									</ul>
								</div>
							</li>--}}
                            @if(checkRole('plans') || checkRole('plans.add'))
                             <li class="m-menu__item  m-menu__item--submenu  @if(Request::is('admin/plans') || Request::is('admin/plans/*')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.plans')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									@if(checkRole('plans'))
										<li class="m-menu__item @if(Request::is('admin/plans')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('plans')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.plans')}}
												</span>
											</a>
										</li>
                                        @endif
                                        @if(checkRole('plans.add'))
                                        	<li class="m-menu__item @if(Request::is('admin/plans/add')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('plans.add')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.addPlan')}}
												</span>
											</a>
										</li>
								@endif
									</ul>
								</div>
							</li>
                            @endif
                             @if(checkRole('moderators') || checkRole('roles'))
                                <li class="m-menu__item  m-menu__item--submenu  @if(Request::is('admin/moderators') || Request::is('admin/moderators/*') || Request::is('admin/roles') || Request::is('admin/roles/*')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.roles')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
                                         @if(checkRole('moderators'))
										<li class="m-menu__item @if(Request::is('admin/moderators')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('moderators')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.allmoderators')}}
												</span>
											</a>
										</li>
                                        @endif
                                         @if(checkRole('roles'))
										<li class="m-menu__item @if(Request::is('admin/roles')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('roles')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.roles')}}
												</span>
											</a>
										</li>
								@endif
									</ul>
								</div>
							</li>
                            @endif
                            	   @if(checkRole('main.settings'))
                                     <li class="m-menu__item  m-menu__item--submenu  @if(Request::is('admin/settings')) m-menu__item--submenu m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"  data-menu-submenu-toggle="hover">
								<a  href="#" class="m-menu__link m-menu__toggle">
									<i class="m-menu__link-icon flaticon-layers"></i>
									<span class="m-menu__link-text">
										{{__('admin.mainSettings')}}
									</span>
									<i class="m-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="m-menu__submenu">
									<span class="m-menu__arrow"></span>
									<ul class="m-menu__subnav">
									   @if(checkRole('main.settings'))
										<li class="m-menu__item @if(Request::is('admin/settings')) m-menu__item--active @endif" aria-haspopup="true" >
											<a  href="{{route('main.settings')}}" class="m-menu__link ">
												<i class="m-menu__link-bullet m-menu__link-bullet--dot">
													<span></span>
												</i>
												<span class="m-menu__link-text">
													{{__('admin.mainSettings')}}
												</span>
											</a>
										</li>
								   @endif
									</ul>
								</div>
							</li>
                               @endif
                            
                            
			</ul>
					</div>
					<!-- END: Aside Menu -->