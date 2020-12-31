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
    jQuery(document).ready(function() {
 var datatable = $('.m_datatable-ajax').mDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            // sample GET method
            method: 'GET',
            url: '{!! route("payments") !!}',
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
          textAlign: 'center',
              template: function(row) {
             return row.user_obj.name;
          }
        },
             {
          field : 'identity' ,     
          title: "{!! __('admin.user identity') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return row.user_obj.identity;
          }
        },
                 {
          field : 'qty' ,     
          title: "{!! __('admin.qty') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return row.amount + ' / ' + "{!! __('admin.coin') !!}";
          }
        },
                  {
          field : 'subscription_from' ,     
          title: "{!! __('admin.subscription from') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return  moment(row.created_at).format('YYYY-MM-DD');
          }
        },
                  {
          field : 'subscription_to' ,     
          title: "{!! __('admin.subscription to') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return  moment(row.created_at).add(row.plan_ob.days, 'days').format('YYYY-MM-DD');
          }
        },
                  {
          field : 'paymentWay' ,     
          title: "{!! __('admin.paymentWay') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return row.paid;
          }
        },
                    {
          field : 'moderator_name' ,     
          title: "{!! __('admin.moderator name') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return (row.admin_ob) ? row.admin_ob.name : 'tap';
          }
        },
                      {
          field : 'options' ,     
          title: "{!! __('admin.options') !!}",
          sortable: false, // disable sort for this column
     
          selector: false,
          textAlign: 'center',
              template: function(row) {
             return '<a href="'+"{!! url('/') !!}"+'/admin/payments/print/'+row.id+'"><i class="fa fa-print printPayment"></i></a>';
          }
        },
      ],
    });
    });
</script>
@endsection