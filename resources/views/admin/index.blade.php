@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">

    <div class="col-md-12">
      <div class="alert alert-info alert-dismissible" role="alert">
        <p class="lead"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> Event Day <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> {{\Carbon\Carbon::parse(config('app.eventday'))->diffForHumans()}}</p>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Admin Dashboard</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
              <div class="thumbnail">
                <div class="caption text-center">
                  <i class="fa fa-users fa-5x" aria-hidden="true"></i>
                  <h3>Registration</h3>
                  <p>View registration details including summary. You can also resend the email confirmation.</p>
                  <a href="{{route('admin_user')}}" class="btn btn-primary btn-md" role="button">Manage Registration</a>

                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="thumbnail">
                <div class="caption text-center">
                  <i class="fa fa-credit-card fa-5x" aria-hidden="true"></i>
                  <h3>Payment</h3>
                  <p>Capture payment details here. This is one way operation.</p>
                  <a href="{{route('admin_payment')}}" class="btn btn-primary btn-md" role="button">Manage Payment</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="thumbnail">
                <div class="caption text-center">
                  <i class="fa fa-address-book fa-5x" aria-hidden="true"></i>
                  <h3>Attendance</h3>
                  <p>Manage your attendance here. Main page for event day.</p>
                  <a href="{{route('admin_attend')}}" class="btn btn-primary btn-md" role="button">View Attendance</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="thumbnail">
                <div class="caption text-center">
                  <i class="fa fa-building fa-5x" aria-hidden="true"></i>
                  <h3>Staff</h3>
                  <p>View TM Ibu Pejabat's staff list. This is read only view.</p>
                  <a href="{{route('admin_staff')}}" class="btn btn-primary btn-md" role="button">View Staff</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="thumbnail">
                <div class="caption text-center">
                  <i class="fa fa-id-card fa-5x" aria-hidden="true"></i>
                  <h3>Members</h3>
                  <p>View Kelab Ibu Pejabat's members list. This is a read only view.</p>
                  <a href="{{route('admin_member')}}" class="btn btn-primary btn-md" role="button">View Member</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="thumbnail">
                <div class="caption text-center">
                  <i class="fa fa-id-card fa-5x" aria-hidden="true"></i>
                  <h3>Registration Status</h3>
                  <p>Status of registration form for the public. Please contact admin to change the status.</p>
                  @if (config('app.registration'))
                  <button type="button" class="btn btn-success">Open for registration</button>
                  @else
                  <button type="button" class="btn btn-danger">Closed for registration</button> 
                  @endif
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@push('style')
<style media="screen">
  .panel-table .panel-body{
  padding:0;
  }

  .panel-table .panel-body .table-bordered{
  border-style: none;
  margin:0;
  }

  .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
    text-align:center;
    width: 100px;
  }

  .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
  .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
  border-right: 0px;
  }

  .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
  .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
  border-left: 0px;
  }

  .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
  border-bottom: 0px;
  }

  .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
  border-top: 0px;
  }

  .panel-table .panel-footer .pagination{
  margin:0;
  }

  /*
  used to vertically center elements, may need modification if you're not using default sizes.
  */
  .panel-table .panel-footer .col{
  line-height: 34px;
  height: 34px;
  }

  .panel-table .panel-heading .col h3{
  line-height: 30px;
  height: 30px;
  }

  .panel-table .panel-body .table-bordered > tbody > tr > td{
  line-height: 34px;
  }

</style>
@endpush
