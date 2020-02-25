@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @include('layouts.icon')
    <div class="row">
        <div class="col-md-12">
          <div class="panel-group">
            <div class="panel panel-default panel-table">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>Registration Summary (Deleted)</h3>
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
                      <li class="list-group-item active text-center">Registration</li>
                      <li class="list-group-item">Members <span class="badge">{{$member['yes']}}</span></li>
                      <li class="list-group-item">Non Members<span class="badge">{{$member['no']}}</span></li>
                      <li class="list-group-item active">Total <span class="badge">{{$count['total']}}</span></li>
                    </ul>
                  </div>
                <div class="col col-md-3 text-right">
                  <a href="{{route('registration_create')}}" target="_blank"><button type="button" class="btn btn-primary btn-create"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Create New</button></a>
                </div>
                </div>
              </div>
          </div>
          <div class="panel panel-default panel-table">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;<a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>Registration List (Deleted)</h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="participants-table" class="table table-condensed">
                  <thead>
                  <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th class="col-sm-1">Staff Id</th>
                      <th>Deleted By</th>
                      <th>Deleted At</th>
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

@push('scripts')
<script type="text/javascript">
var table = $('#participants-table').DataTable({
    processing: true,
    serverSide: true,
    pagingType: "numbers",
     "order": [],
    ajax: '{{route('admin_user_deleted_ajax')}}',
    createdRow: function( row, data, dataIndex ) {
      if ( $(row).hasClass('member') ) {
        $( row ).find('td:eq(2)').append('  <span class="glyphicon glyphicon-user"></span>');
      }
    },
    columns: [
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'staff_id', name: 'staff_id'},
        {data: 'soft_deleted_by.name', name: 'deleted_by', searchable:false},
        {data: 'deleted_at', name: 'deleted_at', searchable:false},
      ]
  });
</script>
@endpush
