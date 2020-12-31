<!-- begin::Footer -->
			<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                              @php
        $title = \App\settings::where('key','site_title')->first();
        @endphp
            
							<span class="m-footer__copyright" style="text-align:center;display: block;">
								© {{\Carbon\Carbon::now()->format('yy')}} -  {{$title->value ?? ''}}
							</span>
						</div>
					
					</div>
				</div>
			</footer>
			<!-- end::Footer -->
		</div>
		<!-- end:: Page -->
    		        <!-- begin::Quick Sidebar -->
		
		<!-- end::Quick Sidebar -->		    
	    <!-- begin::Scroll Top -->
		<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- begin::Quick Nav -->	
    	<!--begin::Base Scripts -->
		<script src="{{asset('admin_assets/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('admin_assets/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
		<!--end::Base Scripts -->   
        <!--begin::Page Vendors -->
		<script src="{{asset('admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
		<!--end::Page Vendors -->  
        <!--begin::Page Snippets -->
		<script src="{{asset('admin_assets/assets/demo/default/custom/components/datatables/base/html-table.js')}}" type="text/javascript"></script>


       <script>
            $('#subscription_edit_pick').datepicker({
            todayHighlight: true,
            orientation: "bottom left",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
                autoclose: true,
                format: 'dd-mm-yyyy',
                startDate : '+1d'
        });
           $('.summernote').summernote({
            height: 150, 
               fontNames: ['Cairo']
        });
            function formatRepo(repo) {
            if (repo.loading) return '{!! __("admin.Searching") !!}';
            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.name + "</div>";
            return markup;
        }
             function formatRepoSelection(repo) {
            return repo.name || repo.text;
        }
       $("#add_user_subscription").select2({
            placeholder: '{!! __('admin.chooseUser') !!}',
            allowClear: false,
            ajax: {
                url: $('#add_user_subscription').attr('action'),
                method : 'POST',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        _token : '{!! csrf_token() !!}'
                    };
                },
                processResults: function(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
            ,
                language: {
                  // You can find all of the options in the language files provided in the
                  // build. They all must be functions that return the string that should be
                  // displayed.
                  inputTooShort: function () {
                    return '{!! __('admin.enterUserNameorEmailormobile') !!}';
                  }
                }
        });
            $('#post_cats').select2({
            placeholder: '{!! __("admin.choose_cat")!!}',
        });
              $('#post_tags').select2({
            placeholder: '{!! __("admin.choose_tag")!!}',
        });
            $('#work_start_at').timepicker();
               $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
           $('body').on('click' , '.bookConfirm' ,function(){
               var action = $(this).attr('action');
               var thisme = $(this);
                     $.ajax({
                 type:'POST',
                 url:action,
                 success:function(data){
                   if(data.status == 'done'){
                       thisme.after(data.message).remove();
                   }
                 }
      });
           });
</script>
@yield('footer')
		<!--end::Page Snippets -->
	</body>
	<!-- end::Body -->
</html>
