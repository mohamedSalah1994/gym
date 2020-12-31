@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.gallery')}}
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
                                         @if(checkRole('gallery.add'))
										<div class="col-xl-4 order-1 order-xl-2 m--align-right">
											<a href="{{route('gallery.add')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-cart-plus"></i>
													<span>
														{{__('admin.newGalleryAdd')}}
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
												{{__('admin.Gallery name')}}
											</th>
                                                @if(checkRole('gallery.edit') || checkRole('gallery.images.show'))
                                            <th title="Field #7">
												{{__('admin.options')}}
											</th>
                                            @endif
										</tr>
									</thead>
									<tbody>
                                        @foreach($gallery_categories as $gallery_category)
										<tr>
											<td>
								                {{$loop->iteration}}
											</td>
											<td>
												{{$gallery_category->name}}
											</td>
                                            @if(checkRole('gallery.edit') || checkRole('gallery.images.show'))
                                            <td>
                                                 @if(checkRole('gallery.edit'))
                                             <a href="{{route('gallery.edit',$gallery_category->id)}}"><i class="flaticon-edit"></i></a>
                                                @endif
                                                 @if(checkRole('gallery.images.show'))
                                             <a href="{{route('gallery.images.show',$gallery_category->id)}}"><i class="flaticon-web"></i></a>
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