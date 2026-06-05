<div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $pharmacy->name ?? '') }}" required>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Код</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $pharmacy->code ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Телефон</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $pharmacy->phone ?? '') }}">
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Адрес</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $pharmacy->address ?? '') }}">
</div>

<div class="form-check mt-3">
    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $pharmacy->is_active ?? true))>
    <label class="form-check-label" for="is_active">Активна</label>
</div>
