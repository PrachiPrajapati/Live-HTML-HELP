@extends('frontend.layouts.app')

@section('main-content')

<!-- account settings -->
<section class="account-settings-section common-spacing">
    <article class="container">
        <div class="title-block">
            <h4>My Account</h4>
        </div>
        <div class="acc-info">
                <div class="title-block">
                    <h4>Account Information</h4>
                </div>
                <form>
                    <ul>
                        <li>    
                            <label>Email</label>
                            <p>{{ Auth::user()->email }}</p>
                        </li>
                        <li>
                            <label>Password</label>
                            <p>•••••••••••••••••••••••••</p>
                        </li>
                    </ul>
                    <div class="btn-group">
                        <a href="#" class="btn-outline" data-target="#edit-info" data-toggle="modal">Edit Profile</a>
                        <a href="#" data-target="#edit-password" data-toggle="modal">Change Password</a>
                    </div>
                </form>
        </div>
        <div class="my-address">
            <div class="title-block has-subtitle">
                <h4>My Addresses</h4>
                <a href="#" data-toggle="modal" class="addNewAddress" data-target="#edit-address">+ Add a New Address</a>
            </div>
            <form class="default-selection">
                @if($addresses != null && $addresses != '[]')
                    <ul id="addAddress">
                        @foreach($addresses as $address)
                            @if($address->city != null && $address->country != null)
                                @if($address->is_default == "y")    
                                    <li>
                                        <div>
                                            <p><strong>{{ $address->first_name }} {{ $address->last_name }}</strong></p>
                                            <address>{{ $address->address }}
                                            {{ $address->city->getCity() }}
                                            {{ $address->country->getName() }}
                                            </address>
                                            <p>+{{ $address->contact }}</p>
                                        </div>
                                        <div>
                                            <div class="mark-default checked">
                                                <a href="javascript:;" class="btn-outline">Make Default</a>
                                                <input type="radio" name="default-address" data-id="{{ $address->id }}" data-user_id="{{ $address->user_id }}" checked>
                                                <p>Default Address</p>
                                            </div>
                                            <div class="mark-default">
                                                <a href="#" class="btn-outline editAddress" data-id="{{ $address->id }}" data-first_name="{{ $address->first_name }}" data-last_name="{{ $address->last_name }}" data-pincode="{{ $address->pincode }}" data-address="{{ $address->address }}" data-contact="{{ $address->contact }}" data-target="#edit-address" data-toggle="modal">Edit</a>
                                                <a href="javascript:;" data-id="{{ $address->id }}" class="btn-outline deleteAddress">Delete</a>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                       <div>
                                            <p><strong>{{ $address->first_name }} {{ $address->last_name }}</strong></p>
                                            <address>{{ $address->address }}
                                            {{ $address->city->getCity() }}
                                            {{ $address->country->getName() }}
                                            </address>
                                            <p>+{{ $address->contact }}</p>
                                       </div>
                                        <div>
                                            <div class="mark-default">
                                                <a href="javascript:;" class="btn-outline">Make Default</a>
                                                <input type="radio" name="default-address" data-id="{{ $address->id }}" data-user_id="{{ $address->user_id }}">
                                                <p>Default Address</p>
                                            </div>
                                            <div class="mark-default">
                                                <a href="#" class="btn-outline editAddress" data-id="{{ $address->id }}" data-first_name="{{ $address->first_name }}" data-last_name="{{ $address->last_name }}" data-pincode="{{ $address->pincode }}" data-address="{{ $address->address }}" data-contact="{{ $address->contact }}" data-target="#edit-address" data-toggle="modal">Edit</a>
                                                <a href="javascript:;" data-id="{{ $address->id }}" class="btn-outline deleteAddress">Delete</a>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endif   
                        @endforeach
                    </ul>
                @else
                    <p>Please Add Your Address.</p>
                @endif
            </form>
        </div>
    </article>
</section>
@endsection

@push('top-css')
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/bootstrap-datetimepicker.css') }}">
@endpush

@push('extra-js')
    <script type="text/javascript" src="{{ asset('frontend/js/jquery.inputmask.js') }}"></script>

    <script type="text/javascript" src="{{ asset('frontend/js/moment-with-locales.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-datetimepicker.js') }}"></script>
    
    <script>
        $(document).ready(function () {

            // select 
            $(function () {
                var customSelect = $('select:not(.cart-select)');
                // Options for custom Select
                jcf.setOptions('Select', {
                    wrapNative: false,
                    wrapNativeOnMobile: false,
                    fakeDropInBody: false
                });
                jcf.replace(customSelect);
                jcf.refresh();

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

             // input mask
            $('.card-field').inputmask({ mask: ["9999 9999 9999 9999", "9999 9999 9999 9999",], keepStatic: true, "placeholder": "0000 0000 0000 0000" });
            $('.date-field').inputmask({ mask: ["99 / 99", "99 / 99",], keepStatic: true, "placeholder": "MM / YY" });

            // modal backdrop
            $('.modal.right').on('shown.bs.modal', function () {
                // $('.modal-backdrop').addClass('right-modal');
                // modal_backdrop();
            });
            function modal_backdrop(){
                $('.modal-backdrop.right-modal').on('click',function(){
                    $('body').removeClass('modal-open');
                    $('body').removeAttr('style');
                    $('.modal.right').removeClass('show');
                    $(this).hide();
                    $(this).removeClass('right-modal');
                });
            }

            // default selection
            $('.default-selection ul li .mark-default input').change(function(){

                var id      =   $(this).data('id');
                var user_id =   $(this).data('user_id');

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{ route('user.setdefaultaddress') }}",
                    data: {
                             _token: '{{ csrf_token() }}',
                            id : id,
                            user_id : user_id,
                        },
                    success: function(Response){
                        if(Response.success){
                        }
                    },
                });

                $(this).closest('li').siblings('li').find('.mark-default').removeClass('checked');
                $(this).closest('li').siblings('li').find('input').removeAttr('checked');
                $(this).attr('checked','checked');
                $(this).parent().addClass('checked') 
            }); 

            // add new address
            $('.addNewAddress').on('click',function(){
                $("#addressEdit").replaceWith('<input type="hidden" id="addressEdit" name="editAddress" value="false">');
                $("#addressEditId").replaceWith('<input type="hidden" id="addressEditId" name="id" value=""');
                $("#add_firstname").val('');
                $("#add_lastname").val('');
                $("#add_pincode").val('');
                $("#add_address").val('');
                $("#add_contact").val('');
            });

            // edit address
            $('.editAddress').on('click',function(){
                var id          =   $(this).data('id');
                var first_name  =   $(this).data('first_name');
                var last_name   =   $(this).data('last_name');
                var pincode     =   $(this).data('pincode');
                var address     =   $(this).data('address');
                var contact     =   $(this).data('contact');
          
                $("#add_firstname").val(first_name);
                $("#add_lastname").val(last_name);
                $("#add_pincode").val(pincode);
                $("#add_address").val(address);
                $("#add_contact").val(contact);
                $("#addressEdit").replaceWith('<input type="hidden" id="addressEdit" name="editAddress" value="true">');
                $("#addressEditId").replaceWith('<input type="hidden" id="addressEditId" name="id" value="'+id+'">');
            });

            // delete address
            $('.deleteAddress').on('click',function(){
                var id      =   $(this).data('id');

                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    url: "{{ route('user.delete-address') }}",
                    data: {
                            _token: '{{ csrf_token() }}',
                            id : id,
                    },
                    success: function(Response){
                        if(Response.success){
                        }
                    },
                });

                $(this).parent().parent().remove();
            });
        });
    </script>
@endpush