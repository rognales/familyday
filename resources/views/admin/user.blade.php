@extends('layouts.app')

@section('content')
<div class="container-fluid">
  @include('layouts.icon')
  <div class="row">
    <div class="col-md-12">
      <div class="panel-group">
        <div class="panel panel-default panel-table">
          <div class="panel-heading" data-toggle="collapse" data-target="#summary">
            <div class="row">
              <div class="col-sm-12">
                <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><a
                    href="{{route('admin_index')}}">Admin</a><span class="glyphicon glyphicon-chevron-right"
                    aria-hidden="true"></span>Registration Summary <a class="pull-right"
                    href="{{route('admin_user_deleted')}}" role="button" target="_blank"><i class="fa fa-trash"
                      aria-hidden="true"></i></a></h3>
              </div>
            </div>
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
                    <li class="list-group-item active text-center">Registration</li>
                    <li class="list-group-item">Members <span class="badge">{{$member['yes']}}</span></li>
                    <li class="list-group-item">Non Members<span class="badge">{{$member['no']}}</span></li>
                    <li class="list-group-item active">Total <span class="badge">{{$count['total']}}</span></li>
                  </ul>
                </div>
                <div class="col col-md-3 text-right">
                  <a href="{{route('registration_create')}}" target="_blank"><button type="button"
                      class="btn btn-success btn-create btn-block"><span class="glyphicon glyphicon-plus-sign"
                        aria-hidden="true"></span>Create New</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><a
                href="{{route('admin_index')}}">Admin</a><span class="glyphicon glyphicon-chevron-right"
                aria-hidden="true"></span>Registration List</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table id="participants-table" class="table table-condensed">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Staff Id</th>
                    <th>Uploads Count</th>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css"
  integrity="sha256-PbaYLBab86/uCEz3diunGMEYvjah3uDFIiID+jAtIfw=" crossorigin="anonymous" />
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

<script>
  var table = $('#participants-table').DataTable({
    processing: true,
    serverSide: true,
    pagingType: "numbers",
     "order": [],
    /*dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Registration Summary',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7]
                }
            },
            {
                extend: 'pdfHtml5',
                messageTop: 'Registration Summary',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7]
                }
            },
            ,
            {
                extend: 'print',
                messageTop: 'Registration Summary',
                exportOptions: {
                    columns: [1,2,3,4,5,6,7]
                }
            }
        ],*/
    ajax: '{{route('admin_user_ajax')}}',
    createdRow: function( row, data, dataIndex ) {
      if ( $(row).hasClass('member') ) {
        $(row).find('td:eq(2)').append('  <span class="glyphicon glyphicon-user" title="Member of Kelab TM Ibu Pejabat"></span>');
      }
    },
    columns: [
        //{data: null, defaultContent: '', className:'details-control',orderable: false, searchable:false},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'staff_id', name: 'staff_id'},
        {data: 'uploads_count', name: 'uploads_count', className: 'text-center',searchable: false, orderable: false},
        /*{data: 'adults_family_count', name: 'family_adults', className: 'text-center', width: "1em", orderable: false, searchable:false},
        {data: 'kids_family_count', name: 'family_kids', className: 'text-center', width: "1em", orderable: false, searchable:false},
        {data: 'infants_family_count', name: 'family_infants', className: 'text-center', width: "1em", orderable: false, searchable:false},
        {data: 'others_adults_count', name: 'others_adult', className: 'text-center', width: "1em", orderable: false, searchable:false},
        {data: 'others_kids_count', name: 'others_kids', className: 'text-center', width: "1em", orderable: false, searchable:false},
        {data: 'others_infants_count', name: 'others_infant', className: 'text-center', width: "1em", orderable: false, searchable:false},
        */{data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false}
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
        tr.addClass('shown');
        tr.next().find('td').addClass('no-padding bg-gray');
    }
}).on('click','.btn-prompt',function (e) {
  e.preventDefault();
  pid = $(this).data('pid');
  type = $(this).data('type');
  switch (type){
    case 'email':
      method = "POST";
      prompt_message = "This will resend the registration confimation email (without QR code) to the registered email address.<br />Do you want to proceed?";
      prompt_url = "{{route('admin_resend_email', ['type' => 'registration'])}}";
      break;
    case 'payment':
      method = "POST";
      prompt_message = "This will resend the payment confimation email (with QR code) to the registered email address.<br />Do you want to proceed?";
      prompt_url = "{{route('admin_resend_email', ['type' => 'payment'])}}";
      break;
    case 'delete':
      method = "DELETE";
      prompt_message = "This will permanently delete the registration.<br />Do you want to proceed?";
      prompt_url = "{{route('admin_user_delete')}}";
      break;
  };
  bootbox.confirm({
    message: prompt_message,
    buttons: {
        confirm: {
            className: 'btn-primary',
            label: '<i class="fa fa-check"></i> Confirm'
        },
        cancel: {
            className: 'btn-default',
            label: '<i class="fa fa-times"></i> Cancel'
        }
    },
    callback: function (result) {
      if (result){
        $.ajax({
          url: prompt_url,
          method : method,
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          data: {pid: pid},
          error: function(data){
            console.log('error' + data);
          },
          success: function(data){
            if (type == 'delete') $('table').DataTable().draw(false);
          }
        });
      }
    }
  });
});
</script>
@endpush