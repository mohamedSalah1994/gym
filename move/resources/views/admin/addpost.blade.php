@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.addpost')}}
								</h3>
							
							</div>
						
						</div>
					</div>
					<!-- END: Subheader -->
					<div class="m-content">
					
						<div class="m-portlet m-portlet--mobile">
							<div class="m-portlet__body">
								<form class="m-form m-form--fit m-form--label-align-right" method="post" action="{{route('post.insert')}}" enctype="multipart/form-data">
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
													{{__('admin.post_title')}}
												</label>
												<input type="text" class="form-control m-input" id="name" name="title">
											
											</div>
											<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.post_cat')}}
												</label>
                                    <select class="form-control m-select2" id="post_cats" name="cats[]" multiple="multiple">
                                        @foreach($categories as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                        @endforeach
                                                                </select>
                                                                </div>
                                            	<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.post_tag')}}
												</label>
                                    <select class="form-control m-select2" id="post_tags" name="tags[]" multiple="multiple">
                                        @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                                                </select>
                                                                </div>
                                            <div class="form-group m-form__group">
												<label for="name">
													{{__('admin.post_image')}}
												</label>
												
											<input type="file"  class="form-control m-input" id="image_post" name="image">
											</div>
                                            	<div class="form-group m-form__group">
												<label for="email">
													{{__('admin.post_content')}}
												</label>
                               <textarea name="content" id="content"     
     class="summernote"></textarea>
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
						</div>
					</div>
@endsection