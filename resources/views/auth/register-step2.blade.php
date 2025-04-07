@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Transporter/Enterprise Create and Verification') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.step2') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="company_name" class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required>

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="company_address" class="col-md-4 col-form-label text-md-end">{{ __('Company Address') }}</label>

                            <div class="col-md-6">
                                <textarea id="company_address" class="form-control @error('company_address') is-invalid @enderror" name="company_address" required>{{ old('company_address') }}</textarea>

                                @error('company_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Company Documents') }}</label>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="trade_license" class="form-label">Trade License (jpg, png, pdf)</label>
                                    <input class="form-control @error('trade_license') is-invalid @enderror" type="file" id="trade_license" name="trade_license" accept=".jpg,.jpeg,.png,.pdf" required>
                                    @error('trade_license')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tin_certificate" class="form-label">TIN Certificate (jpg, png, pdf)</label>
                                    <input class="form-control @error('tin_certificate') is-invalid @enderror" type="file" id="tin_certificate" name="tin_certificate" accept=".jpg,.jpeg,.png,.pdf" required>
                                    @error('tin_certificate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="bin_certificate" class="form-label">BIN Certificate (jpg, png, pdf)</label>
                                    <input class="form-control @error('bin_certificate') is-invalid @enderror" type="file" id="bin_certificate" name="bin_certificate" accept=".jpg,.jpeg,.png,.pdf" required>
                                    @error('bin_certificate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Are you the owner?') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_owner" id="is_owner_yes" value="1" checked>
                                    <label class="form-check-label" for="is_owner_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_owner" id="is_owner_no" value="0">
                                    <label class="form-check-label" for="is_owner_no">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Next') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection