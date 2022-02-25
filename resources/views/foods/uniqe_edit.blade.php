@section('title', '簡単編集')
@extends('layouts.app')
@section('content')
<div id="app2" class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('uniqe_edit') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
              <label for="store_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="store_name" type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="@if(!old('store_name')){{$store->store_name }}@endif{{ old('store_name') }}" autocomplete="" autofocus>
                @error('store_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('Comment') }}</label>

              <div class="col-md-6">

                <textarea name="comment" id="comment" class="js-comment form-control @error('comment') is-invalid @enderror" cols="30" rows="10">@if(!old('comment')){{$store->comment}}@endif{{old('comment')}}</textarea>
                @error('comment')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="count-area">255/ <span class="js-text-count"></span></div>
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
                  @if($store->store_image !== '/storage/images/ .jpeg')
                  <img src="{{$store->store_image}}" class="prview-inner" alt="プロフィール画像" id="image-output" style="opacity: 1;">
                  @else
                  <img src="" class="prview-inner" alt="プロフィール画像" id="image-output">
                  @endif
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