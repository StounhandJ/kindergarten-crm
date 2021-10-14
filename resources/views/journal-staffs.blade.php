@extends('layouts.master')

@section('title')Табель сотрудников@endsection

@section('content')
    <div class="j_staffs_table table-responsive">
        <table class="table table-bordered table-striped table-hover" id="j_staffs_table">
            <caption>Для изменения значения нажмите на клетку и выберите нужное</caption>
            <caption>Табель сотрудников</caption>
            <thead class="thead-dark" id="j_staffs_table_head">
            </thead>
            <tbody id="j_staffs_table_body">
            {{-- <div id="loading">Loading</div> --}}
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
