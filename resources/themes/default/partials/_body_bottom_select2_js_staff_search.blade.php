<!-- Select2 4.0.0 -->
<script src="{{ asset ("/bower_components/admin-lte/select2/js/select2.min.js") }}" type="text/javascript"></script>

<script type="text/javascript">
    $('#staff_search').select2({
        theme: "bootstrap",
        placeholder: 'Search staff...',
        minimumInputLength: 3,
        ajax: {
            delay: 250,
            url: '/admin/staff/search',
            dataType: 'json',
            data: function (params) {
                var queryParameters = {
                    query: params.term
                };

                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: data
                };
            }
        },
        tags: true
    });

    $("#btn-add-staff").on("click", function () {
        var staffName, staffFullname, staffEnabled, staffStatus, idCell, fullnameCel, nameCel, enabledCel, actionCel;
        // Get ID.
        var staffID = $('#staff_search').val();
        // Build URL based on route and replace "{staff}" with ID.
        var urlShowStaff = '{!! route("admin.staff.show") !!}'.replace('%7Bstaffs%7D', staffID);
        // Capture CSRF token from meta header.
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        // Parse table values based on selected text.
        $.ajax({
            url: '{!! route("admin.staff.get-info") !!}',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: staffID
            },
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                staffName = data['username'];
                staffFullname = data['full_name'];
                staffEnabled = data['enabled'];

                if(1 == staffEnabled) {
                    staffStatus = '<i class="fa fa-check text-green"></i>';
                }
                else {
                    staffStatus = '<i class="fa fa-close text-red"></i>';
                }

                // Build table cells.
                idCell     = '<td class="hidden" rowname="id">' + staffID + '</td>';
                fullnameCel    = '<td>' + '<a href="' + urlShowStaff + '">' + staffFullname + '</a>' + '</td>';
                nameCel    = '<td>' + '<a href="' + urlShowStaff + '">' + staffName + '</a>' + '</td>';
                enabledCel = '<td>' + staffStatus + '</td>';
                actionCel  = '<td style="text-align: right"><a class="btn-remove-staff" href="#" title="{{ trans('general.button.remove-staff') }}"><i class="fa fa-trash-o deletable"></i></a></td>';

                // Add selected item only if not already in list.
                if ( $('#tbl-staff tr > td[rowname="id"]:contains(' + staffID + ')').length == 0 ) {
                    $('#tbl-staff > tbody:last-child').append('<tr>' + idCell + fullnameCel + nameCel + enabledCel + actionCel + '</tr>');
                }

            }
        });

    });

    $('body').on('click', 'a.btn-remove-staff', function() {
        $(this).parent().parent().remove();
    });
</script>
