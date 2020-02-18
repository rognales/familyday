@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-send" aria-hidden="true"></span>Welcome Warga
            Keluarga TM!
        </div>
        </h3>

        <div class="panel-body">
          @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
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

          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-6">
                <p><strong>Staff ID :</strong> {{$participant->staff_id}}</p>
                <p><strong>Name :</strong> {{$participant->name}}</p>
                <p><strong>Email :</strong> {{$participant->email}}</p>
                @auth
                @if ($participant->member)
                <p><strong>Member :</strong> <span class="text-success">YES<span></p>
                @else
                <p><strong>Member :</strong> <span class="text-danger">NO<span></p>
                @endif
                @endauth
              </div>
              @auth
              <div class="col-sm-6">
                <table class="table table-condensed table-striped table-bordered text-center">
                  <thead>
                    <tr class="success">
                      <th class="text-center">Type</th>
                      <th class="text-center">Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Adult (Family)</td>
                      <td><abbr title="Including self">{{$participant->adultsFamily->count()+1}}</abbr></td>
                    </tr>
                    <tr>
                      <td>Kids (Family)</td>
                      <td>{{$participant->kidsFamily->count()}}</td>
                    </tr>
                    <tr>
                      <td>Adult (Others)</td>
                      <td>{{$participant->othersAdults->count()}}</td>
                    </tr>
                    <tr>
                      <td>Kids (Others)</td>
                      <td>{{$participant->othersKids->count()}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              @endauth
            </div>
            @auth
            @if (!$participant->attend)
            <div class="row">
              <div class="col-md-12 text-center"><img
                  src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(186)->generate($participant->qr())) !!} ">
                </td>
              </div>
            </div>
            @endif
            @endauth
            @if ($participant->dependants->count() > 0)
            <table class="table table-condensed table-striped">
              <thead>
                <th class="col-sm-2 text-right">Relationship</th>
                <th class="col-sm-8">Name</th>
                <th class="col-sm-2 text-center">Age</th>
              </thead>
              @isset($participant->dependants)
              <tbody>
                @foreach ($participant->dependants as $dependant)
                <tr>
                  <td class="text-right">{{$dependant['relationship']}}</td>
                  <td>{{$dependant['name']}}</td>
                  <td class="text-center">{{$dependant['age']}}</td>
                </tr>
                @endforeach
              </tbody>
              @endisset
            </table>
            <hr />
            @endif

            {{-- @guest --}}
            <p class="text-center"><em>Confirmation email has been sent to
                <mark><strong>{{$participant->email}}</strong></mark> with personalized QR code. Please present this QR
                code during registration day!</em></p>
            <p class="text-center"><em>Payment must be done before
                <mark><strong>{{ \Carbon\Carbon::parse(config('app.paymentday'))->format('jS F Y') }}</strong></mark>.
                For your convinience, we will open payment counter as below:-</em></p>

            <div class="col-md-8 col-md-offset-2">
              <table class="table table-condensed text-center">
                <thead>
                  <th class="text-center">Location</th>
                  <th class="text-center">Date</th>
                </thead>
                <tbody>
                  @foreach (config('app.counters') as $counter)
                  <tr @if (now()->greaterThan(\Carbon\Carbon::parse($counter['date'])))
                    class="passed"
                    @endif>
                    <td>{{$counter['location']}}</td>
                    <td>{{\Carbon\Carbon::parse($counter['date'])->format('jS F Y')}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            {{-- @endguest --}}
          </div>

        </div>
      </div>
    </div>
  </div>

  @endsection