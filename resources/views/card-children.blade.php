@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

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
                    <div style="overflow:hidden;">
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

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.js" type="text/javascript"></script>

    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.css" rel="stylesheet" type="text/css"/>

    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/js/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('/js/table.js') }}" type="text/javascript"></script>
@endsection
