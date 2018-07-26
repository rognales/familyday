<div class="row">
  <div class="col-md-4 col-md-offset-4 text-center">
    <div class="btn-group form-group" role="group" aria-label="...">
      <a href="{{route('admin_user')}}" class="btn @if (\Route::currentRouteName() =='admin_user')btn-info @else btn-warning @endif" title="Registration"><i class="fa fa-users fa-2x" aria-hidden="true"></i></a>
      <a href="{{route('admin_payment')}}" class="btn @if (\Route::currentRouteName() =='admin_payment')btn-info @else btn-warning @endif" title="Payment"><i class="fa fa-credit-card fa-2x" aria-hidden="true"></i></a>
      <a href="{{route('admin_attend')}}" class="btn @if (\Route::currentRouteName() =='admin_attend')btn-info @else btn-warning @endif" title="Attendance"><i class="fa fa-address-book fa-2x" aria-hidden="true"></i></a>
      <a href="{{route('admin_staff')}}" class="btn @if (\Route::currentRouteName() =='admin_staff')btn-info @else btn-warning @endif" title="HQ Staff"><i class="fa fa-building fa-2x" aria-hidden="true"></i></a>
      <a href="{{route('admin_member')}}" class="btn @if (\Route::currentRouteName() =='admin_member')btn-info @else btn-warning @endif" title="Members"><i class="fa fa-id-card fa-2x" aria-hidden="true"></i></a>
    </div>
    <p></p>
  </div>
</div>
