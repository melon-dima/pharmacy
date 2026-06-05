<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Система</label>
        <input type="text" name="system" class="form-control" value="{{ old('system', $exchange->system ?? '1c') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Направление</label>
        <input type="text" name="direction" class="form-control" value="{{ old('direction', $exchange->direction ?? 'outbound') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Статус</label>
        <input type="text" name="status" class="form-control" value="{{ old('status', $exchange->status ?? 'pending') }}" required>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Payload (JSON)</label>
    <textarea name="payload" class="form-control" rows="3">{{ old('payload', isset($exchange) && $exchange->payload ? json_encode($exchange->payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Ответ</label>
    <textarea name="response" class="form-control" rows="3">{{ old('response', $exchange->response ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Время обмена</label>
    <input type="datetime-local" name="exchanged_at" class="form-control" value="{{ old('exchanged_at', isset($exchange) ? $exchange->exchanged_at?->format('Y-m-d\TH:i') : '') }}">
</div>
