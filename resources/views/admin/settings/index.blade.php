@extends('admin.layouts.app')
@section('content')
    <div class="card setting">
        <div class="card-body">
            <div class="container p-5 d-flex align-items-start">
                <ul class="nav nav-pills flex-column nav-pills border-end border-3 me-3 align-items-end w-25" id="pills-tab"
                    role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark fw-semibold active position-relative" id="pills-home-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                            aria-controls="pills-home" aria-selected="true">{{ __('General') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark fw-semibold position-relative" id="pills-profile-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab"
                            aria-controls="pills-profile" aria-selected="false">{{ __('Email Settings') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-dark fw-semibold position-relative" id="pills-contact-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab"
                            aria-controls="pills-contact" aria-selected="false">Social Media Settings</button>
                    </li>
                </ul>
                <div class="tab-content border rounded-3 border-primary p-3 text-danger w-75" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form action="{{ route('settings.store') }}" method="post" class="custom-validation"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label text-dark" for="site_title">{{ __('Site Title') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="site_title" id="site_title"
                                            required placeholder="Enter site title"
                                            value="{{ config('settings.site_title') }}">
                                        @error('site_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label text-dark" for="contact_email">
                                            {{ __('Contact Email') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control" name="contact_email" id="contact_email"
                                            required placeholder="Enter contact email"
                                            value="{{ config('settings.contact_email') }}">
                                        @error('contact_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label text-dark" for="contact_phone">
                                            {{ __('Phone Number') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="contact_phone" id="contact_phone"
                                            required placeholder="Enter phone number"
                                            value="{{ config('settings.contact_phone') }}">
                                        @error('contact_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label text-dark" for="contact_address">
                                            {{ __('Address') }}
                                        </label>
                                        <input class="form-control" name="contact_address" id="contact_address"
                                            value="{{ config('settings.contact_address') }}" placeholder="Enter address">
                                        @error('contact_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label text-dark">{{ __('Timezone') }}</label>
                                        <select name="timezone" class="select-two form-control">
                                            @foreach (all_timezones() as $key => $value)
                                                <option value="{{ $key }}"
                                                    {{ config('app.timezone') ? (config('app.timezone') == $key ? 'selected' : '') : '' }}>
                                                    {{ $value }}( {{ $key }}) </option>
                                            @endforeach
                                        </select>
                                        @error('site_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    @php
                                        $currencies = [
                                            '$' => 'US Dollar ($)',
                                            '€' => 'Euro (€)',
                                            '£' => 'British Pound (£)',
                                            '¥' => 'Japanese Yen (¥)',
                                            '₹' => 'Indian Rupee (₹)',
                                            '₩' => 'South Korean Won (₩)',
                                            '₽' => 'Russian Ruble (₽)',
                                            '₺' => 'Turkish Lira (₺)',
                                            '₫' => 'Vietnamese Dong (₫)',
                                            '₴' => 'Ukrainian Hryvnia (₴)',
                                            'R$' => 'Brazilian Real (R$)',
                                            'C$' => 'Canadian Dollar (C$)',
                                            'A$' => 'Australian Dollar (A$)',
                                            'S$' => 'Singapore Dollar (S$)',
                                            'CHF' => 'Swiss Franc (CHF)',
                                            'HK$' => 'Hong Kong Dollar (HK$)',
                                            'NZ$' => 'New Zealand Dollar (NZ$)',
                                            '₦' => 'Nigerian Naira (₦)',
                                            '₱' => 'Philippine Peso (₱)',
                                            '₪' => 'Israeli Shekel (₪)',
                                            '฿' => 'Thai Baht (฿)',
                                            '₡' => 'Costa Rican Colón (₡)',
                                            '₭' => 'Lao Kip (₭)',
                                            '₨' => 'Various Rupee (₨)',
                                            '₮' => 'Mongolian Tögrög (₮)',
                                        ];
                                    @endphp

                                    <div class="mb-3">
                                        <label class="form-label text-dark" for="site_title">{{ __('Currency Symbol') }}
                                            <span class="text-danger">*</span></label>
                                        <select class="form-control currency" name="currency_symbol" id="currency_symbol"
                                            required>
                                            @foreach ($currencies as $symbol => $label)
                                                <option value="{{ $symbol }}"
                                                    {{ config('settings.currency_symbol') == $symbol ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label text-dark">Site Logo <span
                                                class="text-danger">*</span></label><br>
                                        <label for="imgInp">
                                            <img src="{{ config('settings.site_logo') ? getStorageImage(config('settings.site_logo'), false, 'logo') : getDefaultLogo() }}"
                                                class="img-thumbnail img-64" id="site_logo_preview" />
                                        </label>
                                        <input type="file" name="site_logo"
                                            {{ config('settings.site_logo') ? '' : 'required' }}
                                            class="hdn-uploder image d-none" data-preview="site_logo_preview"
                                            id="imgInp" accept="image/*" />
                                        @error('site_logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label text-dark">Wide Site Logo <span
                                                class="text-danger">*</span></label><br>
                                        <label for="wide_site_logo">
                                            <img src="{{ config('settings.wide_site_logo') ? getStorageImage(config('settings.wide_site_logo'), false, 'wide_logo') : getDefaultWideLogo() }}"
                                                class="img-thumbnail img-64" id="wide_site_logo_preview" />
                                        </label>
                                        <input type="file" name="wide_site_logo"
                                            {{ config('settings.wide_site_logo') ? '' : 'required' }}
                                            class="hdn-uploder image d-none" data-preview="wide_site_logo_preview"
                                            id="wide_site_logo" accept="image/*" />
                                        @error('wide_site_logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label text-dark">Site Favicon <span
                                                class="text-danger">*</span></label><br>
                                        <label for="imgInpFavicom">
                                            <img src="{{ config('settings.site_favicon') ? getStorageImage(config('settings.site_favicon'), false, 'favicon') : getDefaultFavicon() }}"
                                                class="img-thumbnail img-64" id="site_favicon_preview" />
                                        </label>
                                        <input type="file" name="site_favicon"
                                            {{ config('settings.site_favicon') ? '' : 'required' }}
                                            class="hdn-uploder image d-none" data-preview="site_favicon_preview"
                                            id="imgInpFavicom" accept="image/*" />
                                        @error('site_favicon')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label text-dark">Default Logo <span
                                                class="text-danger">*</span></label><br>
                                        <label for="default_logo">
                                            <img src="{{ config('settings.default_logo') ? getStorageImage(config('settings.default_logo'), false, 'logo') : getDefaultLogo() }}"
                                                class="img-thumbnail img-64" id="default_logo_preview" />
                                        </label>
                                        <input type="file" name="default_logo"
                                            {{ config('settings.default_logo') ? '' : 'required' }}
                                            class="hdn-uploder image d-none" data-preview="default_logo_preview"
                                            id="default_logo" accept="image/*" />
                                        @error('default_logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-1 mb-0">
                                <div class="d-flex justify-content-end">
                                    <div class="right-button-group">
                                        <a href="" class="ic-button white">{{ __('Cancel') }}</a>
                                        <button type="submit" class="ic-button primary">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form action="{{ route('settings.store') }}" method="post" class="custom-validation"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3 text-dark">Email Settings</h5>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_mailer" class="form-label text-dark">Mailer</label>
                                        <input type="text" class="form-control" name="mail_mailer" id="mail_mailer"
                                            placeholder="e.g., smtp" value="{{ config('settings.mail_mailer') }}">
                                        @error('mail_mailer')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_host" class="form-label text-dark">Host</label>
                                        <input type="text" class="form-control" name="mail_host" id="mail_host"
                                            placeholder="e.g., smtp.mailtrap.io"
                                            value="{{ config('settings.mail_host') }}">
                                        @error('mail_host')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_username" class="form-label text-dark">Username</label>
                                        <input type="text" class="form-control" name="mail_username"
                                            id="mail_username" placeholder="Enter username"
                                            value="{{ config('settings.mail_username') }}">
                                        @error('mail_username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_password" class="form-label text-dark">Password</label>
                                        <input type="password" class="form-control" name="mail_password"
                                            id="mail_password" placeholder="Enter password"
                                            value="{{ config('settings.mail_password') }}">
                                        @error('mail_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_port" class="form-label text-dark">SMTP Port</label>
                                        <input type="number" class="form-control" name="mail_port" id="mail_port"
                                            placeholder="e.g., 587" value="{{ config('settings.mail_port') }}">
                                        @error('mail_port')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_encryption" class="form-label text-dark">Mail Encryption</label>
                                        <input type="text" class="form-control" name="mail_encryption"
                                            id="mail_encryption" placeholder="e.g., tls or ssl"
                                            value="{{ config('settings.mail_encryption') }}">
                                        @error('mail_encryption')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_from_address" class="form-label text-dark">From Address</label>
                                        <input type="email" class="form-control" name="mail_from_address"
                                            id="mail_from_address" placeholder="e.g., noreply@example.com"
                                            value="{{ config('settings.mail_from_address') }}">
                                        @error('mail_from_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="mail_from_name" class="form-label text-dark">From Name</label>
                                        <input type="text" class="form-control" name="mail_from_name"
                                            id="mail_from_name" placeholder="e.g., Example App"
                                            value="{{ config('settings.mail_from_name') }}">
                                        @error('mail_from_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-1 mb-0">
                                    <div class="d-flex justify-content-end">
                                        <div class="right-button-group">
                                            <a href="" class="ic-button white">{{ __('Cancel') }}</a>
                                            <button type="submit" class="ic-button primary">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <form action="{{ route('settings.store') }}" method="post" class="custom-validation"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3 text-dark">Social Media Settings</h5>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="facebook_url" class="form-label text-dark">Facebook</label>
                                        <input type="url" class="form-control" name="facebook_url" id="facebook_url"
                                            placeholder="https://facebook.com/your-page"
                                            value="{{ config('settings.facebook_url') }}">
                                        @error('facebook_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="linkedin_url" class="form-label text-dark">LinkedIn</label>
                                        <input type="url" class="form-control" name="linkedin_url" id="linkedin_url"
                                            placeholder="https://linkedin.com/in/your-profile"
                                            value="{{ config('settings.linkedin_url') }}">
                                        @error('linkedin_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="instagram_url" class="form-label text-dark">Instagram</label>
                                        <input type="url" class="form-control" name="instagram_url"
                                            id="instagram_url" placeholder="https://instagram.com/your-profile"
                                            value="{{ config('settings.instagram_url') }}">
                                        @error('instagram_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="twitter_url" class="form-label text-dark">Twitter</label>
                                        <input type="url" class="form-control" name="twitter_url" id="twitter_url"
                                            placeholder="https://twitter.com/your-handle"
                                            value="{{ config('settings.twitter_url') }}">
                                        @error('twitter_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-1 mb-0">
                                    <div class="d-flex justify-content-end">
                                        <div class="right-button-group">
                                            <a href="" class="ic-button white">{{ __('Cancel') }}</a>
                                            <button type="submit" class="ic-button primary">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="/libs/parsleyjs/parsley.min.js"></script>
    <script src="/js/pages/form-validation.init.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select-two').select2({
                width: '100%',
                placeholder: "{{ __('Select Timezone') }}",
                allowClear: true
            });
            $('.currency').select2({
                placeholder: "Select a currency",
                allowClear: true
            });
        });
        $(function() {
            //image
            $(".image").change(function() {
                var preview = $(this).data('preview');
                readURL(this, preview);
            });
        });

        function readURL(input, preview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + preview).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
