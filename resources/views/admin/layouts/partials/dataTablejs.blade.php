
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>

<script src="{{ asset('vendor') }}/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
<script>
    !(function($) {
        "use strict";

        // DataTable wrap
        $(document).ready(function() {
            $(".dataTable").wrap("<div class='table-responsive'></div>");
        });

    })(jQuery);
</script>
