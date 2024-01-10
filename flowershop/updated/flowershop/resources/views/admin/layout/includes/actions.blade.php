<div style="width: 190px;">
@if (in_array('view', $permissions) || in_array('edit', $permissions) || in_array('delete', $permissions))
	@if (in_array('view', $permissions))
		<a href="{{ route($routeName.'.show', $id) }}" onclick="addOverlay()" title="View" class="btn extra-maring btn-success btn-sm">
			<img class="btn-icon-img" src="{{ asset('admin/images/action/view.svg') }}">
		</a>
	@endif

	
	@if ( in_array('edit', $permissions) && !Route::is('admin.withdrawal-request.listing') && !Route::is('admin.csv-payments.listing'))
		<a href="{{ !empty($slug) ? route($routeName.'.edit', [$slug, $id]) : route($routeName.'.edit', $id) }}" onclick="addOverlay()" title="Edit" class="btn extra-maring btn-warning btn-sm">
			<img class="btn-icon-img" src="{{ asset('admin/images/action/edit.svg') }}">
		</a>
	@endif
	
	@if (in_array('delete', $permissions))
		<a title="Delete" href="{{ route($routeName.'.destroy', $id) }}" class="btn extra-maring btn-danger btn-sm act-delete">
			<img class="btn-icon-img" src="{{ asset('admin/images/action/delete.svg') }}">
		</a>
	@endif	
@endif
</div>




