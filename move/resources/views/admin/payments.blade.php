@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.payments')}}
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
                                                @if(checkRole('export.payment'))
                                                	<div class="col-lg-6">
											<div class="input-daterange input-group" id="m_datepicker_5">
												<input type="text" class="form-control m-input" name="start" />
												<span class="input-group-addon">
													<i class="la la-ellipsis-h"></i>
												</span>
												<input type="text" class="form-control" name="end" />
											</div>
										</div>
                                                <div class="col-lg-2 order-1 order-xl-2 m--align-right">
                                                <div class="dropdown">
																	<button class="btn btn-brand dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		{{__('admin.export')}}
																	</button>
																	<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
																		<a class="dropdown-item" id="export" style="cursor:pointer">
																			<i class="fa fa-file-excel-o"></i>
																			Excel
																		</a>
																		
																	</div>
																</div>
                                                </div>
                                                @endif
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
												{{__('admin.user')}}
											</th>
										
											<th title="Field #4">
												{{__('admin.user identity')}}
											</th>
                                         
											<th title="Field #5">
												{{__('admin.qty')}}
											</th>
                                            <th title="Field #5">
												{{__('admin.subscription from')}}
											</th>
                                              <th title="Field #5">
												{{__('admin.subscription to')}}
											</th>
                                            
											<th title="Field #6">
												{{__('admin.paymentWay')}}
											</th>
                                            	<th title="Field #6">
												{{__('admin.moderator name')}}
											</th>
                                             @if(checkRole('payment.print'))
                                            	<th title="Field #6">
												{{__('admin.options')}}
											</th>
                                            @endif
                                          
										</tr>
									</thead>
									<tbody>
                                        @foreach($payments as $payment)
										<tr>
										
                                            <td>
								                {{$payment->userObj->name}}
											</td>
                                             <td>
								                {{$payment->userObj->identity}}
											</td>
                                          
                                             <td>
								                {{$payment->amount}} / {{__('main.coin')}}
											</td>
                                             <td>
								                {{\Carbon\Carbon::parse($payment->created_at)->format('d-m-Y')}} 
											</td>
                                             <td>
								                {{\Carbon\Carbon::parse($payment->created_at)->addDays($payment->planOb->price)->format('d-m-Y')}} 
											</td>
                                             <td>
								                {{$payment->paid}} 
											</td>
                                              <td>
								                {{$payment->adminOb->name ?? 'tap'}} 
											</td>
                                             @if(checkRole('payment.print'))
                                             <td>
								              <a href="{{route('payment.print',$payment->id)}}"><i  class="fa fa-print printPayment"></i></a> 
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
@section('footer')
<script>
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
   $('#m_datepicker_5').datepicker({
            todayHighlight: true,
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
        });
    $('#export').click(function(){
        var start = $("input[name='start']").val();
        var end = $("input[name='end']").val();
        if(start != '' && end != ''){
                     $.ajax({
             type:'POST',
             url:'{!! route("export.payment") !!}',
             data:{ start : start , end : end},
             success:function(data){
            if(data.status == 'done'){
                window.location.href = '{!! route("export.payment.download") !!}';
            }
                 console.log(data);
             }
      });
        }
    
    });
</script>
@endsection