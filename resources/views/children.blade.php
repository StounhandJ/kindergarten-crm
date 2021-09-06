@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('css')
    <link href="/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endsection

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
                        <table id="grid" tapath="children">

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
                                    <form class="custom-validation" tapath="children" novalidate>
                                        <div class="form-group">
                                            <label>ФИО</label>
                                            <div>
                                                <input name="fio" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Дата рождения</label>
                                            <div>
                                                <input name="date_birth" type="date" required class="form-control" placeholder="mm/dd/yyyy"
                                                       id="datepicker-autoclose">
                                                       {{-- <input name="date_enrollment" type="date" class="form-control" required placeholder="mm/dd/yyyy"
                                                       id="datepicker-autoclose"> --}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Адрес</label>
                                            <div>
                                                <input name="address" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>ФИО Матери</label>
                                            <div>
                                                <input name="fio_mother" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Телефон матери</label>
                                            <div>
                                                <input name="phone_mother" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>ФИО Отца</label>
                                            <div>
                                                <input name="fio_father" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Телефон Отца</label>
                                            <div>
                                                <input name="phone_father" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Комментарий</label>
                                            <div>
                                                <input name="comment" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Ставка</label>
                                            <div>
                                                <input name="rate" data-parsley-type="number" type="text"
                                                       class="form-control" required="">
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
                                            <label>Учреждение</label>
                                            <div>
                                                <select name="institution_id" class="form-control">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Дата зачисление</label>
                                            <div>
                                                <input name="date_enrollment" type="date" class="form-control" required placeholder="mm/dd/yyyy"
                                                       id="datepicker-autoclose">
                                            </div>
                                        </div>


                                        <div class="form-group mb-0">
                                            <div>
                                                <button type="submit"
                                                        class="btn btn-primary waves-effect waves-light mr-1">
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

    <script src="/assets/libs/select2/js/select2.min.js"></script>
    <script src="/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>

    <script src="/js//form-advanced.init.js"></script>
@endsection
