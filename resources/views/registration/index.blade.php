@extends('layouts.app')

@section('content')
<div class="container">

  <div class="jumbotron">
    <h2 class="display-3 text-center">Kelab Ibu Pejabat TM Family Day</h2>
    <p class="lead text-center"><img class="img-rounded" src="{{URL::asset('/images/Capture1.jpg')}} " /> </p>
    <p class="lead text-center">
      <a class="btn btn-primary btn-lg" href="#form" role="button">Click Here To Register</a>
    </p>
  </div>
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">Registration Form</div>

                <div class="panel-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="row">
                          <div class="col-md-10">For more info, please contact:-
                            <ul>
                          <li>Mohamad Yusri Mohamad Yusof	(011-10009385)</li>
                          <li>Nur Syuhada Binti Zulkifli		(012-7009320)</li>
                          <li>Nur Ashikin Binti Ahmad Kamal	(013-3440364)</li>
                        </ul>
                        </div>
                        </div>
                    @endif

                    <form id="form" class="form-horizontal" method="POST" action="{{route('registration_create')}}">
                      {{csrf_field()}}
                      <fieldset>
                        <legend>Participant</legend>

                        <div class="form-group">
                          <label for="staff_id" class="col-sm-2 control-label">Staff id</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="staff_id" name="staff_id" value="{{old('staff_id')}}" placeholder="TM12345" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="name" class="col-sm-2 control-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="Ali Bin Abu" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="email" class="col-sm-2 control-label">Email</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="kelab@tm.com.my" required>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset id="dependant_set">
                        <legend>Dependant</legend>
                        <div class="form-group" name="dependants_header">
                          <div class="col-sm-2">
                            <p>Relationship</p>
                          </div>
                          <div class="col-sm-6">
                            <p>Name</p>
                          </div>
                          <div class="col-sm-1">
                            <p>Age</p>
                          </div>
                          <div class="col-sm-2">
                            <p>Staff Id if TM staff</p>
                          </div>
                        </div>
                        <div id="dependant_list" class="form-group">
                          <div class="col-sm-2">
                            <select class="form-control col-sm-2" name="dependant_relationship[]">
                              <option value="spouse">Spouse</option>
                              <option value="Kids">Children</option>
                              <option value="infant">Infant</option>
                              <option value="others">Others</option>
                            </select>
                          </div>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" name="dependant_name[]" placeholder="Ali Bin Abu">
                          </div>
                          <div class="col-sm-1">
                            <input type="numeric" class="form-control" name="dependant_age[]" placeholder="30" min="1" max="2">
                          </div>
                          <div class="col-sm-2">
                            <input type="text" class="form-control" name="dependant_staff[]" placeholder="Staff Id">
                          </div>
                        </div>
                      </fieldset>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="button" id="add_dependant" class="btn btn-default">Add</button>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                      </div>
                      <hr />

                        <ol>
                          <li>TM Family Day is open for all <b>TM HQ staff only</b>.</li>
                          <li>Children age <b> 3-10 years old </b> or with the <b>height of 90-130 cm </b> are categorized as <b>‘Kids’</b>.</li>
                          <li>Children <b> below 3 years old </b> or with <b> height less than 90 cm </b> are categorized as ‘Infant’.</li>
                          <li>You may need to purchase additional ticket at the special counter provided during the event day for admission of non-family member such as Staff’s parents, sibling, relative or maid.</li>
                          <li>Participation in games will be categorized by age and will be determined by the organizer.</li>
                          <li>Every admission to the Family Day will be charged for <b> RM10.00 per staff </b> as <b> commitment fee </b>.</li>
                          <li>Payment should be made after you received the QR code. You will be needed to show your QR code to the secretariat in-charge at the booth during the payment process.</li>
                          <li>If a Staff withdraws the admission to the Family Day once the payment has been made, we will not issue a refund of the commitment fee.</li>
                          <li>Registration and payment should be made before <b> 9th October 2017 </b>.</li>
                      </ol>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div></li>
@stop
@push('style')
<style rel="stylesheet">
.jumbotron {
  background-image: url("/img/your-image.jpg");
  background-color: #17234E;
  margin-bottom: 0;`enter code here`
  min-height: 50%;
  background-repeat: no-repeat;
  background-position: center;
  -webkit-background-size: cover;
  background-size: cover;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    //dynamically add dependant form
    $( "#add_dependant" ).click(function() {
      $( "#dependant_list" ).clone().find('input').val('').end().appendTo( "#dependant_set" );
    });

  });
</script>
@endpush
