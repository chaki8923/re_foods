@section('title', 'MAIL')
@extends('layouts.app')
@section('content')
<div id="mail" class="container">
    <div id="push">
        <push-component food_link="{{$link}}">
        </push-component>
    </div>
    <table class="table">
        <h4 class="text-center mt-5">受信リスト</h4>
        <thead>
            <tr>
                <th>日時</th>
                <th>Name</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($stores as $key => $user)
        @if($user->from_store !== $id)
            <tr v-for="list in lists">
                <th>{{$user->created_at}}</th>
                <td>{{$user->store_name}}</td>
                
                <td><a href="{{route('chat',['id'=>$user->food_id,'kind'=>$user->from_store])}}"><button type="button" class="btn btn-primary">Mail</button></a></td>
                <td class="user-detail-btn" ><a href="{{route('user_detail',$user->to_store)}}"><button type="button" class="btn btn-primary"><span class="responsibe">ユーザー</span>情報</button></a></td>

                @if($user->new_flg)
                <td>
                    <h3 class="badge bg-danger text-white">NEW</h3>
                </td>
                @endif
            </tr>
        @endif
@endforeach
        </tbody>
    </table>

</div>
<!-- @include('layouts.loading') -->
@include('layouts.footer')
@endsection
<script src="/js/project.js" defer></script>
<!-- <script src="{{ asset('/js/chat_list.js') }}" defer></script> -->