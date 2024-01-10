@extends('frontend.layouts.app')

@section('main-content')

<!-- cart section -->
<section class="cart-section common-spacing">
    <article class="container">
        <div class="row">
            <div class="col-xl-9">
                <div class="product-with-addon">
                    <div class="cart-list">
                        <div class="title-block">
                            <h4>Shopping Cart</h4>
                        </div>
                        <div id="main_cart" class="table-responsive">
                            @if($products != null)  
                            <table width="100%">
                                <tbody>
                                {{--  LOGIN USER  --}}   
                                @if(Auth::check()) 
                                    @foreach($products as $product)
                                        @if($product->product != null)
                                        <tr>
                                            <td>
                                                <div class="cart-single-item">
                                                    <a href="{{ route('product.show',$product->product->slug) }}">
                                                    @if($product->color_id != null && $product->color != null)
                                                        <img src="{{ generateURL($product->color->image) }}" alt="product">
                                                    @else  
                                                        <img src="{{ generateURL($product->product->image) }}" alt="product">
                                                    @endif
                                                    </a>                                                           
                                                </div>
                                                <div class="cart-single-item_detail">
                                                    <p>
                                                        <a href="{{ route('product.show',$product->product->slug) }}">{{ $product->product->getTitle() }}</a>
                                                    </p>
                                                    <p class="product-code">{{ $product->product->sku }}</p>
                                                    <div class="d-flex align-items-center product-options">
                                                        <p>QTY</p>
                                                        
                                                        <div class="cart-quantity">
                                                            <span class="minus" min="{{ $product->product->minimum_qty }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->product->id }}" data-minqty="{{ $product->product->minimum_qty }}" data-custom_id ="{{ $product['custom_id'] }}">-</span>
                                                            
                                                            <input type="number" class="product-qty" name="quantity" min="{{ $product->product->minimum_qty }}"
                                                             max="{{ $product->product->total_stock }}" value="{{ $product->quantity }}" data-error-container="#quantity-error" style="width: 100px;" readonly="true">                                                                                                        
                                                            <span class="plus" data-custom_id="{{ $product->custom_id }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->product->id }}" data-maxqty="{{ $product->product->total_stock }}">+</span>
                                                        </div>
                                                        <span id="quantity-error"></span>
                                                        <p style="width: 100%;">AED {{ $product->product->order_amount }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript:;"><img class="remove_product" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->product->id }}" src="{{ asset('frontend/images/close.png') }}" alt="remove"></a>
                                            </td>

                                        </tr>
                                        @if(!$product->product->addon->isEmpty())
                                        <tr>
                                            <td colspan="2">
                                                <div class="add-more-items" id="relatedProducts">
                                                    <div class="title-block">
                                                        <h4>Add on something to make it extra special!</h4>
                                                    </div>
                                                    <div class="products-list">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-8">
                                                                <div class="row">

                                                                    @foreach($product->product->addon as $prodcut_addon)
                                                                        
                                                                        @if($prodcut_addon->addon != null)

                                                                            @if(!in_array($prodcut_addon->addon->custom_id,$addon_ids))

                                                                            <div class="col-md-4">
                                                                                <div class="products-list_item">
                                                                                    <div class="products-list_image">
                                                                                        <img src="{{ generateURL($prodcut_addon->addon->getImage()) }}" alt="addon">
                                                                                    </div>
                                                                                    <div class="products-list_details">
                                                                                        <ul>
                                                                                            <li>
                                                                                                <h4>{{ $prodcut_addon->addon->getTitle() }}
                                                                                                </h4>
                                                                                            </li>
                                                                                            <li>
                                                                                                <h4>AED {{ $prodcut_addon->addon->getPrice() }}.00</h4>
                                                                                            </li>
                                                                                        </ul>
                                                                                        <a href="{{ route('cart') }}" class="btn-outline addToCartSingle" data-custom_id="{{ $prodcut_addon->addon->custom_id }}" data-minqty="1" >Add to Cart</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                                
                                                                            @endif

                                                                        @endif

                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="3" style="background-color: #EDE8E2; padding: 0;"></td>
                                        </tr>
                                        @endif  
    

                                        @elseif($product->addon != null)
                                        <tr>
                                            <td>
                                                <div class="cart-single-item">
                                                    <img src="{{ generateURL($product->addon->getImage()) }}" alt="addon">
                                                </div>
                                                <div class="cart-single-item_detail">
                                                    <p>
                                                        {{ $product->addon->getTitle() }}
                                                    </p>
                                                    <p class="product-code">{{ $product->addon->sku }}</p>
                                                    <div class="d-flex align-items-center product-options">
                                                        <p>QTY</p>
                                                        
                                                        <div class="cart-quantity">
                                                            <span class="minus" min="1" data-color_id="" data-product_id="{{ $product->addon->id }}" data-minqty="1" data-custom_id ="{{ $product->custom_id }}">-</span>
                                                            
                                                            <input type="number" class="product-qty" name="quantity" min="1"
                                                             max="{{ $product->addon->total_stock }}" value="{{ $product->quantity }}" data-error-container="#quantity-error" style="width: 100px;" readonly="true">                                                                                                     
                                                            <span class="plus" data-custom_id="{{ $product->custom_id }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->addon->id }}" data-maxqty="{{ $product->addon->total_stock }}">+</span>
                                                        </div>
                                                        <span id="quantity-error"></span>
                                                        <p style="width: 100%;">AED {{ $product->addon->price }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="javascript:;"><img class="remove_product" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->addon->id }}" src="{{ asset('frontend/images/close.png') }}" alt="remove"></a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @else
                                
                                {{-- GUEST USER  --}}
                                    @foreach($products as $product)
                                        @if($product != null)
                                        <tr>
                                            <td>
                                                <div class="cart-single-item">
                                                    @if($product->is_addon != true)
                                                    <a href="{{ route('product.show',$product->slug) }}">
                                                        <img src="{{ generateURL($product->image) }}" alt="product">
                                                    </a>                  
                                                    @else
                                                        <img src="{{ generateURL($product->image) }}" alt="product">
                                                    @endif                                         
                                                </div>
                                                <div class="cart-single-item_detail">
                                                    <p>
                                                        @if($product->is_addon != true)
                                                            <a href="{{ route('product.show',$product->slug) }}">
                                                                {{ $product->getTitle() }}
                                                            </a>
                                                        @else
                                                            {{ $product->getTitle() }}
                                                        @endif
                                                    </p>
                                                    <p class="product-code">{{ $product->sku }}</p>
                                                    <div class="d-flex align-items-center product-options">
                                                        <p>QTY</p>
                                                        <div class="cart-quantity">
                                                            <span class="minus" min="{{ $product->minimum_qty }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->id }}" data-minqty="{{ $product->minimum_qty }}" data-custom_id ="{{ $product['custom_id'] }}">-</span>
                                                            
                                                            <input type="number" class="product-qty" name="quantity" min="{{ $product->minimum_qty }}"
                                                             max="{{ $product->total_stock }}" value="{{ $product->quantity }}" data-error-container="#quantity-error" style="width: 50px;" readonly="true">                                                                                                        
                                                            <span class="plus" data-custom_id="{{ $product->custom_id }}" data-color_id="{{ $product->color_id }}" data-product_id="{{ $product->id }}" data-maxqty="{{ $product->total_stock }}">+</span>
                                                        </div>
                                                        <span id="quantity-error"></span>
                                                        <p style="width: 100%;">AED {{ $product->order_amount }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($product->color_id != null)
                                                    <a href="javascript:;"><img class="remove_product" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->id }}" data-color_id="{{ $product->color_id }}" src="{{ asset('frontend/images/close.png') }}" alt="remove"></a>
                                                @else
                                                    <a href="javascript:;"><img class="remove_product" data-custom_id="{{ $product->custom_id }}" data-product_id="{{ $product->id }}" src="{{ asset('frontend/images/close.png') }}" alt="remove"></a>
                                                @endif
                                            </td>
                                        </tr>

                                            @if($product->addon != [] && $product->addon != null)
                                            <tr>
                                                <td colspan="2">
                                                    <div class="add-more-items" id="relatedProducts">
                                                        <div class="title-block">
                                                            <h4>Add on something to make it extra special!</h4>
                                                        </div>
                                                        <div class="products-list">
                                                            <div class="row no-gutters">
                                                                <div class="col-md-8">
                                                                    <div class="row">

                                                                        @foreach($product->addon as $prodcut_addon)
                                                                            
                                                                            @if($prodcut_addon->addon != null)

                                                                                @if(!in_array($prodcut_addon->addon->custom_id,$addon_ids))

                                                                                <div class="col-md-4">
                                                                                    <div class="products-list_item">
                                                                                        <div class="products-list_image">
                                                                                            <img src="{{ generateURL($prodcut_addon->addon->getImage()) }}" alt="addon">
                                                                                        </div>
                                                                                        <div class="products-list_details">
                                                                                            <ul>
                                                                                                <li>
                                                                                                    <h4>{{ $prodcut_addon->addon->getTitle() }}
                                                                                                    </h4>
                                                                                                </li>
                                                                                                <li>
                                                                                                    <h4>AED {{ $prodcut_addon->addon->getPrice() }}.00</h4>
                                                                                                </li>
                                                                                            </ul>
                                                                                            <a href="{{ route('cart') }}" class="btn-outline addToCartSingle" data-custom_id="{{ $prodcut_addon->addon->custom_id }}" data-minqty="1" >Add to Cart</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                    
                                                                                @endif

                                                                            @endif

                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="3" style="background-color: #EDE8E2; padding: 0;"></td>
                                            </tr>
                                            @endif  

                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @else
                                <p>cart is empty.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>   
                
            @if($products != null)    

                @if($subTotal >= 0)
                    <div class="col-xl-3">
                        <div class="order-summary" id="orderSummary">
                            <div class="order-summary-inner">
                                <div class="order-summary_figure">
                                    <ul>
                                        <li>
                                            <img src="{{ asset('frontend/images/order-cart-icon.svg') }}" alt="cart">
                                        </li>
                                        <li>
                                            <img src="{{ asset('frontend/images/order-delivery-icon.svg') }}" alt="delivery">
                                        </li>
                                        <li>
                                            <img src="{{ asset('frontend/images/order-checkout-icon.svg') }}" alt="checkout">
                                        </li>
                                    </ul>
                                </div>
                                <div class="title-block">
                                    <h4>Order Summary</h4>
                                </div>
                                <table width="100%">
                                    <tr>
                                        <td>Subtotal</td>
                                        <!-- <td><input type="text" id="Subtotal" readonly="true" value="0" style="border: 0; text-align: right;"></td> -->
                                        <td id="subTotal">AED {{ $subTotal }}</td>
                                    </tr>
                                    @if(Auth::check())
                                    <tr>
                                        <td>Delivery</td>
                                        <td id="delivery_charge">AED {{ $delivery_charge }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>VAT</td>
                                        <td id="vat">AED {{ $vat }}</td>
                                    </tr>
                                    <tr class="table-divider">
                                        <td height="1" colspan="2" style="background-color: rgba(112,112,112,0.34);"></td>
                                    </tr>
                                    <tr>
                                        <td height="20" colspan="2"></td>
                                    </tr>
                                    <tr class="total">
                                        <td>Total</td>
                                        <!-- <td><input type="text" id="Total" readonly="true" style="border: 0; text-align: right;"></td> -->
                                        <td id="total">AED {{ $total }}</td>
                                    </tr>
                                </table>
                                @if(Auth::check() == true)
                                    <a href="{{ route('logged-in-checkout') }}"> <button type="button" class="common-black-btn">Checkout</button> </a>
                                @else
                                    <button type="button" class="common-black-btn" data-toggle="modal" data-target="#checkout-login">Checkout</button>
                                @endif
                            </div>
                        </div>
                    </div> 
                @else
                    <p>cart is empty.</p>
                @endif         
            @endif
            </div>
    </article>
</section>
@endsection

@push('extra-js')
<script type="text/javascript" src="{{ asset('frontend/js/jcf.scrollable.js') }}"></script>

<script type="text/javascript">
 $(document).ready(function(){
        var cartScroll = $('.cart-list select.scrollbar_select ');
        // Options for custom Select
        jcf.setOptions('Select', {
            wrapNative: false,
            wrapNativeOnMobile: false,
            fakeDropInBody: true
        });
        jcf.replace(cartScroll);
        jcf.refresh();
    });     

    $(document).ready(function(){
        var cartSelect = $('.cart-list select');
        // Options for custom Select
        jcf.setOptions('Select', {
            wrapNative: false,
            wrapNativeOnMobile: false,
            fakeDropInBody: true
        });
        jcf.replace(cartSelect);
        jcf.refresh();
    });                              

    $('.minus').click(function () {
        var min_purchase_qty = $(this).data('minqty');

        if ($(this).is('[disabled=disabled]') == true) {
            return false;
        }
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        if (count == 1 || count <= min_purchase_qty) {
            $(this).attr('disabled', 'disabled');
            $(this).css('cursor', 'not-allowed');
        }
        $('.plus').attr('disabled', false);
        $('.plus').css('cursor', 'pointer');

        if($input.val() > min_purchase_qty){  

            // count = count < 1 ? 1 : count;
            $input.val(count);
            $input.change();

            //Code
            var element    = $(this);
            var quantity   = $(this).siblings('.product-qty').val();
            var product_id = $(this).data('product_id');
            var color_id   = $(this).data('color_id');
            var custom_id  = $(this).data('custom_id');

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('product.change.quantity') }}",
                data: {
                     _token: '{{ csrf_token() }}',
                     product_id : product_id,
                     custom_id  : custom_id,   
                     color_id   : color_id,
                     quantity   : quantity,
                },
                success: function(Response){
                    if(Response.success){
                        $('#header').replaceWith(Response.header);
                        $('#subTotal').replaceWith(Response.subTotal);
                        $('#delivery_charge').replaceWith(Response.delivery_charge);
                        $("#vat").replaceWith(Response.vat);
                        $("#total").replaceWith(Response.total);   

                        //Country(select)
                        customSelect = $('select');
                        // Options for custom Select
                        jcf.setOptions('Select', {
                            wrapNative: false,
                            wrapNativeOnMobile: false,
                            fakeDropInBody: false
                        });
                        jcf.replace(customSelect);
                        jcf.refresh();

                        $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
                            $(this).toggleClass('show')
                        });
                    }
                    if(Response.fail){
                        location.reload();
                    }
                    if(Response[0]){
                        location.reload();
                    }
                },
            });
        }
    });


    $('.plus').click(function () { 
        var max_purchase_qty    = $(this).data('maxqty'); 
        var $input              = $(this).parent().find('input');
        var count               = parseInt($input.val()) + 1;

        if (count > 1) {
            $('.minus').attr('disabled', false);
            $('.minus').css('cursor', 'pointer');
        }

        if (count > max_purchase_qty){
            $(this).attr('disabled', true);
            $(this).css('cursor', 'not-allowed');
            return false;
        }

        $input.val(count);
        $input.change();

        //Code
        var element    = $(this);
        var quantity   = $(this).siblings('.product-qty').val();
        var product_id = $(this).data('product_id');
        var color_id   = $(this).data('color_id');
        var custom_id  = $(this).data('custom_id');
        
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "{{ route('product.change.quantity') }}",
            data: {
                 _token: '{{ csrf_token() }}',
                 custom_id  : custom_id,   
                 color_id   : color_id,
                 quantity   : quantity,
            },
            success: function(Response){
                if(Response.success){
                    $('#header').replaceWith(Response.header);
                    $('#subTotal').replaceWith(Response.subTotal);
                    $('#delivery_charge').replaceWith(Response.delivery_charge);
                    $("#vat").replaceWith(Response.vat);
                    $("#total").replaceWith(Response.total);   

                    //Country(select)
                    customSelect = $('select');
                    // Options for custom Select
                    jcf.setOptions('Select', {
                        wrapNative: false,
                        wrapNativeOnMobile: false,
                        fakeDropInBody: false
                    });
                    jcf.replace(customSelect);
                    jcf.refresh();

                    $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
                        $(this).toggleClass('show')
                    });
                }
                if(Response.fail){
                    location.reload();
                }
                if(Response[0]){
                    location.reload();
                }
            },
        });

    });

    //Cart Product Remove
    $('.remove_product').on('click',function(){
        var element    = $(this);
        var custom_id  = $(this).data('custom_id');
        var product_id = $(this).data('product_id');
        var color_id   = $(this).data('color_id');
        var quantity   = $(this).data('quantity');
          $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('remove-from-cart') }}",
                data: {
                     _token: '{{ csrf_token() }}',
                     custom_id  : custom_id,
                     product_id : product_id,
                     color_id   : color_id,   
                     quantity   : quantity,
                },
                beforeSend: function() {
                    showLoader();
                },
                success: function(Response){
                    if(Response.success){
                        $('#header').replaceWith(Response['header']);
                        $('#subTotal').replaceWith(Response['subTotal']);
                        $("#vat").replaceWith(Response.vat);
                        $("#total").replaceWith(Response.total);
                        $("#delivery_charge").replaceWith(Response.delivery_charge);
                        element.closest('tr').remove();
                    }
                    if(Response.cartEmpty)
                    {
                        $('#header').replaceWith(Response['header']);
                        $('#main_cart').replaceWith(Response['cartEmpty']);
                        $("#relatedProducts").remove();
                        $("#orderSummary").remove();
                        element.closest('tr').remove();
                    }
                    if(Response.fail){
                        $('#product_error').replaceWith(Response['fail']);
                        location.reload();
                    }
                    if(Response[1]){
                        $('#header').replaceWith(Response[1]);
                        element.closest('tr').remove();
                        location.reload();
                    }else{
                        location.reload();
                    }
                    //Country(select)
                    customSelect = $('select');
                    // Options for custom Select
                    jcf.setOptions('Select', {
                        wrapNative: false,
                        wrapNativeOnMobile: false,
                        fakeDropInBody: false
                    });
                    jcf.replace(customSelect);
                    jcf.refresh();

                    $('.header-content_inner > ul > li:not(.wishlist)').click(function () {
                        $(this).toggleClass('show')
                    });
                },
                complete: function() {
                    removeLoader();
                },
            });
     });

    // add to cart(single product)
    $('.addToCartSingle').click(function() {
        var element             = $(this);
        var custom_id           = $(this).data('custom_id');

         $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: "{{ route('addtocart.singleproduct') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    custom_id : custom_id,
                },
                success: function(Response){
                    if(Response.success){
                        //$("#header").replaceWith(Response.header);
                        //$("#header").replaceWith(Response.cart);
                        //element.parent().parent().parent().remove();
                        location.reload();
                    }
                    if(Response.fail){
                        location.reload();
                    }
                    if(Response[0]){
                        location.reload();
                    }
                },
        });
        return false;
    });

</script>
@endpush


