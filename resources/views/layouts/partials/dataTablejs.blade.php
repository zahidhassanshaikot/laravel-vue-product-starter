<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
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
