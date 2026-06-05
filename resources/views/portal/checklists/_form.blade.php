<div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $checklist->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Аптека</label>
    <select name="pharmacy_id" class="form-select">
        <option value="">Все аптеки</option>
        @foreach($pharmacies as $pharmacy)
            <option value="{{ $pharmacy->id }}" @selected(old('pharmacy_id', $checklist->pharmacy_id ?? null) == $pharmacy->id)>
                {{ $pharmacy->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Периодичность</label>
    <input type="text" name="frequency" class="form-control" value="{{ old('frequency', $checklist->frequency ?? 'daily') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Описание</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $checklist->description ?? '') }}</textarea>
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $checklist->is_active ?? true))>
    <label class="form-check-label" for="is_active">Активен</label>
</div>
