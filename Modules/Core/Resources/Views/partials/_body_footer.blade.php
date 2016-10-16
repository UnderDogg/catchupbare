<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        {!! config('app.tag_line') !!}
    </div>
    <!-- Default to the left -->
    {!! config('app.copyright_line') !!}
</footer>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatables.bootstrap.js') }}"></script>

<script src="{{ asset('lb-faveo/js/app.min.js') }}"></script>



@stack('scripts')