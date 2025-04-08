@extends('admin.layouts.master')
@push('title')
Email Configuration
@endpush
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12"> <!-- Expanded width to 12 columns -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white border-bottom text-center">
                    <h3 class="fw-bold text-secondary mb-0">Email Configuration</h3>
                    <p class="text-muted small">Update your SMTP settings for email functionality</p>
                </div>
                <div class="card-body">
                    <form id="emailSetting">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium text-secondary">SMTP Host</label>
                                <input type="text" class="form-control" name="smtp_host" value="{{ $settings->smtp_host ?? '' }}">
                                <div class="invalid-feedback smtp_host-error"> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium text-secondary">SMTP Port</label>
                                <input type="number" class="form-control" name="smtp_port" value="{{ $settings->smtp_port ?? '' }}">
                                <div class="invalid-feedback smtp_port-error"> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium text-secondary">Encryption Type</label>
                                <input type="text" class="form-control" name="encryption_type" value="{{ $settings->encryption_type ?? '' }}">
                                <div class="invalid-feedback encryption_type-error"> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium text-secondary">SMTP Username</label>
                                <input type="text" class="form-control" name="smtp_username" value="{{ $settings->smtp_username ?? '' }}">
                                <div class="invalid-feedback smtp_username-error"> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium text-secondary">SMTP Password</label>
                                <input type="password" class="form-control" name="smtp_password" value="{{ $settings->smtp_password ?? '' }}">
                                <div class="invalid-feedback smtp_password-error"> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium text-secondary">From Email</label>
                                <input type="email" class="form-control" name="from_email_address" value="{{ $settings->from_email_address ?? '' }}">
                                <div class="invalid-feedback from_email_address-error"> </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium text-secondary">From Name</label>
                                <input type="text" class="form-control" name="from_name" value="{{ $settings->from_name ?? '' }}">
                                <div class="invalid-feedback from_name-error"> </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary w-50 btn-lg">Save Settings</button>
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
<script>
    emailSetting.onsubmit = async (e) =>{
        e.preventDefault();
        makePostRequest("{{route('admin.email.settings.store')}}",emailSetting,'emailSetting')
    }
</script>
@endpush