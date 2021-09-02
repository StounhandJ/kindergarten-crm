@extends('layouts.master')

@section('title') @lang('translation.Responsive_Table') @endsection

@section('content')
    <div class="j_children_table table-responsive">
        <table class="table table-bordered table-striped table-hover" id="j_children_table">
            <caption>Что-то можно сюда написать</caption>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Сентябрь</th>
                    <th scope="col">1</th>
                    <th scope="col">2</th>
                    <th scope="col">3</th>
                    <th scope="col">4</th>
                    <th scope="col">5</th>
                    <th scope="col">6</th>
                    <th scope="col">7</th>
                    <th scope="col">8</th>
                    <th scope="col">9</th>
                    <th scope="col">10</th>
                    <th scope="col">11</th>
                    <th scope="col">12</th>
                    <th scope="col">13</th>
                    <th scope="col">14</th>
                    <th scope="col">15</th>
                    <th scope="col">16</th>
                    <th scope="col">17</th>
                    <th scope="col">18</th>
                    <th scope="col">19</th>
                    <th scope="col">20</th>
                    <th scope="col">21</th>
                    <th scope="col">22</th>
                    <th scope="col">23</th>
                    <th scope="col">24</th>
                    <th scope="col">25</th>
                    <th scope="col">26</th>
                    <th scope="col">27</th>
                    <th scope="col">28</th>
                    <th scope="col">29</th>
                    <th scope="col">30</th>
                    <th scope="col">31</th>
                </tr>
            </thead>
            <tbody id="j_children_table_body">
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        window.onload = function () {
            var scr = $(".table-responsive");
            scr.mousedown(function () {
                var startX = this.scrollLeft + event.pageX;
                var startY = this.scrollTop + event.pageY;
                scr.mousemove(function () {
                    this.scrollLeft = startX - event.pageX;
                    this.scrollTop = startY - event.pageY;
                    return false;
                });
            });
            $(window).mouseup(function () {
                scr.off("mousemove");
            });
        }
    </script>
    <div class="table-save-btn">
        <button type="button" class="btn btn-success waves-effect waves-light btn-create-row">
            Сохранить
        </button>
    </div>
@endsection

@section('script')
    <!-- Plugins js -->

    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/js/form-validation.init.js') }}"></script>
@endsection
