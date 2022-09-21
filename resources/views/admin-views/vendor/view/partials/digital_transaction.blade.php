<div>
    <div class="table-responsive">
        <table id="datatable"
            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable table-data-min-height"
            style="width: 100%">
            <thead class="thead-light">
                <tr>
                    <th>SL</th>
                    <th>{{__('messages.order')}} {{__('messages.id')}}</th>
                    <th>{{__('messages.total_order_amount')}}</th>
                    <th>{{__('messages.restaurant')}} {{__('messages.earned')}}</th>
                    <th>{{__('messages.admin')}}  {{__('messages.earned')}}</th>
                    <th>{{__('messages.delivery')}}  {{__('messages.fee')}}</th>
                    <th>{{__('messages.vat/tax')}}</th>
                </tr>
            </thead>
            <tbody>
            @php($digital_transaction = \App\Models\OrderTransaction::where('vendor_id', $restaurant->vendor->id)->latest()->paginate(25))
            @foreach($digital_transaction as $k=>$dt)
                <tr>
                    <td scope="row">{{$k+$digital_transaction->firstItem()}}</td>
                    <td><a href="{{route('admin.order.details',$dt->order_id)}}">{{$dt->order_id}}</a></td>
                    <td>{{\App\CentralLogics\Helpers::format_currency($dt->order_amount)}}</td>
                    <td>{{\App\CentralLogics\Helpers::format_currency($dt->restaurant_amount - $dt->tax)}}</td>
                    <td>{{\App\CentralLogics\Helpers::format_currency($dt->admin_commission)}}</td>
                    <td>{{\App\CentralLogics\Helpers::format_currency($dt->delivery_charge)}}</td>
                    <td>{{\App\CentralLogics\Helpers::format_currency($dt->tax)}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="page-area px-4 pb-3">
    <div class="d-flex align-items-center justify-content-end">
        {{-- <div>
            1-15 of 380
        </div> --}}
        <div>
    {!!$digital_transaction->links()!!}
        </div>
    </div>
</div>
