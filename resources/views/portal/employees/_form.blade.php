<div class="mb-3">
    <label class="form-label">ФИО</label>
    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $employee->full_name ?? '') }}" required>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Связанный пользователь</label>
        <select name="user_id" class="form-select">
            <option value="">Не выбран</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $employee->user_id ?? null) == $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Аптека</label>
        <select name="pharmacy_id" class="form-select">
            <option value="">Не выбрана</option>
            @foreach($pharmacies as $pharmacy)
                <option value="{{ $pharmacy->id }}" @selected(old('pharmacy_id', $employee->pharmacy_id ?? null) == $pharmacy->id)>
                    {{ $pharmacy->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label">Должность</label>
        <input type="text" name="position" class="form-control" value="{{ old('position', $employee->position ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Телефон</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone ?? '') }}">
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Дата найма</label>
        <input type="date" name="hired_at" class="form-control" value="{{ old('hired_at', isset($employee) ? $employee->hired_at?->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="form-check mt-3">
    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $employee->is_active ?? true))>
    <label class="form-check-label" for="is_active">Активен</label>
</div>
