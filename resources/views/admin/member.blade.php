@extends('layouts.app')

@section('content')
<div class="container">
  @include('layouts.icon')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel-group">

          <div class="panel panel-default panel-table">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;&nbsp;<a href="{{route('admin_index')}}">Admin</a> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>Member</h3>
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

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/dataTables.bootstrap.min.css" integrity="sha256-PbaYLBab86/uCEz3diunGMEYvjah3uDFIiID+jAtIfw=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css"  type="text/css" >
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
<script>

var table = $('#members-table').DataTable({
    processing: true,
    serverSide: true,
	pagingType: "numbers",
     "order": [],
    ajax: '{{route('admin_member')}}',
    columns: [
        {data: 'name', name: 'name'},
        {data: 'staff_id', name: 'staff_id'}
    ]
  });
</script>
@endpush
