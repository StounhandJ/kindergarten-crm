@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('css')
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.css" rel="stylesheet" type="text/css"/>

@endsection

@section('content')
    <div class="row">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="grid" tapath="group"></table>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function () {
                var grid, countries;
                grid = $('#grid').grid({
                    dataSource: '/action/group',
                    uiLibrary: 'bootstrap4',
                    primaryKey: 'id',
                    inlineEditing: {mode: 'command'},
                    columns: [
                        {field: 'id', width: 60, hidden: true},
                        {field: 'name', title: 'Наименование группы', editor: true},
                        {
                            field: 'branch_name',
                            title: 'Филиал',
                            type: "dropdown",
                            editField: "branch_id",
                            editor: {dataSource: '/action/branches', valueField: 'id', textField: "name"}
                        },
                        {field: 'children_age', title: 'Возраст детей', editor: true},
                    ],
                    pager: {
                        limit: 5,
                        leftControls: [
                            $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="First Page" data-role="page-first" disabled=""><i class="gj-icon first-page"></i></button>'),
                            $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Previous Page" data-role="page-previous" disabled=""><i class="gj-icon chevron-left"></i></button>'),
                            $('<div>Страница</div>'),
                            $('<div class="input-group"><input data-role="page-number" class="form-control form-control-sm" type="text" value="0"></div>'),
                            $('<div>из</div>'),
                            $('<div data-role="page-label-last">1</div>'),
                            $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Next Page" data-role="page-next" disabled=""><i class="gj-icon chevron-right"></i></button>'),
                            $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Last Page" data-role="page-last" disabled=""><i class="gj-icon last-page"></i></button>'),
                            $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Refresh" data-role="page-refresh"><i class="gj-icon refresh"></i></button>'),
                            $('<select data-role="page-size" class="form-control input-sm" width="60"></select>'),],
                        rightControls: [
                            $('<div>Показано результатов&nbsp;</div>'),
                            $('<div data-role="record-first">1</div>'),
                            $('<div>-</div>'),
                            $('<div data-role="record-last">2</div>'),
                            $('<div class="gj-grid-mdl-pager-label">из</div>'),
                            $('<div data-role="record-total">2</div>')]
                    }
                });
                grid.on('rowDataChanged', function (e, id, record) {
                    var data = $.extend(true, {"_method": "PUT"}, record);
                    var tapath = $(this)[0].attributes.getNamedItem("tapath").value;
                    $.ajax({url: '/action/' + tapath + "/" + id, data: data, method: 'POST'})
                        .fail(function () {
                            alert('Failed to save.');
                        });
                });
                grid.on('rowRemoving', function (e, $row, id, record) {
                    if (confirm('Are you sure?')) {
                        var tapath = $(this)[0].attributes.getNamedItem("tapath").value;
                        $.ajax({url: '/action/' + tapath + "/" + id, data: {_method: "DELETE"}, method: 'POST'})
                            .done(function () {
                                grid.reload();
                            })
                            .fail(function () {
                                alert('Failed to delete.');
                            });
                    }
                });
            });
        </script>
    </div>
@endsection

@section('script')
    <!-- Plugins js -->

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.js" type="text/javascript"></script>

    {{--    <script src="{{ URL::asset('/assets/libs/rwd-table/rwd-table.min.js') }}"></script>--}}

    {{--    <script src="{{ URL::asset('/assets/js/pages/table-responsive.init.js') }}"></script>--}}

    {{--    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>--}}

    {{--    <script src="{{ URL::asset('assets/libs/bootstrap-editable/bootstrap-editable.min.js') }}"></script>--}}

    {{--    <script src="{{ URL::asset('assets/js/pages/form-xeditable.init.js') }}"></script>--}}
@endsection
