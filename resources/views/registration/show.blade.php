@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @auth
                    <div class="alert alert-warning">
                        <strong>Caution!</strong> You're logged in as admin.
                    </div>
                @endauth
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
                                    <p><strong>Staff ID :</strong> {{ $participant->staff_id }}</p>
                                    <p><strong>Name :</strong> {{ $participant->name }}</p>
                                    <p><strong>Email :</strong> {{ $participant->email }}</p>
                                    <p>
                                        <strong>Meal <i class="fa fa-cutlery" aria-hidden="true"></i>:</strong>
                                        {{ $participant->meal_option }}
                                    </p>
                                    <p>
                                        <strong>Payment Status <i class="fa fa-money" aria-hidden="true"></i>:</strong>
                                        {{ $participant->payment_status }}
                                    </p>
                                    <p><strong>KTMIP Member :</strong> <span>{{ $participant->is_member }}<span></p>
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
                                                    <td><abbr
                                                            title="Including self">{{ $participant->adultsFamily->count() + 1 }}</abbr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kids (Family)</td>
                                                    <td>{{ $participant->kidsFamily->count() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Adult (Others)</td>
                                                    <td>{{ $participant->othersAdults->count() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kids (Others)</td>
                                                    <td>{{ $participant->othersKids->count() }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endauth
                            </div>
                            @auth
                                @if (!$participant->attend || $participant->hasPaid())
                                    <div class="row">
                                        <div class="col-md-12 text-center"><img
                                                src="data:image/png;base64, {!! base64_encode(
                                                    QrCode::format('png')->size(186)->generate($participant->qr()),
                                                ) !!} ">
                                            </td>
                                        </div>
                                    </div>
                                    <br />
                                @endif
                            @endauth
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <th class="col-sm-2 text-right">Relationship</th>
                                        <th class="col-sm-6">Name</th>
                                        <th class="col-sm-2 text-center">Age</th>
                                        <th class="col-sm-2 text-right">Price</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-right">Self</td>
                                            <td>{{ $participant->name }}</td>
                                            <td class="text-center">-</td>
                                            <td class="text-right">RM {{ $participant->price }}</td>
                                        </tr>
                                        @isset($participant->dependants)
                                            @foreach ($participant->dependants as $dependant)
                                                <tr>
                                                    <td class="text-right">{{ $dependant['relationship'] }}</td>
                                                    <td>{{ $dependant['name'] }}</td>
                                                    <td class="text-center">{{ $dependant['age'] }}</td>
                                                    <td class="text-right">RM {{ $dependant['price'] }}</td>
                                                </tr>
                                            @endforeach
                                        @endisset
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-center">Total</th>
                                            <th class="text-right">RM {{ $participant->total_price }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <hr />

                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <ul>
                                        <li>{!! \Session::get('success') !!}</li>
                                    </ul>
                                </div>
                            @endif
                            @guest
                                @if (!$participant->hasPaid())
                                    <fieldset>
                                        <legend>Payment Instructions</legend>
                                        <ul>
                                            <li>Confirmation email has been sent to
                                                <mark><strong>{{ $participant->email }}</strong></mark>
                                            </li>
                                            <li>You may now proceed with online payment.</li>
                                            <li>Payment must be done before
                                                <mark><strong>{{ \Carbon\Carbon::parse(config('familyday.paymentday'))->format('jS F Y') }}</strong></mark>.
                                            </li>
                                            <li>Kindly refer to banking details below:-</li>
                                        </ul>
                                        <br />
                                        <div class="col-md-10 col-md-offset-1">
                                            <table class="table table-condensed table-striped">
                                                <tr>
                                                    <th class="col-md-3">Bank Name</th>
                                                    <td>{{ config('familyday.banking.bank') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Account Number</th>
                                                    <td>{{ config('familyday.banking.number') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Account Name</th>
                                                    <td>{{ config('familyday.banking.name') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Remarks</th>
                                                    <td>Kindly put <mark><small>FDTMHQ2022</small></mark> for our tracking %amp;
                                                        reference</td>
                                                </tr>
                                                <tr>
                                                    <th>Amount Payable</th>
                                                    <td>RM {{ $participant->total_price }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <p class="text-center"><em></em></p>
                                    </fieldset>

                                    <form class="form-horizontal" id="payment" enctype="multipart/form-data" method="POST"
                                        action="{{ route('registration_upload_store', $participant) }}">
                                        @csrf
                                        <fieldset>
                                            <legend>Payment Receipt Upload</legend>
                                            <div class="form-group">
                                                <label for="payment-amount" class="col-lg-3 control-label">Amount</label>
                                                <div class="col-lg-9">
                                                    <input type="number" class="form-control" id="payment-amount"
                                                        name="amount" placeholder="{{ $participant->total_price }}" required
                                                        value="{{ old('amount') }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="payment-reference" class="col-lg-3 control-label">Reference
                                                    #</label>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="payment-reference"
                                                        name="reference" required value="{{ old('reference') }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="payment-date" class="col-lg-3 control-label">Payment
                                                    Date</label>
                                                <div class="col-lg-9">
                                                    <input type="date" class="form-control" id="payment-date" name="paid_at"
                                                        required value="{{ old('paid_at') }}"
                                                        min="{{ \Carbon\Carbon::parse(config('familyday.registrationday'))->toDateString() }}"
                                                        max="{{ now()->toDateString() }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="payment-upload" class="col-lg-3 control-label">Upload </label>
                                                <div class="col-lg-9">
                                                    <input class="form-control" type="file" id="payment-upload"
                                                        name="filename" required value="{{ old('file') }}">
                                                    <span class="help-block">Kindly ensure the transaction date, transaction amount & account number is clearly visible to ensure smooth verification.</span>
                                                    <small>(accepted: PDF, JPG, PNG only)</small>
                                                    <small>(max size: 2MB)</small>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-9 col-lg-offset-3">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                @endif
                            @endguest

                            @if ($participant->uploads->count() > 0)
                                <fieldset>
                                    <legend>Uploads History</legend>
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped">
                                            <thead>
                                                <th class="col-sm-2 text-right">Paid At</th>
                                                <th class="col-sm-6">Reference</th>
                                                <th class="col-sm-2 text-right">Amount</th>
                                                <th class="col-sm-2 text-center">Download</th>
                                            </thead>

                                            <tbody>
                                                @foreach ($participant->uploads as $upload)
                                                    <tr>
                                                        <td class="text-right"
                                                            title="{{ $upload->paid_at->toDateString() }}">
                                                            {{ $upload->paid_at->toDateString() }}</td>
                                                        <td>{{ $upload->reference }}</td>
                                                        <td class="text-right">RM {{ $upload->amount }}</td>
                                                        <td class="text-center"> <a target="_blank"
                                                                class="btn btn-default btn-xs"
                                                                href="{{ route('upload_show', [$upload]) }}">View</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            @endif
                            <hr />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $('form#payment').on('submit', function() {
                let fileSelector = document.getElementById('payment-upload')
                // Do quick checks
                if (fileSelector.files.length > 0) {
                    const fileSize = fileSelector.files.item(0).size;
                    const fileMb = fileSize / 1024;
                    if (fileMb > {{ config('familyday.banking.maxupload') }}) {
                        alert('Max filesize reached. Kindly limit upload to max 2MB only.');
                        return false;
                    }
                    return true;
                }
                return trfalseue;
            });
        </script>
    @endpush
