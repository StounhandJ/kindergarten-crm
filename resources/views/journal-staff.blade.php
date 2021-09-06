@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('content')
    <div class="j_staff_table table-responsive">
        <table class="table table-bordered table-striped table-hover" id="j_staff_table">
            <caption>Для изменения значения нажмите на клетку и выберите нужное</caption>
            <thead class="thead-dark" id="j_staff_table_head">
            </thead>
            <tbody id="j_staff_table_body">
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <!-- Plugins js -->

    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/js/form-validation.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/fix.js') }}"></script>
@endsection
