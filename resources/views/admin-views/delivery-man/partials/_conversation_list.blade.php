@php($array=[])
{{-- {{ dd(count($conversations)) }} --}}
@foreach($conversations as $conv)
@if(in_array($conv->receiver->id,$array)==false)
@php(array_push($array,$conv->receiver->id))
@if ($conv->receiver && $conv->receiver->user_id)
@php($user=\App\Models\User::find($conv->receiver->user_id))
@elseif ($conv->receiver && $conv->receiver->vendor_id)
@php($user=\App\Models\Vendor::find($conv->receiver->vendor_id))
@php($vnd=$conv->receiver)
@endif
@if (isset($user))
{{-- @php($unchecked=\App\Models\Message::where(['conversation_id'=>$conv->id, 'is_seen' => 0])->count()) --}}
@php($last_sender=$conv->sender_id)
@php($unchecked=($conv->last_message->sender_id != $last_sender)?0:$conv->unread_message_count)
<input type="hidden" id="deliver_man" value="{{ $delivery_man->id }}">
<div
    class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list {{$unchecked!=0?'conv-active':''}}"
    onclick="viewConvs('{{route('admin.delivery-man.message-view',['conversation_id'=>$conv->id,'user_id'=>$conv->sender_id])}}','customer-{{$conv->sender_id}}')"
    id="customer-{{$conv->sender_id}}">
    <div class="chat-user-info-img d-none d-md-block">
        <img class="avatar-img"
                src="{{asset('storage/app/public/profile/'.$user['image'])}}"
                onerror="this.src='{{asset('public/assets/admin')}}/img/160x160/img1.jpg'"
                alt="Image Description">
    </div>
    <div class="chat-user-info-content">
        <h5 class="mb-0 d-flex justify-content-between">
            @if (isset($vnd))
            <span class=" mr-3">{{$vnd['f_name'].' '.$vnd['l_name']}}</span> <span
                class="{{$unchecked!=0?'badge badge-info':''}}">{{$unchecked!=0?$unchecked:''}}</span>
            @else
            <span class=" mr-3">{{$user['f_name'].' '.$user['l_name']}}</span> <span
                class="{{$unchecked!=0?'badge badge-info':''}}">{{$unchecked!=0?$unchecked:''}}</span>
            @endif

        </h5>
        <span>{{ $user['phone'] }}</span>
    </div>
</div>
@else
    <div
        class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list">
        <div class="chat-user-info-img d-none d-md-block">
            <img class="avatar-img"
                    src='{{asset('public/assets/admin')}}/img/160x160/img1.jpg'
                    alt="Image Description">
        </div>
        <div class="chat-user-info-content">
            <h5 class="mb-0 d-flex justify-content-between">
                <span class=" mr-3">Account not found</span>
            </h5>
        </div>
    </div>
@endif

@endif
@endforeach
