@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('table-add-btn')
    <div class="table-add-btn" style="padding:0">
        <!-- Small modal -->
        <button type="button" class="btn btn-success waves-effect waves-light btn-create-row">
            Создать
        </button>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card-body" style="overflow:hidden;">
            <div class="container-fluid">
                <div class="row">
                    <div style="overflow:hidden;">
                        <table id="grid" tapath="staff">

                        </table>
                    </div>
                </div>
            </div>
            <div style="display: flex;justify-content: flex-end;">
                <div class="col-sm-6 col-md-3 mt-4">
                    <div class="modal fade bs-example-modal-center form-create" tabindex="-1"
                         aria-labelledby="mySmallModalLabel" style="display: none;" aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Создание группы</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form class="custom-validation" tapath="staff" novalidate>
                                        <div class="form-group">
                                            <label>ФИО</label>
                                            <div>
                                                <input name="fio" type="text" class="form-control" required
                                                       placeholder="Иванов Иван Иванович">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Логин</label>
                                            <div>
                                                <input name="login" type="text" class="form-control" required
                                                       placeholder="ivanov_i">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Пароль</label>
                                            <div>
                                                <input name="password" type="text" class="form-control" required
                                                       placeholder="ivanov1234">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Зарплата</label>
                                            <div>
                                                <input name="salary" type="number" min="0" class="form-control" required
                                                       placeholder="Введите сумму...">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Адрес</label>
                                            <div>
                                                <input name="address" type="text" class="form-control" required
                                                       placeholder="г. Москва, ул. Лесная, д. 28к2, кв. 19">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Дата рождения</label>
                                            <div>
                                                <input name="date_birth" class="form-control input-mask" type="date">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Телефон</label>
                                            <div>
                                                <input name="phone" type="tel" class="form-control" required
                                                       placeholder="+7 (999) 999-99-99">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Позиция</label>
                                            <div>
                                                <select name="position_id" class="form-control">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Группа</label>
                                            <div>
                                                <select name="group_id" class="form-control">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Дата найма</label>
                                            <div>
                                                <input name="date_employment" type="date" class="form-control">
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

    <script src="/assets/libs/inputmask/min/jquery.inputmask.bundle.min.js"></script>

    <script src="/js/form-mask.init.js"></script>
    {{--    <script src="/assets/libs/select2/js/select2.min.js"></script>--}}
    {{--    <script src="/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>--}}
    {{--    <script src="/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>--}}

    {{--    <script src="/js//form-advanced.init.js"></script>--}}
@endsection
