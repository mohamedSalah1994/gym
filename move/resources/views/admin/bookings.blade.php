@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.bookings')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
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
									
									</div>
								</div>
								<!--end: Search Form -->
		<!--begin: Datatable -->
										<table class="m-datatable" id="html_table" width="100%">
									<thead>
										<tr>
										
											<th title="Field #2">
												{{__('admin.user name')}}
											</th>
											<th title="Field #3">
												{{__('admin.user identity')}}
											</th>
											<th title="Field #3">
												{{__('admin.user mobile')}}
											</th>
											<th title="Field #4">
												{{__('admin.book day')}}
											</th>
											<th title="Field #5">
												{{__('admin.book from')}}
											</th>
											<th title="Field #6">
												{{__('admin.book to')}}
											</th>
                                            <th title="Field #7">
												{{__('admin.book status')}}
											</th>
										</tr>
									</thead>
									<tbody>
                        @php
                                        $bookings = \App\booking::orderBy('id','DESC')->get();
                                        @endphp

                                        @foreach($bookings as $booking)
                                        <tr>
                                       
                                        <td>{{$booking->User->name}}</td>
                                        <td>{{$booking->User->identity}}</td>
                                          <td>{{$booking->User->mobile}}</td>
                                        <td>{{$booking->day}}</td>
                                        <td>{{\Carbon\Carbon::parse($booking->from)->format('h:s a')}}</td>
                                        <td>{{\Carbon\Carbon::parse($booking->to)->format('h:s a')}}</td>
                                        <td>
                                            
                                            @if( \Carbon\Carbon::now()->format('yy-m-d') == \Carbon\Carbon::parse($booking->day)->format('yy-m-d') )
                                               @if($booking->status == 0)
                                                    @if(checkRole('booking.confirm'))
                                                 <button type="button" class="btn btn-primary btn-sm cairo bookConfirm" action="{{route('booking.confirm',$booking->id)}}">
                                                            {{__('admin.book confirm')}}
                                                        </button>
                                                @endif
                                                @elseif($booking->status == 1)
                                                       {{__('admin.book confirmed')}}
                                                @elseif($booking->status == 2)
                                                   {{__('admin.book cancled')}}
                                              @endif
                                            @elseif( \Carbon\Carbon::now()->format('Y-m-d') > \Carbon\Carbon::parse($booking->day)->format('Y-m-d'))
                                               @if($booking->status == 0)
                                                    {{__('admin.book notconfirmed')}}
                                                @elseif($booking->status == 1)
                                                       {{__('admin.book confirmed')}}
                                                @elseif($booking->status == 2)
                                                   {{__('admin.book cancled')}}
                                              @endif
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
									</tbody>
								</table>
								<!--end: Datatable -->
							</div>
						</div>
					</div>
@endsection