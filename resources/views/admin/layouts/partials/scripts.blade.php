{{-- <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/metismenu"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/metismenujs"></script> --}}
{{-- <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
<script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('libs/node-waves/waves.min.js') }}"></script>

<!-- Select2  -->
<script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>
<!-- Datepicker  -->
<script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<!-- intlTelInput  -->
{{-- <script src="{{ asset('libs/intl/build/js/intlTelInput-jquery.min.js')}}"></script> --}}

<!-- Vite Integration -->

<script src="{{ asset('js/script.js') }}"></script>

<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/custom-dev.js') }}"></script>


<!-- Vite Integration -->
{{-- @vite('resources/js/app.js') --}}

<script>
    toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    @if(Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if(Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

@stack('script')


<!-- Include Toggle Status Update -->
@include('common.toggle-status-update')
