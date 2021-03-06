@extends('layouts.master')

@section('title')Категории расходов/доходов@endsection

@section('table-add-btn')
    <div class="table-add-btn">
        <!-- Small modal -->
        <button type="button" class="btn btn-success waves-effect waves-light btn-create-row">
            Создать
        </button>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <table id="grid" tapath="category-cost">

                        </table>
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
                                    <h5 class="modal-title mt-0">Создание категории расходов/доходов</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="custom-validation" tapath="category-cost" novalidate>
                                        <div class="form-group">
                                            <label>Наименование</label>
                                            <div>
                                                <input name="name" type="text" class="form-control" required
                                                       placeholder="Введите название...">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_profit"
                                                       id="is_profit_on" checked value="true">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Это доход
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_profit"
                                                       id="is_profit_off" value="false">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Это не доход
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_set_child"
                                                   id="flexRadioDefault1" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Указывать ребенка?
                                            </label>
                                                </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="is_set_staff"
                                                   id="flexRadioDefault1" checked>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Указывать сотрудника?
                                            </label>
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
