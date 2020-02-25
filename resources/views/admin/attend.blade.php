@extends('layouts.app')

@section('content')
<div class="container-fluid">
  @include('layouts.icon')
  <div class="row">
    <div class="col-md-12">
      <div class="panel-group">
        <div class="panel panel-default panel-table">
          <div class="panel-heading" data-toggle="collapse" data-target="#summary">
            <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><a
                href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right"
                aria-hidden="true"></span>Attendance Summary<a class="pull-right" href="{{route('admin_attend_full')}}"
                role="button" target="_blank"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></a>
            </h3>
          </div>
          <div id="summary" class="panel-collapse collapse in">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item list-group-item-info text-center">Family Only</li>
                    <li class="list-group-item">Adult <span class="badge">{{$count['adult']}}</span></li>
                    <li class="list-group-item">Kids <span class="badge">{{$count['kids']}}</span></li>
                    <li class="list-group-item">Infant <span class="badge">{{$count['infant']}}</span></li>
                    <li class="list-group-item list-group-item-info">Total <span class="badge">{{$count['all']}}</span>
                    </li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item list-group-item-success text-center">Others</li>
                    <li class="list-group-item">Adult <span class="badge">{{$count['others_adult']}}</span></li>
                    <li class="list-group-item">Kids <span class="badge">{{$count['others_kids']}}</span></li>
                    <li class="list-group-item">Infant <span class="badge">{{$count['others_infant']}}</span></li>
                    <li class="list-group-item list-group-item-success">Total <span
                        class="badge">{{$count['others_total']}}</span></li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item active text-center">Attendance</li>
                    <li class="list-group-item">Attended <span class="badge">{{$attendance['yes']}}</span></li>
                    <li class="list-group-item">Not Yet <span class="badge badge-primary">{{$attendance['no']}}</span>
                    </li>
                    <li class="list-group-item active">Total <span class="badge ">{{$count['total']}}</span></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <a
                href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right"
                aria-hidden="true"></span>Attendance Management</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table id="participants-table" class="table">
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Staff Id</th>
                    <th>Attend</th>
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

    .sorting_disabled {
      padding-right: 0;
    }
  </style>
  @endpush

  @push('scripts')
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
var table = $('#participants-table').DataTable({
    processing: true,
    serverSide: false,
    pagingType: "numbers",
     "order": [],
    language: {zeroRecords: "Registration not found. Only paid registration will be shown here." },
    ajax: '{{route('admin_attend_ajax')}}',
    createdRow: function( row, data, dataIndex ) {
      if ( $(row).hasClass('member') ) {
        $( row ).find('td:eq(3)').append('&nbsp;<span class="glyphicon glyphicon-user"  title="Member of Kelab TM Ibu Pejabat"></span>');
      }
      if ( $(row).hasClass('attend') ) {
        $( row ).find('td:eq(4)').html('<span class="glyphicon glyphicon-ok" title="QR code already scanned"></span>');
      }
    },
    columns: [
        {data: null, defaultContent: '', className:'details-control',orderable: false, searchable:false},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'staff_id', name: 'staff_id'},
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