@extends('admin.layout.app')

@push('css-top')
    <link href="{{ asset('admin/css/profile.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
@endpush

@push('breadcrumb')
    {!! Breadcrumbs::render('role_edit', $role->id) !!}
@endpush

@push('page-title')
    <h3 class="page-title"> 
        Create a new {{ strtolower(str_singular($title)) }}
    </h3>
@endpush

@section('main-content')
    <div class="row">
        <div class="col-md-12">

            {{-- Change Password --}}
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Enter user's personal information</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <form action="{{ route('admin.roles.update', $role->id) }}" role="form" id="frmUpdateRole" name="frmUpdateRole" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')

                                        {{-- First Name --}}
                                        <div class="form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
                                            <label class="control-label">{!! $mend_sign !!}Name</label>
                                            <input type="text" placeholder="Enter Name Here" class="form-control" id="full_name" name="full_name" maxlength="50" autocomplete="off" value="{{ old('full_name', $role->full_name) }}" />
                                            @if($errors->has('full_name'))
                                                <span class="help-block">
                                                    {{ $errors->first('full_name') }}
                                                </span>
                                            @endif
                                        </div>
                                        {{-- Email --}}
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                            <label class="control-label">{!! $mend_sign !!}Email Address</label>
                                            <input type="email" placeholder="Enter Email Address Here" class="form-control" id="email" name="email" maxlength="150"  autocomplete="off" value="{{ old('email', $role->email) }}" />
                                            @if($errors->has('email'))
                                                <span class="help-block">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Contact --}}
                                        <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                                            <label class="control-label">Contact Number</label>
                                            <input type="text" placeholder="Enter Contact Number Here" class="form-control" id="contact" name="contact" maxlength="150"  autocomplete="off" value="{{ old('contact', $role->contact) }}"/>
                                            @if($errors->has('contact'))
                                                <span class="help-block">
                                                    {{ $errors->first('contact') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Select Avatar</label>
                                            <input type="file" placeholder="Select Avatar" class="form-control" id="profile" name="profile" accept=".jpg,.jpeg,.png" />
                                        </div>

                                        {{-- Permission --}}
                                        <div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
                                            <label class="control-label">{!! $mend_sign !!}Permissions</label>
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Pages</th>
                                                        <th>Access</th>
                                                        <th>Add</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                        <th>View</th>
                                                        <th><input type="checkbox" class="checkall" name="checkall" ></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php
                                                        $user_permission = unserialize($role->permissions);
                                                        $total_permissions = 0;
                                                        $given_permission_count = 0;
                                                    @endphp

                                                    @foreach ($roles as $db_role)
                                                    @php
                                                        $permissions = !empty($user_permission[$db_role->id]) ? explode(',', $user_permission[$db_role->id]['permissions']) : [];
                                                    @endphp
                                                        @if ($db_role->id != 1)
                                                            @php 
                                                                $allowed_permissions = explode(',', $db_role->allowed_permissions); 
                                                                $total_permissions += count($allowed_permissions);
                                                                $given_permission_count += count($permissions);
                                                            @endphp
                                                            <tr class="role_row_{{ $db_role->id }}">
                                                                <td>{{$db_role->title}}</td>
                                                                @php $allowed_permissions = explode(',', $db_role->allowed_permissions); @endphp
                                                                <td>
                                                                    @if ( in_array('access', $allowed_permissions) )
                                                                        <input data-role-id="{{ $db_role->id }}" class="role_permission_{{ $db_role->id }}" data-error-container='#permission_error' name="roles[{{ strtolower($db_role->id) }}][permissions][]" type="checkbox" value="access" {{ in_array('access', $permissions) ? 'checked' : '' }} {{ $db_role->id == 1 ? 'checked disabled' : '' }}>
                                                                    @else N / A @endif
                                                                </td>
                                                                <td>
                                                                    @if ( in_array('add', $allowed_permissions) )
                                                                        <input data-role-id="{{ $db_role->id }}" class="role_permission_{{ $db_role->id }}" data-error-container='#permission_error' name="roles[{{ strtolower($db_role->id) }}][permissions][]" type="checkbox" value="add" {{ in_array('add', $permissions) ? 'checked' : '' }}>
                                                                    @else N / A @endif
                                                                </td>
                                                                <td>
                                                                    @if ( in_array('edit', $allowed_permissions) )
                                                                        <input data-role-id="{{ $db_role->id }}" class="role_permission_{{ $db_role->id }}" data-error-container='#permission_error' name="roles[{{ strtolower($db_role->id) }}][permissions][]" type="checkbox" value="edit" {{ in_array('edit', $permissions) ? 'checked' : '' }}>
                                                                    @else N / A @endif
                                                                </td>
                                                                <td>
                                                                    @if ( in_array('delete', $allowed_permissions) )
                                                                        <input data-role-id="{{ $db_role->id }}" class="role_permission_{{ $db_role->id }}" data-error-container='#permission_error' name="roles[{{ strtolower($db_role->id) }}][permissions][]" type="checkbox" value="delete" {{ in_array('delete', $permissions) ? 'checked' : '' }}>
                                                                    @else N / A @endif
                                                                </td>
                                                                <td>
                                                                    @if ( in_array('view', $allowed_permissions) )
                                                                        <input data-role-id="{{ $db_role->id }}" class="role_permission_{{ $db_role->id }}" data-error-container='#permission_error' name="roles[{{ strtolower($db_role->id) }}][permissions][]" type="checkbox" value="view" {{ in_array('view', $permissions) ? 'checked' : '' }}>
                                                                    @else N / A @endif
                                                                </td>
                                                                <td>
                                                                    <input type="checkbox" {{ count($permissions) == count($allowed_permissions) ? 'checked' : '' }} class="checkrow"  name="checkrow" data-roleid='{{ $db_role->id }}'>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div id="permission_error"></div>

                                            @if($errors->has('permissions'))
                                                <span class="help-block">
                                                    {{ $errors->first('permissions') }}
                                                </span>
                                            @endif
                                        </div>



                                        <div class="margiv-top-10">
                                            <input type="submit" value="Save Changes" class="btn green">
                                            <a href="{{ route('admin.roles.index') }}" class="btn default">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@push('extra-js')
    <script type="text/javascript">
        $(document).ready(function() {

            if( {{ $total_permissions }} == {{ $given_permission_count }} ) {
                $('.checkall').prop('checked', true);
                $('.checkall').parent('span').addClass('checked');
                $('.checkall').change();
            }

            jQuery.validator.addMethod("permission", function(value, element) { 
                return $("[name^=roles]:checked").length > 0;
            }, "Select at least one permission.");


            $("#frmUpdateRole").validate({
                ignore: [':hidden', ],
                rules: {
                    full_name: {
                        required: true,
                        not_empty: true,
                        maxlength: 50,
                    },
                    "roles[]": {
                        permission: true,
                    },
                    email:{
                        required:true,
                        not_empty:true,
                        maxlength:150,
                        email: true,
                        valid_email: true,
                        remote: {
                            url: "{{ route('admin.check.email') }}",
                            type: "post",
                            data: {
                                _token: function() {
                                    return "{{csrf_token()}}"
                                },
                                type: "admin",
                                id: "{{ $role->id }}",
                            }
                        },
                    },
                    contact:{
                        required:false,
                        not_empty:true,
                        maxlength:16,
                        minlength:6,
                        pattern: /^(\d+)(?: ?\d+)*$/,
                        remote: {
                            url: "{{ route('admin.check.contact') }}",
                            type: "post",
                            data: {
                                _token: function() {
                                    return "{{csrf_token()}}"
                                },
                                type: "admin",
                                id: "{{ $role->id }}",
                            }
                        },
                    },
                    roles:{
                        required: true,
                    },
                    profile:{
                        extension: "jpg|jpeg|png",
                    },
                },
                messages: {
                    full_name:{
                        required:"@lang('validation.required',['attribute'=>'name'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'name'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'name','max'=>50])",
                    },
                    email:{
                        required:"@lang('validation.required',['attribute'=>'email'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'email'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'email','max'=>150])",
                        email:"@lang('validation.email',['attribute'=>'email'])",
                        valid_email:"@lang('validation.email',['attribute'=>'email'])",
                        remote:"@lang('validation.unique',['attribute'=>'email'])",
                    },
                    contact:{
                        required:"@lang('validation.required',['attribute'=>'contact number'])",
                        not_empty:"@lang('validation.not_empty',['attribute'=>'contact number'])",
                        maxlength:"@lang('validation.max.string',['attribute'=>'contact number','max'=>16])",
                        minlength:"@lang('validation.min.string',['attribute'=>'contact number','min'=>6])",
                        pattern:"@lang('validation.numeric',['attribute'=>'contact number'])",
                        pattern: /^(\d+)(?: ?\d+)*$/,
                        remote:"@lang('validation.unique',['attribute'=>'contact number'])",
                    },
                    profile:{
                        extension:"@lang('validation.mimetypes',['attribute'=>'profile photo','value'=>'jpg,png,jpeg'])"
                    },
                },
                errorClass: 'help-block',
                errorElement: 'span',
                highlight: function (element) {
                   $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function (element) {
                   $(element).closest('.form-group').removeClass('has-error');
                },
                errorPlacement: function (error, element) {
                    if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $(' input[name^="roles"] ').rules("add", {
                permission: true,
            });

            $('#frmUpdateRole').submit(function(){
                if( $(this).valid() ){
                    addOverlay();
                    $("input[type=submit], input[type=button], button[type=submit]").prop("disabled", "disabled");
                    return true;
                }
                else{
                    return false;
                }
            });
        });
    </script>

    <script type="text/javascript">

        $(document).ready(function() {
            $(document).on('click', '.checkall', function () {       
                if($(this).is(":checked")) {
                     $('.checkrow').prop('checked', true);
                     $('.checkrow').parent('span').addClass('checked');
                     $('.checkrow').change();
                }else{
                     $('.checkrow').prop('checked', false);
                     $('.checkrow').parent('span').removeClass('checked');
                     $('.checkrow').change();
                }
            });

            $(document).on('change', '.checkrow', function () {
                var rid=$(this).data("roleid")  ;     
                if($(this).is(":checked")) {
                    $(".role_row_"+rid+" span input[type='checkbox']" ).prop('checked', true);
                    $(".role_row_"+rid+" span" ).addClass('checked');                    
                }else{
                    $(".role_row_"+rid+" span" ).removeClass('checked');  
                    $(".role_row_"+rid+" span input[type='checkbox']" ).prop('checked', false);     
                }
                manageAll();
            });

            $('[class^=role_permission_]').on('change', function() {
                manageCheckEvent(this);
                manageAll();
            });

            function manageAll() {
                if( $('[class^=role_permission_]:checked').length == $('[class^=role_permission_]').length ) {
                    $(".checkall").prop('checked', true);
                    $('.checkall').parent('span').addClass('checked');
                    $('.checkall').change();
                } else {
                    $(".checkall").prop('checked', false);
                    $('.checkall').parent('span').removeClass('checked');
                    $('.checkall').change();
                }
                ($('#frmUpdateRole').valid());
            }

            function manageCheckEvent(element) {
                var is_checked = false;
                var class_name = $(element).attr('class');
                var last_element = $('.'+class_name).parents('tr').children('td').last();

                if( $('.'+class_name+':checked').length == $('.'+class_name).length ) {
                    last_element.find("span input[type='checkbox']").prop('checked', true);
                    last_element.find("span").addClass('checked');
                } else {
                    last_element.find("span input[type='checkbox']").prop('checked', false);
                    last_element.find("span").removeClass('checked');
                }
            }
        });
    </script>
@endpush