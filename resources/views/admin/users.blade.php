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
					 @if(session()->has('message'))
     <div class="alert alert-success danger-errors">
      <p>{{session()->get('message')}}</p>
    </div>
    @endif
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
                                         @if(checkRole('user.add.show'))
										<div class="col-xl-4 order-1 order-xl-2 m--align-right">
											<a href="{{route('user.add.show')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-cart-plus"></i>
													<span>
														{{__('admin.newUserAdd')}}
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
												#
											</th>
											<th title="Field #2">
												{{__('admin.user name')}}
											</th>
										
											<th title="Field #4">
												{{__('admin.user identity')}}
											</th>
                                            
											<th title="Field #5">
												{{__('admin.user mobile')}}
											</th>
                                            <th title="Field #4">
												{{__('admin.user birth')}}
											</th>
											<th title="Field #6">
												{{__('admin.user created')}}
											</th>
                                                @if(checkRole('user.show') || checkRole('user.delete'))
                                            <th title="Field #7">
												{{__('admin.options')}}
											</th>
                                            @endif
										</tr>
									</thead>
									<tbody>
                                        @foreach($allUsers as $user)
										<tr>
											<td>
								                {{$loop->iteration}}
											</td>
											<td>
												{{$user->name}}
											</td>
										
											<td>
												{{$user->identity}}
											</td>
											<td>
												{{$user->mobile}}
											</td>
                                            <td>
												{{\Carbon\Carbon::parse($user->birth)->format('Y-m-d')}}
											</td>
											<td>
                                                {{\Carbon\Carbon::parse($user->created_at)->format('Y-m-d')}}
											</td>
                                            @if(checkRole('user.show') || checkRole('user.delete'))
                                            <td>
                                                 @if(checkRole('user.show'))
                                             <a href="{{route('user.show',$user->id)}}"><i class="flaticon-edit"></i></a>
                                                @endif
                                                 @if(checkRole('user.delete'))
                                             <a action="{{route('user.delete',$user->id)}}" class="removeUser"><i class="flaticon-delete"></i></a>
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
@section('footer')
<div class="modal" id="removeUserPop" tabindex="-1" role="dialog" aria-labelledby="removeUserPop" >
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">
											{{__('admin.removeUser')}}
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">
												×
											</span>
										</button>
									</div>
									<div class="modal-body">
										<p>{{__('admin.areyousuretodeleteUser')}}</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">
											{{__('admin.cancel')}}
										</button>
										<button type="button" class="btn btn-primary"  id="confirmed_user" style="margin-left:5px;margin-right:5px;">
											{{__('admin.confirm')}}
										</button>
									</div>
								</div>
							</div>
						</div>
<script>
$('body').on('click','.removeUser',function(e){
    e.preventDefault();
    $('#confirmed_user').attr('action',$(this).attr('action'));
    $('#removeUserPop').modal('show');
});
    $('body').on('click','#confirmed_user',function (){
        window.location.href = $(this).attr('action');
    });
</script>
@endsection