<td class="check-item remove-when-print"> <input type="checkbox" class="check-box-id" name="id[]" value="{{ $row->id }}"></td>
<td> {{ $row->name }} </td>
<td> {{ $row->rooms->count() }} </td>
<td> {{ $row->subjects->count() }} </td>
<td class="remove-when-print"> @include('dashboard.includes.table._btn') </td>