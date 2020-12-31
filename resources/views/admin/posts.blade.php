@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.posts')}}
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
                                        @if(checkRole('post.add.show'))
										<div class="col-xl-4 order-1 order-xl-2 m--align-right">
											<a href="{{route('post.add.show')}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
												<span>
													<i class="la la-cart-plus"></i>
													<span>
														{{__('admin.addpost')}}
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
												{{__('admin.post_title')}}
											</th>
											<th title="Field #2">
												{{__('admin.categories')}}
											</th>
											<th title="Field #3">
												{{__('admin.tags')}}
											</th>
											<th title="Field #4">
												{{__('admin.post_created')}}
											</th>
											<th title="Field #5">
												{{__('admin.post_updated')}}
											</th>
                                             @if(checkRole('post.edit'))
                                            <th title="Field #6">
												{{__('admin.options')}}
											</th>
                                            @endif
										</tr>
									</thead>
									<tbody>
                                        @foreach($allposts as $post)
										<tr>
											<td>
								                {{$post->title}}
											</td>
											<td>
                                                @foreach($post->post_cats as $post_cat)
												  <span>{{$post_cat->cat_obj->name}}</span>
                                                @endforeach
											</td>
											<td>
												    @foreach($post->post_tags as $post_tag)
												  <span>{{$post_tag->tag_obj->name}}</span>
                                                @endforeach
											</td>
											<td>
												  {{\Carbon\Carbon::parse($post->created_at)->format('d-m-Y')}}
											</td>
											<td>
												  {{\Carbon\Carbon::parse($post->updated_at)->format('d-m-Y')}}
											</td>
                                             @if(checkRole('post.edit'))
                                            <td>
												   <a href="{{route('post.edit',$post->id)}}"><i class="flaticon-edit"></i></a>
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