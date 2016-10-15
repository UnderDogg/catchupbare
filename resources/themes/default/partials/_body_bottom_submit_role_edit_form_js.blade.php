
<script type="text/javascript">
    $("#btn-submit-edit").on("click", function () {
        var staff=[], id;
        // Collect all IDs from first column.
        $('#tbl-staff tr').each(function() {
            id = $(this).find("td:first").html();
            if (id) {
                staff.push(id);
            }
        });
        // Join all staff from array to hidden field separated by a comma.
        $('#selected_staffs').val(staff.join(','));
        // Post form.
        $("#form_edit_role").submit();
    });
</script>

