<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="{{ URL::asset('/assets/libs/metismenu/metismenu.min.js') }}"></script>
<script src="{{ URL::asset('/assets/libs/simplebar/simplebar.min.js') }}"></script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/table-scroll.js') }}"></script>
<script src="{{ URL::asset('/assets/js/masks.js') }}"></script>

@yield('script-bottom')
