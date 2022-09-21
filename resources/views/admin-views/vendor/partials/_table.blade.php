@foreach($restaurants as $key=>$dm)
    <tr>
        <td>{{$key+1}}</td>
        <td>
            <a href="{{route('admin.vendor.view', $dm->id)}}" alt="view restaurant" class="table-rest-info">
            <img
                    onerror="this.src='{{asset('public/assets/admin/img/100x100/food-default-image.png')}}'"
                    src="{{asset('storage/app/public/restaurant')}}/{{$dm['logo']}}">
                <div class="info">
                    <span class="d-block text-body">
                        {{Str::limit($dm->name,20,'...')}}<br>
                        <!-- Rating -->
                        <span class="rating">
                            @php($restaurant_rating = $dm['rating']==null ? 0 : (array_sum($dm['rating']))/5 )
                            <i class="tio-star"></i> {{$restaurant_rating}}
                        </span>
                        <!-- Rating -->
                    </span>
                </div>
            </a>
        </td>
        <td>
            <span class="d-block owner--name text-center">
                {{$dm->vendor->f_name.' '.$dm->vendor->l_name}}
            </span>
            <span class="d-block font-size-sm text-center">
                {{$dm['phone']}}
            </span>
        </td>
        <td>
            {{$dm->zone?$dm->zone->name:__('messages.zone').' '.__('messages.deleted')}}
            {{--<span class="d-block font-size-sm">{{$banner['image']}}</span>--}}
        </td>
        <td>
            @if(isset($dm->vendor->status))
                @if($dm->vendor->status)
                <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$dm->id}}">
                    <input type="checkbox" onclick="status_change_alert('{{route('admin.vendor.status',[$dm->id,$dm->status?0:1])}}', '{{__('messages.you_want_to_change_this_restaurant_status')}}', event)" class="toggle-switch-input" id="stocksCheckbox{{$dm->id}}" {{$dm->status?'checked':''}}>
                    <span class="toggle-switch-label">
                        <span class="toggle-switch-indicator"></span>
                    </span>
                </label>
                @else
                <span class="badge badge-soft-danger">{{__('messages.denied')}}</span>
                @endif
            @else
                <span class="badge badge-soft-danger">{{__('messages.pending')}}</span>
            @endif
        </td>
        <td>
            <div class="btn--container justify-content-center">
                <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                    href="{{route('admin.vendor.edit',[$dm['id']])}}" title="{{__('messages.edit')}} {{__('messages.restaurant')}}"><i class="tio-edit"></i>
                </a>
                <a class="btn btn-sm btn--warning btn-outline-warning action-btn"
                    href="{{route('admin.vendor.view',[$dm['id']])}}" title="{{__('messages.view')}} {{__('messages.restaurant')}}"><i class="tio-invisible"></i>
                </a>
            </div>
            {{--<a class="btn btn-sm btn-white" href="javascript:"
            onclick="form_alert('vendor-{{$dm['id']}}','Want to remove this information ?')" title="{{__('messages.delete')}} {{__('messages.restaurant')}}"><i class="tio-delete-outlined text-danger"></i>
            </a>
            <form action="{{route('admin.vendor.delete',[$dm['id']])}}" method="post" id="vendor-{{$dm['id']}}">
                @csrf @method('delete')
            </form>--}}
        </td>
    </tr>
@endforeach
