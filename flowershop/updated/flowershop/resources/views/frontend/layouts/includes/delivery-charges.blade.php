@forelse ($country->deliveryCharges as $charges)
	<tr>
	    <td>{{ $charges->getCity() }}</td>
	    <td></td>
	    <td>{{ $charges->minimum_amount }}</td>
	    <td></td>
	    <td>{{ $charges->charges }}</td>
	</tr>
@empty
	<tr>
		<td colspan="5">Oops! No delivery details found!</td>
	</tr>
@endforelse