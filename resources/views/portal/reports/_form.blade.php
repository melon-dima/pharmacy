<div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $report->name ?? '') }}" required>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Тип</label>
        <input type="text" name="type" class="form-control" value="{{ old('type', $report->type ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Период с</label>
        <input type="date" name="period_start" class="form-control" value="{{ old('period_start', isset($report) ? $report->period_start?->format('Y-m-d') : '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Период по</label>
        <input type="date" name="period_end" class="form-control" value="{{ old('period_end', isset($report) ? $report->period_end?->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label">Сформировал</label>
        <select name="generated_by_user_id" class="form-select">
            <option value="">Не выбрано</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('generated_by_user_id', $report->generated_by_user_id ?? null) == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Дата генерации</label>
        <input type="datetime-local" name="generated_at" class="form-control" value="{{ old('generated_at', isset($report) ? $report->generated_at?->format('Y-m-d\TH:i') : '') }}">
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Payload (JSON)</label>
    <textarea name="payload" class="form-control" rows="4">{{ old('payload', isset($report) && $report->payload ? json_encode($report->payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
</div>
