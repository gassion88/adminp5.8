<div>
    <div class="table-responsive">
        <table id="datatable"
            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table text-center"
            style="width: 100%">
            <thead class="thead-light">
                <tr>
                    <th>SL</th>
                    <th>Withdraw Request Date</th>
                    <th>{{__('messages.amount')}}</th>
                    <th>{{__('messages.status')}}</th>
                    <th>{{__('messages.action')}}</th>
                </tr>
            </thead>
            <tbody>
            @php($withdraw_transaction = \App\Models\WithdrawRequest::where('vendor_id', $restaurant->vendor->id)->paginate(25))
            @foreach($withdraw_transaction as $k=>$wt)
                <tr>
                    <td scope="row">{{$k+$withdraw_transaction->firstItem()}}</td>
                    <td>{{date('Y-m-d '.config('timeformat'), strtotime($wt->created_at))}}</td>
                    <td>{{\App\CentralLogics\Helpers::format_currency($wt->amount)}}</td>
                    <td>
                        @if($wt->approved==0)
                            <label class="badge badge-primary">Pending</label>
                        @elseif($wt->approved==1)
                            <label class="badge badge-success">Approved</label>
                        @else
                            <label class="badge badge-danger">Denied</label>
                        @endif
                    </td>
                    <td>
                        <div class="btn--container">
                            <a href="{{route('admin.vendor.withdraw_view',[$wt['id'],$restaurant->vendor['id']])}}"
                                class="btn btn-sm btn--warning btn-outline-warning action-btn"><i class="tio-visible"></i>
                            </a>
                    </div>
                    </td>
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
    {!!$withdraw_transaction->links()!!}
        </div>
    </div>
</div>
