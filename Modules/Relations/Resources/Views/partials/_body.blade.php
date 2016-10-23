<body class="skin-blue sidebar-mini">

    <!-- Main body content -->
    @include('relations::partials._body_content')


    <!-- Footer -->
    @include('relations::partials._footer')

    <!-- Optional bottom section for modals etc... -->
    @yield('body_bottom')

    <!-- Body Bottom modal dialog-->
    <div class="modal fade" id="modal_dialog" tabindex="-1" role="dialog" aria-labelledby="modal_dialog_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

</body>
