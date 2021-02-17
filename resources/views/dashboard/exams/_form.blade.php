{{-- <div style="width: 600px; padding: 2rem 2rem 0 2rem;"> --}}
<div class="px-2">
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    {{-- Input To Display Subjects Name --}}
    <div class="form-group">
        <label> @lang('subjects.subject') </label>
        <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> <i class="fa fa-book"></i> </span> </div>
            <select class="custom-select" {{ isset($row) ? 'disabled' : '' }} name="subject_id">
                @if ($subjects->count() == 0)
                    <option> No Subjects</option>
                @endif

                @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ isset($row) ? ($row->subject_id == $subject->id ? 'selected' : '') : '' }}>
                    {{ $subject->subject }}
                </option>
                @endforeach
            </select>
        </div>
        <span id="subject_id_error" class="red error"></span>
    </div>

    {{-- Input To Display Time --}}
    <div class="form-group">
        <label> @lang('exams.time') </label>
        <div class="input-group">
            <div class="input-group-prepend"> <span class="input-group-text"> <i class="fa fa-clock"></i> </span> </div>
            <input type="number" class="form-control" name='time' placeholder="@lang('exams.time') | @lang('exams.by_minutes')"
                value="{{ $row->time ?? '60' }}">
        </div>
        <span id="time_error" class="red error"></span>
    </div>
</div>
