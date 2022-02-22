@extends('layouts.app')

@section('content')
<div class="container">
    <div id="push">
        <push-component food_link="{{$link}}">
        </push-component>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

        </div>
    </div>

    {{-- チャット可能ユーザ一覧  --}}
    <table class="table">
        <thead>
        <tr>
      
            <th>Name</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($stores as $key => $user)
        <tr>
            <td>{{$user->store_name}}</td>
      
            <td><a href="{{route('chat',['id'=>$food->id,'kind'=>$user->store_id])}}"><button type="button" class="btn btn-primary">MAIL</button></a></td>
            <td class="user-detail-btn"><a href="{{route('user_detail',$user->store_id)}}"><button type="button" class="btn btn-primary"><span class="responsibe">ユーザー</span>情報</button></a></td>
            @if($user->new_flg)
            <td><h3 class="badge bg-danger text-white">NEW</h3></td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>
        
       

</div>
@endsection
<script src="/js/project.js" defer></script>
