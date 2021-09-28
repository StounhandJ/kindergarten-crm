@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('table-add-btn')
    <div class="table-add-btn">
        <button type="button" class="btn btn-success waves-effect waves-light btn-create-row">
            Создать
        </button>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card-body" style="overflow:hidden;">
            <h4><i id="cash">0</i> р.</h4>
            <div class="container-fluid">
                <div class="row">
                    <input id="income-date" class="form-control input-mask" type="month">
                    <div class="col-12">
                        <table id="grid" class="table" tapath="cost?income=1">
                            <caption>Доходы</caption>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow:hidden;margin-top:30px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <table id="grid2" class="table" tapath="cost?income=0">
                            <caption>Расходы</caption>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: flex;justify-content: flex-end;">
        <div class="col-sm-6 col-md-3 mt-4">
            <div class="modal fade bs-example-modal-center form-create" tabindex="-1"
                 aria-labelledby="mySmallModalLabel" style="display: none;"
                 aria-modal="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0">Создание</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="custom-validation" tapath="cost" novalidate>
                                <input name="income" id="income_bool" type="text" hidden>

                                <div class="form-group">
                                    <label>Сумма</label>
                                    <div>
                                        <input name="amount" type="number" min="0" class="form-control" required
                                               placeholder="Введите сумму...">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Тип</label>
                                    <div>
                                        <select id="type_income" class="form-control">
                                            <option value="0">ЗП - Расход</option>
                                            <option value="1">Оплата за детей - Доход</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="income_child" style="display: none;">
                                    <label>Ребёнок</label>
                                    <div>
                                        <select name="child_id" class="form-control">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" id="income_staff" style="display: none;">
                                    <label>Сотрудник</label>
                                    <div>
                                        <select name="staff_id" class="form-control">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Комментарий</label>
                                    <div>
                                        <input name="comment" type="text" class="form-control"
                                               placeholder="Комментарий...">
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <div>
                                        <button type="submit"
                                                class="btn mr-1 btn-success waves-effect waves-light btn-create-row">
                                            Создать
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>


        {{--                <button type="button" class="btn btn-success waves-effect waves-light "--}}
        {{--                        style="margin-bottom: 10px;">Создать--}}
        {{--                </button>--}}
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
