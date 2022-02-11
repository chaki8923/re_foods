@extends('layouts.app')

@section('content')
<div class="container mt-3 mb-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('prof_edit') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
              <label for="store_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="store_name" type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="@if(!old('store_name')) {{ $store->store_name }} @endif {{ old('store_name') }}" autocomplete="" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@if(!old('email')) {{ $store->email }} @endif {{old('email')}}" autocomplete="">

                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="tell" class="col-md-4 col-form-label text-md-right">{{ __('Tell') }}</label>

              <div class="col-md-6">
                <input id="tell" type="tell" class="form-control @error('tell_number') is-invalid @enderror" name="tell_number" value="@if(!old('tell_number')) {{ $store->tell_number }} @endif {{ old('tell_number') }}" autocomplete="">

                @error('tell_number')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- 住所エリア -->
            <div id="app2">
              <div class="form-group row post-input">
                <label for="post" class="col-md-4 col-form-label text-md-right">{{ __('post_num') }}</label>
           
                <div class="col-md-6 d-flex">
                  <input type="text" v-model="firstCode" name="first_code" class="form-control @error('address') is-invalid @enderror" value="@if(!old('first_code')) {{ $address->first_code }} @endif {{old('first_code')}}">&nbsp;-&nbsp;<input type="text" v-model="lastCode" name="last_code" class="form-control @error('address') is-invalid @enderror"  value="{{ old('last_code')}} ">
                </div>
                <button type="button" @click="onClick" class="btn btn-warning search-btn">検索</button>
              </div>
              <div class="form-group row">
                <label for="prefecture" class="col-md-4 col-form-label text-md-right">{{ __('prefecture') }}</label>
                <div class="col-md-6">
                  <input v-model="prefecture" id="prefecture" type="text" class="form-control @error('prefecture') is-invalid @enderror" name="prefecture" value="{{ old('prefecture') }}" autocomplete="adress">
                  @error('prefecture')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('city') }}</label>
                <div class="col-md-6">
                  <input v-model="city" id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" autocomplete="adress">
                  @error('city')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('address') }}</label>
                <div class="col-md-6">
                  <input v-model="address" id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="adress">
                  @error('address')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="place" class="col-md-4 col-form-label text-md-right">{{ __('place') }}</label>
              <div class="col-md-6">
                <input  id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place" value="@if(!old('place')) {{ $address->place }} @endif{{ old('place') }}" autocomplete="">
                @error('place')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

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
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="password_confirmation">
              </div>
            </div>
            <div class="form-group row">
              <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Your Image') }}</label>
              @isset($publicImagePath)
              <img src="{{$publicImagePath}}" name="">
              @endisset
              <div id="image-area">
                <label for="image">
                  <span class="file-name">ファイルを選択</span> 
                  <input type="file" id="image" name="image" accept="image/*" class="image">
                </label>
                <input type="hidden" id="cropImage" name="cropImage" value="" />
                <button type="button" class="btn btn-primary d-block mt-2 delete-image">キャンセル</button>
                <div id="image-style" class="preview">
                  <img src="" class="prview-inner" alt="プロフィール画像" id="image-output">
                </div>
              </div>
            </div>
            <!-- modal画面 -->
            <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">
                    <div id="upload-demo" class="center-block"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="modal-btn-cancel" data-dismiss="modal">キャンセル</button>
                    <button type="button" id="cropImageBtn" class="modal-bton-crop">決定</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary  w-75 m-auto d-block">
                  {{ __('Edit') }}
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