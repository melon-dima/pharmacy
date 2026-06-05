<div class="mb-3">
    <label class="form-label">Сотрудник</label>
    <select name="employee_id" class="form-select" required>
        <option value="">Выберите сотрудника</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}" @selected(old('employee_id', $request->employee_id ?? null) == $employee->id)>
                {{ $employee->full_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Тип</label>
        <input type="text" name="type" class="form-control" value="{{ old('type', $request->type ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Начало</label>
        <input type="date" name="starts_on" class="form-control" value="{{ old('starts_on', isset($request) ? $request->starts_on?->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Окончание</label>
        <input type="date" name="ends_on" class="form-control" value="{{ old('ends_on', isset($request) ? $request->ends_on?->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Причина</label>
    <textarea name="reason" class="form-control" rows="3">{{ old('reason', $request->reason ?? '') }}</textarea>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Статус</label>
        <input type="text" name="status" class="form-control" value="{{ old('status', $request->status ?? 'pending') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Согласовал</label>
        <select name="approved_by_user_id" class="form-select">
            <option value="">Не выбрано</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('approved_by_user_id', $request->approved_by_user_id ?? null) == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Дата решения</label>
        <input type="datetime-local" name="decided_at" class="form-control" value="{{ old('decided_at', isset($request) ? $request->decided_at?->format('Y-m-d\TH:i') : '') }}">
    </div>
</div>
