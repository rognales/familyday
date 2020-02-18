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
                        <h3 class="text-center"><i class="fa fa-exclamation-triangle " aria-hidden="true"></i>
                            {{$warning}}</h3>
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
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <th>TM Annexe 1 & 2</th>
                                        <td>Mohamad Yusri Mohamad Yusof</td>
                                        <td>mohdyusriyusof@tm.com.my</td>
                                        <td>011-1000 9385</td>
                                    </tr>
                                    <tr>
                                        <th>Menara TM</th>
                                        <td>Nur Ashikin Ahmad Kamal</td>
                                        <td>ashikin.kamal@tm.com.my</td>
                                        <td>013-344 0364</td>
                                    </tr>
                                    <tr>
                                        <th>Menara TM</th>
                                        <td>Ruhil Ahlam Adzmi</td>
                                        <td>ruhil.ahlam@tm.com.my</td>
                                        <td>012-213 0902</td>
                                    </tr>
                                    <tr>
                                        <th>Menara TM One</th>
                                        <td>Suhana Hashim</td>
                                        <td>suhana.hashim@tm.com.my</td>
                                        <td>019-426 0882</td>
                                    </tr>
                                    <tr>
                                        <th>Menara KL</th>
                                        <td>Mohd Syarriman Mohd Stapar</td>
                                        <td>syarriman@tm.com.my</td>
                                        <td>017-345 3445</td>
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
</li>
@endsection