@extends('layouts.app')

@section('content')
<div class="container">
  @include('layouts.icon')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel-group">

          <div class="panel panel-default panel-table">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span><a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>TM HQ Staff</h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="staffs-table" class="table table-border">
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

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css" integrity="sha256-PbaYLBab86/uCEz3diunGMEYvjah3uDFIiID+jAtIfw=" crossorigin="anonymous" />
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js" integrity="sha256-qcV1wr+bn4NoBtxYqghmy1WIBvxeoe8vQlCowLG+cng=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/dataTables.bootstrap.min.js" integrity="sha256-X/58s5WblGMAw9SpDtqnV8dLRNCawsyGwNqnZD0Je/s=" crossorigin="anonymous"></script>
<script>

var table = $('#staffs-table').DataTable({
    processing: true,
    serverSide: true,
    pagingType: "numbers",
     "order": [],
    ajax: '{{route('admin_staff')}}',
    columns: [
        {data: 'name', name: 'name'},
        {data: 'staff_id', name: 'staff_id'}
    ]
  });
</script>
@endpush
