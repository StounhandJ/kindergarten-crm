@extends('layouts.master')

@section('title')Ежемесячный журнал детей@endsection

@section('table-add-btn')
    <div class="table-add-btn">
        {{-- <button type="button" class="btn btn-success waves-effect waves-light btn-create-row">
            Создать
        </button> --}}
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card-body" style="overflow:hidden;">
            <div class="container-fluid">
                <div class="row">
                    <input id="journal-date" class="form-control input-mask" type="month">
                    <div style="overflow:auto;">
                        <table id="grid" tapath="general-journal-child">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Plugins js -->

    <script src="{{ URL::asset('/js/gijgo.js') }}" type="text/javascript"></script>

    <link href="{{ URL::asset('/assets/css/gijgo.css') }}" rel="stylesheet" type="text/css"/>

    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/js/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('/js/table.js') }}" type="text/javascript"></script>
@endsection
