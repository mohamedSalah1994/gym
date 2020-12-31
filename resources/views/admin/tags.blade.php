@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.tags')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
                                <div class="row">
                                         @if(checkRole('tags.add'))
                                <div class="col-lg-6">
                                    <form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('tags.add')}}">
                                        
										<div class="m-portlet__body">
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
											<div class="form-group m-form__group">
												<label for="name">
													{{__('admin.tag_name')}}
												</label>
												
											<input type="text" class="form-control m-input" id="name" name="name">
											</div>
										
										</div>
										<div class="m-portlet__foot m-portlet__foot--fit">
											<div class="m-form__actions">
												<button type="submit" class="btn btn-primary">
													{{__('admin.save')}}
												</button>
												<button type="reset" class="btn btn-secondary">
													{{__('admin.cancel')}}
												</button>
											</div>
										</div>
									</form>
                                    </div>
                                    @endif
                                <div class="col-lg-6">
                                    <table class="table m-table m-table--head-bg-brand">
											<thead>
												<tr>
													<th>
														#
													</th>
													<th>
														{{__('admin.tag')}}
													</th>
													<th>
														{{__('admin.tag_created')}}
													</th>
												
												</tr>
											</thead>
											<tbody>
                                                @foreach($tags as $tag)
												<tr>
													<th scope="row">
														{{$loop->iteration}}
													</th>
													<td>
														{{$tag->name}}
													</td>
													<td>
												        {{\Carbon\Carbon::parse($tag->created_at)->format('d-m-yy')}}
													</td>
												
												</tr>
												@endforeach
											</tbody>
										</table>
                                    </div>
                                </div>
								
							</div>
						</div>
					</div>
@endsection