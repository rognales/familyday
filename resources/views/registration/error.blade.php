@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">

            <div class="panel panel-default">

                <div class="panel-heading">Registration Error!</div>

                <div class="panel-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @isset($warning)
                        <div class="alert alert-danger">
                            <h3 class="text-center"><i class="fa fa-exclamation-triangle " aria-hidden="true"></i> {{$warning}}</h3>
                        </div>
                    @endisset
                    @if (session('warning'))
                        <div class="alert alert-danger">
                            {{ session('warning') }}
                        </div>
                    @endif
                        <div class="row">
                          <div class="col-md-10">For more info, please contact:-
                            <ul>
                          <li>Mohamad Yusri Mohamad Yusof	(011-10009385)</li>
                          <li>Nur Syuhada Binti Zulkifli		(012-7009320)</li>
                          <li>Nur Ashikin Binti Ahmad Kamal	(013-3440364)</li>
                        </ul>
                        </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div></li>
@endsection
