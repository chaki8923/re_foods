@section('title', '食材編集')
@extends('layouts.app')
@section('content')

<div class="container mt-3">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center">
          食材編集
        </div>
        <div class="card-body">
          <form method="post" action="{{route('food_edit',$food->id)}}" enctype="multipart/form-data">
            @csrf
            <!-- カテゴリー -->
            <div class="form-group row justify-content-center">
              <label for="category_id" class="col-form-label cl-md-3 w-25 text-md-right">{{__('Category')}}</label>
              <div class="col-md-6">
                <select name="category_id" id="category" class="form-control @error('category_id') is-invalid @enderror" @change="change" class="parent">
                  <option value="">選択してください</option>
                  @foreach($categories as $category)
                  @if($category->category_name == $cat->category_name)
                  <option value="{{$category->id}}" selected="selected">
                    {{$category->category_name}}
                  </option>
                  @else
                  <option value="{{$category->id}}" @if(old('category_id')==$category->id) selected @endif>
                    {{$category->category_name}}
                  </option>
                  @endif
                  @endforeach
                </select>
                @error('category_id')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- サブカテゴリー -->
            <div class="form-group row justify-content-center">
              <label for="sub_category" class="col-form-label cl-md-3 w-25 text-md-right">{{__('SubCat')}}</label>
              <div class="col-md-6">
                <select name="sub_category_id" id="sub_category_id" v-model="sub" class="form-control @error('sub_category_id') is-invalid @enderror">
                  <option value="">選択してください</option>
                  <option v-for="cat in category" :key="cat.id" :value="cat.api_id">
                    @{{cat.food_name}}
                  </option>
                </select>
              </div>
            </div>


            <!-- 日付 -->
            <div class="form-group row justify-content-center">
              <label for="loss_limit" class="col-form-label cl-md-3 w-25 text-md-right">{{__('LIMIT')}}</label>
              <div class="col-md-6">
                <input id="loss_limi" type="date" name="loss_limit" class="form-control  @error('loss_limit') is-invalid @enderror" value="@if(!old('loss_limit')){{$food->loss_limit}}@else{{old('loss_limit')}}@endif">
                @error('loss_limit')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <!-- 値段-->
            <div class="form-group row justify-content-center">
              <label for="plice" class="col-form-label cl-md-3 w-25 text-md-right">{{__('PLICE')}}</label>
              <div class="col-md-6">
                <input id="plice" type="text" name="plice" class="form-control @error('plice') is-invalid @enderror" value="@if(!old('plice')){{$food->plice}}@else{{old('plice')}}@endif">
                @error('plice')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>


            <!-- 食材写真 -->
            <div class="form-group row justify-content-center">
              <label for="pic1" class="col-form-label cl-md-3 w-25 text-md-right">{{__('FOOD_IMAGE')}}</label>
              <div class="col-md-6">
                @for($i = 1;$i <= 3;$i ++) <div class="food-pic">
                  <input type="file" class="input-file{{$i}} file-area @error('pic1') is-invalid @enderror" name="pic{{$i}}" id="pic1">
                  <div class="pic-preview{{$i}} preview-area">
                    <span class="image-clear">✖️</span>
                    <img src="" alt="" class="js-preview{{$i}}">
                    <p>画像を選択</p>
                  </div>
                  @error('pic1')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              @endfor
            </div>
        </div>

          <!-- コメント -->
          <div class="form-group row justify-content-center">
              <label for="comment" class="col-form-label cl-md-3 w-25 text-md-right">{{__('Word')}}</label>
              <div class="col-md-6">
                <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" maxlength="255" id="comment" cols="20" rows="10">@if(!old('comment')){{$food->comment}}@else{{old('comment')}}@endif</textarea>
                @error('comment')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
        <div class="form-group row mb-0">
          <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary  w-75 m-auto d-block js-no-repeated">
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
@include('layouts.footer')
@endsection

<script src="/js/select.js" defer></script>