<div class="product-card card" onclick="quickView('{{$product->id}}')"  style="cursor: pointer;">
    <div class="card-header inline_product clickable p-0" style="height:100px;width:100%;overflow:hidden;">
        <img src="{{asset('storage/app/public/product')}}/{{$product['image']}}" 
                onerror="this.src='{{asset('public/assets/admin/img/100x100/food-default-image.png')}}'"
                style="width: 100%; border-radius: 5%;">
    </div>

    <div class="card-body inline_product text-center px-2 py-2 clickable">
        <div style="position: relative;" class="product-title1 text-dark font-weight-bold text-capitalize">
            {{ Str::limit($product['name'], 12,'...') }}
        </div>
        <div class="justify-content-between text-center">
            <div class="product-price text-center">
                <div class="justify-content-between text-center">
                    <div class="product-price text-center">
                        <span class="text-accent font-weight-bold" style="color: #f8923b">
                            {{--@if($product->discount > 0)
                                <strike style="font-size: 12px!important;color: grey!important;">
                                    {{\App\CentralLogics\Helpers::format_currency($product['price'])}}
                                </strike><br>
                            @endif--}}
                            {{\App\CentralLogics\Helpers::format_currency($product['price']-\App\CentralLogics\Helpers::product_discount_calculate($product, $product['price'], $restaurant_data))}}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
