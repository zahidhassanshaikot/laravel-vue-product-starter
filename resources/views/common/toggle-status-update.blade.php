{{--@push('script')--}}
    <script>
        $(document).ready(function () {
            $(document).on('click', '.toggle-status-update', function (e) {
                // e.preventDefault();
                var id = $(this).data('id');
                var model = $(this).data('model');
                var column = $(this).data('column');
                var value = $(this).data('value');
                var url = $(this).data('url');
                var altValue = $(this).data('alt_value');
                // var title = $(this).data('title');
                // var message = $(this).data('message');
                var token = "{{ csrf_token() }}";
                var data = {
                    id: id,
                    model: model,
                    column: column,
                    value: value,
                    _token: token
                };
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        $('#' + column + '_switch_' + id).data('value', altValue);
                        $('#' + column + '_switch_' + id).data('alt_value', value);

                       if(response.success == true){
                           toastr.success(response.message);
                          }else {
                           toastr.error(response.message);
                       }
                    }
                });
            });
        });
    </script>
{{--@endpush--}}
