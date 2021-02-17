{{-- <div style="width: 600px; padding: 2rem 2rem 0 2rem;"> --}}
<div class="px-2">
    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
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
