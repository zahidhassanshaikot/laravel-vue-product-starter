@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <form action="{{route('settings.store')}}" method="post" class="custom-validation" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="site_title">Site Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="site_title" id="site_title" required placeholder="Enter site title" value="{{ config('settings.site_title') }}">
                                @error('site_title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>{{ __('Timezone') }}</label>
                                <select name="timezone" class="select2 form-control">
                                    @foreach(all_timezones() as $key => $value)
                                        <option value="{{ $key }}" {{ config('app.timezone') ? (config('app.timezone') == $key ? 'selected' : '') : '' }}>{{ $value }}( {{ $key }}) </option>
                                    @endforeach
                                </select>
                                @error('site_title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Site Logo <span class="text-danger">*</span></label><br>
                                <label for="imgInp">
                                    <img src="{{ config('settings.site_logo') ? getStorageImage(config('settings.site_logo'),false,'logo') : getDefaultLogo()}}" class="img-thumbnail img-64" id="site_logo_preview"/>
                                </label>
                                <input type="file" name="site_logo" {{ config('settings.site_logo') ? '' : 'required'  }} class="hdn-uploder image d-none" data-preview="site_logo_preview" id="imgInp"  accept="image/*"/>
                                @error('site_logo')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Wide Site Logo <span class="text-danger">*</span></label><br>
                                <label for="wide_site_logo">
                                    <img src="{{ config('settings.wide_site_logo') ? getStorageImage(config('settings.wide_site_logo'),false,'wide_logo') : getDefaultWideLogo() }}" class="img-thumbnail img-64" id="wide_site_logo_preview"/>
                                </label>
                                <input type="file" name="wide_site_logo" {{ config('settings.wide_site_logo') ? '' : 'required'  }} class="hdn-uploder image d-none" data-preview="wide_site_logo_preview" id="wide_site_logo"  accept="image/*"/>
                                @error('wide_site_logo')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Site Favicon <span class="text-danger">*</span></label><br>
                                <label for="imgInpFavicom">
                                    <img src="{{ config('settings.site_favicon') ? getStorageImage(config('settings.site_favicon'),false,'favicon') : getDefaultFavicon()}}" class="img-thumbnail img-64" id="site_favicon_preview"/>
                                </label>
                                <input type="file" name="site_favicon" {{ config('settings.site_favicon') ? '' : 'required'  }} class="hdn-uploder image d-none" data-preview="site_favicon_preview" id="imgInpFavicom"  accept="image/*"/>
                                @error('site_favicon')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Default Logo <span class="text-danger">*</span></label><br>
                                <label for="default_logo">
                                    <img src="{{ config('settings.default_logo') ? getStorageImage(config('settings.default_logo'),false,'logo') : getDefaultLogo()}}" class="img-thumbnail img-64" id="default_logo_preview"/>
                                </label>
                                <input type="file" name="default_logo" {{ config('settings.default_logo') ? '' : 'required'  }} class="hdn-uploder image d-none" data-preview="default_logo_preview" id="default_logo"  accept="image/*"/>
                                @error('default_logo')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-1 mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                        <i class="fa fa-save"></i> Submit
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="/libs/parsleyjs/parsley.min.js"></script>
    <script src="/js/pages/form-validation.init.js"></script>
    <script>
        $(function () {
            //image
            $(".image").change(function () {
                var preview = $(this).data('preview');
                readURL(this, preview);
            });
        });
        function readURL(input, preview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + preview).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
