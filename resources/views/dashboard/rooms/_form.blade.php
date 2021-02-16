<div class="px-2">
    <div class="row">
        <div class="col-md-12">
            {{-- Input To Display Room Name --}}
            <div class="form-group">
                <label> @lang('rooms.name') </label>
                <div class="input-group">
                    <div class="input-group-prepend"> <span class="input-group-text"> <i class="fa fa-door-closed"></i> </span> </div>
                    <input type="text" class="form-control" name='name' placeholder="@lang('rooms.name')" value="{{ $row->name ?? '' }}">
                </div>
                <span id="name_error" class="red error"></span>
            </div>
        </div>

        <div class="col-md-12">
            {{-- Input To Display Row Name --}}
            <div class="form-group">
                <label> @lang('rows.name') </label>
                <div class="input-group">
                    <div class="input-group-prepend"> <span class="input-group-text"> <i class="fa fa-school"></i> </span> </div>
                    <select class="custom-select" {{ isset($row) ? 'disabled' : '' }} name="row_id">
                        @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ isset($row) ? ($row->row_id == $class->id ? 'selected' : '') : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <span id="row_id_error" class="red error"></span>
            </div>
        </div>
    </div>
</div>
