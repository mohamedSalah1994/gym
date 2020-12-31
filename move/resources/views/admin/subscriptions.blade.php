@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.users')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
                                    @if(session()->has('message'))
     <div class="alert alert-success danger-errors">
      <p>{{session()->get('message')}}</p>
    </div>
    @endif
								<!--begin: Search Form -->
								<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
									<div class="row align-items-center">
										<div class="col-xl-8 order-2 order-xl-1">
											<div class="form-group m-form__group row align-items-center">
												
												<div class="col-md-4">
													<div class="m-input-icon m-input-icon--left">
														<input type="text" class="form-control m-input m-input--solid" placeholder="{{__('admin.searchTxt')}}" id="generalSearch">
														<span class="m-input-icon__icon m-input-icon__icon--left">
															<span>
																<i class="la la-search"></i>
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>
                                        @if(checkRole('subscriptions.add'))
										<div class="col-xl-4 order-1 order-xl-2 m--align-right">
											<a href="{{route('subscriptions.add')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-cart-plus"></i>
													<span>
														{{__('admin.addSubscription')}}
													</span>
												</span>
											</a>
											<div class="m-separator m-separator--dashed d-xl-none"></div>
										</div>
                                        @endif
									</div>
								</div>
								<!--end: Search Form -->
		<!--begin: Datatable -->
										<table class="m-datatable" id="html_table" width="100%">
									<thead>
										<tr>
											<th title="Field #1">
												{{__('admin.user name')}}
											</th>
												<th title="Field #1">
												{{__('admin.user mobile')}}
											</th>
												<th title="Field #1">
												{{__('admin.user identity')}}
											</th>
											
											<th title="Field #2">
												{{__('admin.subscription created')}}
											</th>
											<th title="Field #3">
												{{__('admin.subscription start')}}
											</th>
											<th title="Field #4">
												{{__('admin.subscription end')}}
											</th>
											<th title="Field #5">
												{{__('admin.plan price')}}
											</th>
                                            @if(checkRole('subscriptions.edit') || checkRole('subscriptions.remove'))
                                            <th title="Field #6">
												{{__('admin.options')}}
											</th>
                                            @endif
										</tr>
									</thead>
									<tbody>
                                        @foreach($allSubscriptions as $subscription)
										<tr>
											<td>
								                {{$subscription->User->name}}
											</td>
												<td>
								                {{$subscription->User->mobile}}
											</td>
												<td>
								                {{$subscription->User->identity}}
											</td>
											<td>
												{{\Carbon\Carbon::parse($subscription->created_at)->format('d-m-Y')}}
											</td>
											<td>
												{{\Carbon\Carbon::parse($subscription->start_from)->format('d-m-Y')}}
											</td>
											<td>
												{{\Carbon\Carbon::parse($subscription->end_to)->format('d-m-Y')}}
											</td>
											<td>
												{{$subscription->main_price}} / {{__('admin.coin')}}
											</td>
                                               @if(checkRole('subscriptions.edit') || checkRole('subscriptions.remove'))
                                            <td>
                                                     @if(checkRole('subscriptions.edit'))
                                            <a href="{{route('subscriptions.edit',$subscription->id)}}"><i class="flaticon-edit"></i></a>
                                                @endif
                                                     @if(checkRole('subscriptions.remove'))
                                            <a href="{{route('subscriptions.remove',$subscription->id)}}"><i style="font-size: 24px;
    position: relative;
    top: 2px;
    text-decoration: none;" class="la la-trash-o"></i></a>
                                                @endif
                                            </td>
                                            @endif
										</tr>
									@endforeach

									</tbody>
								</table>
								<!--end: Datatable -->
							</div>
						</div>
					</div>
@endsection