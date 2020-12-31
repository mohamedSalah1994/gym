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
										<div class="m_datatable-ajax" id="ajax_data"></div>
								<!--end: Datatable -->
							</div>
						</div>
					</div>
@endsection
@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>
<script>
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

  
    jQuery(document).ready(function() {
 var datatable = $('.m_datatable-ajax').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            // sample GET method
            method: 'GET',
            url: '{!! route("bookings") !!}',
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
          title: "{!! __('admin.user') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'right',
              template: function(row) {
             return row.user.name;
          }
        },
             {
          field : 'identity' ,     
          title: "{!! __('admin.user identity') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'right',
              template: function(row) {
             return row.user.identity;
          }
        },
          {
          field : 'mobile' ,     
          title: "{!! __('admin.user mobile') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'right',
              template: function(row) {
             return row.user.mobile;
          }
        },
           {
          field : 'book_day' ,     
          title: "{!! __('admin.book day') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'right',
              template: function(row) {
             return moment(row.day).format('YYYY-MM-DD');
          }
        },
           {
          field : 'book_from' ,     
          title: "{!! __('admin.book from') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'right',
              template: function(row) {
             return moment(row.from).format('hh:mm A');
          }
        },
            {
          field : 'book_to' ,     
          title: "{!! __('admin.book to') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'right',
              template: function(row) {
             return moment(row.to).format('hh:mm A');
          }
        },
            {
          field : 'status' ,     
          title: "{!! __('admin.book status') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'right',
              template: function(row) {
                  
            if(moment().format('YYYY-MM-DD') == moment(row.day).format('YYYY-MM-DD')){
                 if(row.status == 0){
                     return ' <button type="button" class="btn btn-primary btn-sm cairo bookConfirm" action="'+"{!! url('/')!!}"+'/admin/bookings/confirm/'+row.id+'">'+"{!! __('admin.book confirm') !!}"+'</button>';
                 }
                  else if(row.status == 1){
                      return "{!!  __('admin.book confirmed') !!}";
                  }
                   else if(row.status == 2){
                      return "{!! __('admin.book cancled') !!}";
                  }
                  }else if(moment().isAfter(moment(row.day))){
                       if(row.status == 0){
                      return "{!!  __('admin.book notconfirmed') !!}";
                  }
                     else if(row.status == 1){
                      return "{!!  __('admin.book confirmed') !!}";
                  }
                   else if(row.status == 2){
                      return "{!! __('admin.book cancled') !!}";
                  } 
                }
          }
        },
          
      ],
    });
    });
</script>
@endsection