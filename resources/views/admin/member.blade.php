@extends('layouts.app')

@section('content')
<div class="container-fluid">
  @include('layouts.icon')
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel-group">
        <div class="panel panel-default panel-table">
          <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;<a
                href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right"
                aria-hidden="true"></span>Member</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table id="members-table" class="table table-border">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Staff Id</th>
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
<script>
  var table = $('#members-table').DataTable({
    processing: true,
    serverSide: true,
	  pagingType: "numbers",
    order: [],
    ajax: '{{route('admin_member')}}',
    columns: [
        {data: 'name', name: 'name'},
        {data: 'staff_id', name: 'staff_id'}
    ]
  });
</script>
@endpush