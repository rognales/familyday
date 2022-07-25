@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">

                <div class="panel-heading">Oh no!</div>

                <div class="panel-body">

                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    @isset($warning)
                    <div class="alert alert-danger">
                        <h3 class="text-center"><i class="fa fa-exclamation-triangle " aria-hidden="true"></i>                            {{$warning}}</h3>
                    </div>
                    @endisset
                    @if (session('warning'))
                    <div class="alert alert-danger">
                        {{ session('warning') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <p>For more info, please contact:-</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <td>Mohamad Yusri Mohamad Yusof</td>
                                            <td>011-1000 9385</td>
                                            <td><a href="https://api.whatsapp.com/send?phone=601110009385" target="_blank"> Whatsapp Me</a></td>
                                        </tr>
                                        <tr>
                                            <td>Ruhil Ahlam</td>
                                            <td>012-213 0902</td>
                                            <td><a href="https://api.whatsapp.com/send?phone=60122130902" target="_blank"> Whatsapp Me</a></td>
                                        </tr>
                                        <tr>
                                            <td>Hizamuddin</td>
                                            <td>019-327 5754</td>
                                            <td><a href="https://api.whatsapp.com/send?phone=60193275754" target="_blank"> Whatsapp Me</a></td>
                                        </tr>
                                        <tr>
                                            <td>Hafiz Hamdan</td>
                                            <td>013-501 4749</td>
                                            <td><a href="https://api.whatsapp.com/send?phone=60135014749" target="_blank"> Whatsapp Me</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</li>
@endsection
