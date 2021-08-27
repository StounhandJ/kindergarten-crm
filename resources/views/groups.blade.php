@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('css')

@endsection

@section('content')
    <div class="row">
        <div class="card-body">
            <div style="display: flex;justify-content: flex-end;">


                <div class="col-sm-6 col-md-3 mt-4">
                    <div class="text-center">
                        <!-- Small modal -->
                        <button type="button" class="btn btn-success waves-effect waves-light btn-create-row"
                                style="margin-bottom: 10px;">Создать
                        </button>
                    </div>

                    <div class="modal fade bs-example-modal-center form-create" tabindex="-1"
                         aria-labelledby="mySmallModalLabel" style="display: none;"
                         aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Center modal</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Cras mattis consectetur purus sit amet fermentum.
                                        Cras justo odio, dapibus ac facilisis in,
                                        egestas eget quam. Morbi leo risus, porta ac
                                        consectetur ac, vestibulum at eros.</p>
                                    <p>Praesent commodo cursus magna, vel scelerisque
                                        nisl consectetur et. Vivamus sagittis lacus vel
                                        augue laoreet rutrum faucibus dolor auctor.</p>
                                    <p class="mb-0">Aenean lacinia bibendum nulla sed consectetur.
                                        Praesent commodo cursus magna, vel scelerisque
                                        nisl consectetur et. Donec sed odio dui. Donec
                                        ullamcorper nulla non metus auctor
                                        fringilla.</p>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                </div>


{{--                <button type="button" class="btn btn-success waves-effect waves-light "--}}
{{--                        style="margin-bottom: 10px;">Создать--}}
{{--                </button>--}}
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="grid" tapath="group"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Plugins js -->

    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.js" type="text/javascript"></script>

    <script src="{{ URL::asset('/js/table.js') }}" type="text/javascript"></script>

    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.css" rel="stylesheet" type="text/css"/>
@endsection
