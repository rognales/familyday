@extends('layouts.app')

@section('content')
<div class="container">
  @include('layouts.icon')
    <div class="row">
        <div class="col-md-12">
          <div class="panel-group">
            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>Attendance Summary</h3>
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
                      <li class="list-group-item active text-center">Attendance</li>
                      <li class="list-group-item">Attended <span class="badge">{{$attendance['yes']}}</span></li>
                      <li class="list-group-item">Not Yet <span class="badge badge-primary">{{$attendance['no']}}</span></li>
                      <li class="list-group-item active">Total <span class="badge ">{{$count['total']}}</span></li>
                    </ul>
                  </div>

                </div>
              </div>
          </div>
          <div class="panel panel-default panel-table">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>Attendance Management</h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="participants-table" class="table">
                  <thead>
                  <tr>
                      <th rowspan="2"></th>
                      <th rowspan="2">Name</th>
                      <th rowspan="2">Email</th>
                      <th rowspan="2" class="col-sm-1">Staff Id</th>
                      <th colspan="2" class="text-center bg-info">Family</th>
                      <th colspan="2" class="text-center bg-success">Others</th>
                      <th rowspan="2">Attend</th>
                      <th rowspan="2">Action</th>
                  </tr>
                  <tr class="text-center">
                    <th class="col-sm-1">Adult</th>
                    <th class="col-sm-1">Kids</th>
                    <th class="col-sm-1">Adult</th>
                    <th class="col-sm-1">Kids</th>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css" integrity="sha256-PbaYLBab86/uCEz3diunGMEYvjah3uDFIiID+jAtIfw=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"  type="text/css" >
<style type="text/css" class="init">
  td.details-control {
  	background: url('{{ asset('images/details_open.png') }}') no-repeat center center;
  	cursor: pointer;
  }
  tr.shown td.details-control {
  	background: url('{{ asset('images/details_close.png') }}') no-repeat center center;
  }
  .sorting_disabled{
    padding-right: 0;
  }
	</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js" integrity="sha256-qcV1wr+bn4NoBtxYqghmy1WIBvxeoe8vQlCowLG+cng=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js" integrity="sha256-X/58s5WblGMAw9SpDtqnV8dLRNCawsyGwNqnZD0Je/s=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js" integrity="sha256-lsnwFhrNhbBmHfkBv9qFeiUVHti2+DmL0F1K5pysQsM=" crossorigin="anonymous"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
@verbatim
<script id="details-template" type="text/x-handlebars-template">
        <div class="label label-info"></div>
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
var date = new Date();
var today = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();
var table = $('#participants-table').DataTable({
    processing: true,
    serverSide: false,
    pagingType: "numbers",
     "order": [],
    dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: "Attendance Summary (As of " + today + ")",
                exportOptions: {
                    columns: [1,2,3,4,5,6,7]
                }
            },
            {
                extend: 'pdfHtml5',
                messageTop: "Attendance Summary (As of " + today + ")",
                exportOptions: {
                    columns: [1,2,3,4,5,6,7]
                }
            },
            ,
            {
                extend: 'print',
                messageTop: "Attendance Summary (As of " + today + ")",
                exportOptions: {
                    columns: [1,2,3,4,5,6,7]
                }
            }
        ],
    language: {zeroRecords: "Registration not found. Only paid registration will be shown here." },
    ajax: '{{route('admin_attend_full_ajax')}}',
    createdRow: function( row, data, dataIndex ) {
      if ( $(row).hasClass('member') ) {
        $( row ).find('td:eq(3)').append('&nbsp;<span class="glyphicon glyphicon-user"  title="Member of Kelab TM Ibu Pejabat"></span>');
      }
      if ( $(row).hasClass('attend') ) {
        $( row ).find('td:eq(8)').html('<span class="glyphicon glyphicon-ok" title="QR code already scanned"></span>');
      }
    },
    columns: [
        {data: null, defaultContent: '', className:'details-control',orderable: false, searchable:false},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'staff_id', name: 'staff_id'},
        {data: 'adults_family_count', name: 'family_adult', className: 'text-center', orderable: false, searchable:false},
        {data: 'kids_family_count', name: 'family_kids', className: 'text-center', orderable: false, searchable:false},
        {data: 'others_adults_count', name: 'others_adult', className: 'text-center', orderable: false, searchable:false},
        {data: 'others_kids_count', name: 'others_kids', className: 'text-center', orderable: false, searchable:false},
        {data: null, defaultContent: '',className:'text-center',orderable: false, searchable:false},
        {data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false}
      ]
  });

// Add event listener for opening and closing details
$('#participants-table tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
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
