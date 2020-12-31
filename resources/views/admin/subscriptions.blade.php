@extends('admin.index')
@section('content')
  <!-- BEGIN: Subheader -->
					<div class="m-subheader ">
						<div class="d-flex align-items-center">
							<div class="mr-auto">
								<h3 class="m-subheader__title m-subheader__title--separator">
										{{__('admin.subscriptions')}}
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
										<div class="m_datatable-ajax" id="ajax_data"></div>
								<!--end: Datatable -->
							</div>
						</div>
					</div>
@endsection
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function() {
 var datatable = $('.m_datatable-ajax').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            // sample GET method
            method: 'GET',
            url: '{!! route("subscriptions") !!}',
            map: function(raw) {
              // sample data mapping
              var dataSet = raw;
              if (typeof raw.data !== 'undefined') {
                dataSet = raw.data;
              }
              return dataSet;
            },
          },
        },
        pageSize: 50,
        saveState: {
          cookie: true,
          webstorage: true,
        },
        serverPaging: true,
        serverFiltering: true,
        serverSorting: true,
      },

      // layout definition
      layout: {
        theme: 'default', // datatable theme
        class: '', // custom wrapper class
        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
        footer: false // display/hide footer
      },

      // column sorting
      sortable: true,

      pagination: true,

      toolbar: {
        // toolbar items
        items: {
          // pagination
          pagination: {
            // page size select
            pageSizeSelect: [10, 20, 30, 50, 100],
          },
        },
      },

      search: {
        input: $('#generalSearch'),
      },

      // columns definition
      columns: [
          {
          field : 'name' ,     
          title: "{!! __('admin.user name') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return row.user.name;
          }
        },
                    {
                        field : 'mobile',
          title: "{!! __('admin.user mobile') !!}",
          sortable: false, // disable sort for this column
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return row.user.mobile;
          }
        },
                      {
                          field : 'identity',
          title: "{!! __('admin.user identity') !!}",
          sortable: false, // disable sort for this column
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return row.user.identity;
          }
        },
                {
                    field : 'created_at',
          title: "{!! __('admin.subscription created') !!}",
          sortable: false, // disable sort for this column
       
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return moment(row.created_at).format('YYYY-MM-DD');
          }
        },
                      {
          field : 'start_from',
          title: "{!! __('admin.subscription start') !!}",
          sortable: false, // disable sort for this column
          
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return moment(row.start_from).format('YYYY-MM-DD');
          }
        },
                      {
                          field : 'end_to',
          title: "{!! __('admin.subscription end') !!}",
          sortable: false, // disable sort for this column
    
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return  moment(row.end_to).format('YYYY-MM-DD');
          }
        },
                        {
                            field: 'main_price',
          title: "{!! __('admin.plan price') !!}",
          sortable: false, // disable sort for this column
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return row.main_price + ' / ' + "{!! __('admin.coin') !!}";
          }
        },
                       {
                            field: 'options',
          title: "{!! __('admin.options') !!}",
          sortable: false, // disable sort for this column
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return '<a href="'+"{!! url('/') !!}"+'/admin/subscriptions/edit/'+row.id+'"><i class="flaticon-edit"></i></a><a href="'+"{!! url('/') !!}"+'/admin/subscriptions/remove/'+row.id+'"><i class="la la-trash-o trashStyle"></i></a>';
          }
        },
          
      ],
    });
    });
</script>
@endsection