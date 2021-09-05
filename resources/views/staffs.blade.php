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
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div>
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
                                    <form class="custom-validation" tapath="group" novalidate>
                                        <div class="form-group">
                                            <label>ФИО</label>
                                            <div>
                                                <input name="fio" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Адрес</label>
                                            <div>
                                                <input name="address" data-parsley-type="number" type="text"
                                                    class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Дата рождения</label>
                                            <div>
                                                <input id="input-date1" class="form-control input-mask" data-inputmask="'alias': 'datetime'" data-inputmask-inputformat="dd/mm/yyyy" im-insert="false">
{{--                                                <input name="date_birth" type="text" class="form-control" placeholder="mm/dd/yyyy"--}}
{{--                                                       id="datepicker-autoclose" data-inputmask-inputformat="mm/dd/yyyy">--}}
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
                                                <input name="date_employment" type="text" class="form-control" placeholder="mm/dd/yyyy"
                                                       id="datepicker-autoclose">
                                            </div>
                                        </div>



                                        <div class="form-group mb-0">
                                            <div>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
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

    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.css" rel="stylesheet" type="text/css" />

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
