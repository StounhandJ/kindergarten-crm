@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('content')
    <div class="j_children_table table-responsive">
        <table class="table table-bordered table-striped table-hover" id="j_children_table">
            <caption>Для изменения значения нажмите на клетку и выберите нужное</caption>
            <thead class="thead-dark">
            </thead>
            <tbody id="j_children_table_body">
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            var scr = $(".table-responsive");
            scr.mousedown(function() {
                var startX = this.scrollLeft + event.pageX;
                var startY = this.scrollTop + event.pageY;
                scr.mousemove(function() {
                    this.scrollLeft = startX - event.pageX;
                    this.scrollTop = startY - event.pageY;
                    return false;
                });
            });
            $(window).mouseup(function() {
                scr.off("mousemove");
            });
        }
    </script>
@endsection

@section('script')
    <!-- Plugins js -->

    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/js/form-validation.init.js') }}"></script>
@endsection