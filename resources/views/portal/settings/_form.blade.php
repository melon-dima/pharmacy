<div class="mb-3">
    <label class="form-label">Группа</label>
    <input type="text" name="group" class="form-control" value="{{ old('group', $setting->group ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Ключ</label>
    <input type="text" name="key" class="form-control" value="{{ old('key', $setting->key ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Значение</label>
    <textarea name="value" class="form-control" rows="3">{{ old('value', $setting->value ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Описание</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $setting->description ?? '') }}</textarea>
</div>
