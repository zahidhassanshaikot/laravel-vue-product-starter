@section('modal')
    <!-- ajax modal  -->
    <div id="common-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="modal-header">
                        <h5 class="modal-title" id="common-modal-title">Title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="">
                        <div id="modal-loader">
{{--                            <img src="{{asset('images/default/preloader.gif')}}" /> --}}
                        </div>
                        <!-- content will be load here -->
                        <div id="dynamic-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Ajax modal  -->
@endsection
@push('script')
    <script src="{{asset('js/ajax-modal.js') }}"></script>
@endpush
