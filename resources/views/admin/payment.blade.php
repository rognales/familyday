@extends('layouts.app')

@section('content')
<div class="container-fluid">
  @include('layouts.icon')
    <div class="row">
        <div class="col-md-12">
          <div class="panel-group">
            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>Payment Summary</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-3">
                    <ul class="list-group">
                      <li class="list-group-item list-group-item-info text-center">Family Only</li>
                      <li class="list-group-item">Adult <span class="badge">{{$count['adult']}}</span></li>
                      <li class="list-group-item">Kids <span class="badge">{{$count['kids']}}</span></li>
                      <li class="list-group-item">Infant <span class="badge">{{$count['infant']}}</span></li>
                      <li class="list-group-item list-group-item-info">Total <span class="badge">{{$count['all']}}</span></li>
                    </ul>
                  </div>
                  <div class="col-md-3">
                    <ul class="list-group">
                      <li class="list-group-item list-group-item-success text-center">Others</li>
                      <li class="list-group-item">Adult <span class="badge">{{$count['others_adult']}}</span></li>
                      <li class="list-group-item">Kids <span class="badge">{{$count['others_kids']}}</span></li>
                      <li class="list-group-item">Infant <span class="badge">{{$count['others_infant']}}</span></li>
                      <li class="list-group-item list-group-item-success">Total <span class="badge">{{$count['others_total']}}</span></li>
                    </ul>
                  </div>
                  <div class="col-md-3">
                    <ul class="list-group">
                      <li class="list-group-item active text-center">Payment</li>
                      <li class="list-group-item">Paid<span class="badge">{{$payment['paid']}}</span></li>
                      <li class="list-group-item">Pending<span class="badge badge-primary">{{$payment['pending']}}</span></li>
                      <li class="list-group-item active">Total <span class="badge ">{{$count['total']}}</span></li>
                    </ul>
                  </div>
                </div>
              </div>
          </div>
          <div class="panel panel-default panel-table">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;<a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>Payment Management</h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="participants-table" class="table table-border table-responsive">
                  <thead>
                  <tr>
                      <th></th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Staff Id</th>
                      <th>Meal</th>
                      <th>Payment Status</th>
                      <th>Payment Details</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
</div>
@stop

@push('style')
<style type="text/css" class="init">
  td.details-control {
  	background: url('{{ asset('images/details_open.png') }}') no-repeat center center;
  	cursor: pointer;
  }
  tr.shown td.details-control {
  	background: url('{{ asset('images/details_close.png') }}') no-repeat center center;
  }
	</style>
@endpush

@push('scripts')

@verbatim
<script id="details-template" type="text/x-handlebars-template">
        <div class="label label-info"></div>
        {{#if payment.name}}
        <p>Payment updated by <mark>{{payment.name}}</mark> on <em>{{payment_timestamp}}</em></p>
        {{/if}}
        <table class="table details-table" id="participant-{{id}}">
            <thead>
            <tr>
                <th class="col-xs-1 bg-info">Relationship</th>
                <th class="col-xs-7 bg-info">Name</th>
                <th class="col-xs-2 bg-info">Age</th>
            </tr>
            </thead>
        </table>
    </script>
<script>
@endverbatim
var template = Handlebars.compile($("#details-template").html());

var table = $('#participants-table').DataTable({
    processing: true,
    serverSide: true,
    pagingType: "numbers",
     "order": [],
    language: {emptyTable: "Registration not found." },
    ajax: '{{route('admin_payment_ajax')}}',
    createdRow: function( row, data, dataIndex ) {
      if ( $(row).hasClass('member') ) {
        $( row ).find('td:eq(3)').append(' <span class="glyphicon glyphicon-user" title="Member of Kelab TM Ibu Pejabat"></span>');
      }},
    columns: [
        {data: null, defaultContent: '', className:'details-control', orderable: false, searchable:false},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'staff_id', name: 'staff_id'},
        {data: 'meal_option', name: 'is_vege', className: 'text-center', orderable: false},
        {data: 'payment_status', name: 'payment_status', className: 'text-center', orderable: false},
        {data: 'payment_details', name: 'payment_details', orderable: false},
        {data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false},
        {data: 'payment_by', name: 'payment_by', visible: false},
        {data: 'payment_timestamp', name: 'payment_timestamp', visible:false}
    ]
    }).on('click','.btn-edit',function (e) {
      e.preventDefault();
      pid = $(this).data('pid');
      bootbox.prompt({
        size: "small",
        title: "Payment Details ",
        buttons: {
          confirm: {
              label: 'Mark as Paid',
              className: 'btn-primary'
          },
          cancel: {
              label: 'Cancel',
              className: 'btn'
          }
        },
        inputType: 'textarea',
        callback: function(receipt){
          if (receipt === ""){}
          else if(receipt){
            $.ajax({
              url: "{{route('admin_payment_ajax_update')}}",
              method : 'POST',
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: { pid: pid, details: receipt},
              success : function (result){
                $(this).html(result);
              }
              }).always(function (data) {
                  $('table').DataTable().draw(false);
              });
          }
          }})
});

// Add event listener for opening and closing details
$('#participants-table tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var tableId = 'participant-' + row.data().id;

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        row.child( template(row.data()) ).show();
        initTable(tableId, row.data());
        tr.addClass('shown');
        tr.next().find('td').addClass('no-padding bg-gray');
    }
});

function initTable(tableId, data) {
       $('#' + tableId).DataTable({
           processing: true,
           serverSide: true,
           searching: false,
           paging: false,
           bInfo : false,
           language: {emptyTable: "No registered dependants." },
           ajax: data.details_url,
           columns: [
               { data: 'relationship', name: 'relationship' },
               { data: 'name', name: 'name' },
               { data: 'age', name: 'age' }
           ]
       })
   }
</script>
@endpush
