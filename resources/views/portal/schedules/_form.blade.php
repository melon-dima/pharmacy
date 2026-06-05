<div class="mb-3">
    <label class="form-label">Сотрудник</label>
    <select name="employee_id" class="form-select" required>
        <option value="">Выберите сотрудника</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}" @selected(old('employee_id', $shift->employee_id ?? null) == $employee->id)>
                {{ $employee->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Аптека</label>
    <select name="pharmacy_id" class="form-select" required>
        <option value="">Выберите аптеку</option>
        @foreach($pharmacies as $pharmacy)
            <option value="{{ $pharmacy->id }}" @selected(old('pharmacy_id', $shift->pharmacy_id ?? null) == $pharmacy->id)>
                {{ $pharmacy->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Начало</label>
        <input type="datetime-local" name="starts_at" class="form-control" value="{{ old('starts_at', isset($shift) ? $shift->starts_at?->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Окончание</label>
        <input type="datetime-local" name="ends_at" class="form-control" value="{{ old('ends_at', isset($shift) ? $shift->ends_at?->format('Y-m-d\TH:i') : '') }}" required>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Статус</label>
    <input type="text" name="status" class="form-control" value="{{ old('status', $shift->status ?? 'scheduled') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Примечание</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $shift->notes ?? '') }}</textarea>
</div>
