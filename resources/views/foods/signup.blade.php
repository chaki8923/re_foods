@section('title', '新規登録')
@extends('layouts.app')
@section('content')
<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
              <label for="store_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="store_name" type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" placeholder="必須"  value="{{ old('store_name') }}" autocomplete="" autofocus>

                @error('store_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="必須"  autocomplete="">

                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            
            

            <div class="form-group row">
              <label for="password"   class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                <input id="password" placeholder="必須(4桁以上)" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
              <div class="col-md-6">
                <input id="password-confirm" placeholder="必須"  type="password" class="form-control" name="password_confirmation" autocomplete="password_confirmation">
              </div>
            </div>
            
            
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary  w-75 m-auto d-block">
                  {{ __('Register') }}
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

<script src="/js/post.js" defer></script>
@include('layouts.script')