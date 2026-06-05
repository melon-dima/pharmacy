<div class="mb-3">
    <label class="form-label">Сотрудник</label>
    <select name="employee_id" class="form-select" required>
        <option value="">Выберите сотрудника</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}" @selected(old('employee_id', $timelog->employee_id ?? null) == $employee->id)>
                {{ $employee->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Смена</label>
    <select name="shift_id" class="form-select">
        <option value="">Без смены</option>
        @foreach($shifts as $shift)
            <option value="{{ $shift->id }}" @selected(old('shift_id', $timelog->shift_id ?? null) == $shift->id)>
                #{{ $shift->id }} ({{ $shift->starts_at?->format('d.m H:i') }} - {{ $shift->ends_at?->format('d.m H:i') }})
            </option>
        @endforeach
    </select>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Тип события</label>
        <input type="text" name="type" class="form-control" value="{{ old('type', $timelog->type ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Источник</label>
        <input type="text" name="source" class="form-control" value="{{ old('source', $timelog->source ?? '') }}">
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Дата/время</label>
    <input type="datetime-local" name="logged_at" class="form-control" value="{{ old('logged_at', isset($timelog) ? $timelog->logged_at?->format('Y-m-d\TH:i') : '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Meta (JSON)</label>
    <textarea name="meta" class="form-control" rows="3">{{ old('meta', isset($timelog) && $timelog->meta ? json_encode($timelog->meta, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
</div>
