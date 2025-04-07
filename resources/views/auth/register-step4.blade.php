@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Select Your Type') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.step4') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" name="type" value="enterprise" class="btn btn-primary btn-lg mb-3">
                                    {{ __('Enterprise') }}
                                </button>
                                <button type="submit" name="type" value="transporter" class="btn btn-primary btn-lg">
                                    {{ __('Transporter') }}
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