@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $medicine->name ?? '') }}" required>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Код / артикул</label>
        <input type="text" name="sku" class="form-control" value="{{ old('sku', $medicine->sku ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Производитель</label>
        <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer', $medicine->manufacturer ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Форма выпуска</label>
        <input type="text" name="dosage_form" class="form-control" value="{{ old('dosage_form', $medicine->dosage_form ?? '') }}">
    </div>
</div>

<div class="row g-3 mt-0">
    <div class="col-md-4">
        <label class="form-label">Цена</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', isset($medicine) ? number_format($medicine->price_cents / 100, 2, '.', '') : '0.00') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Валюта</label>
        <input type="text" name="currency" maxlength="3" class="form-control" value="{{ old('currency', $medicine->currency ?? 'RUB') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Единица учета</label>
        <input type="text" name="unit" class="form-control" value="{{ old('unit', $medicine->unit ?? 'pcs') }}" required>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Описание для каталога</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $medicine->description ?? '') }}</textarea>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Внешняя система</label>
        <input type="text" name="external_system" class="form-control" placeholder="1c" value="{{ old('external_system', $medicine->external_system ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Внешний ID</label>
        <input type="text" name="external_id" class="form-control" value="{{ old('external_id', $medicine->external_id ?? '') }}">
    </div>
</div>

<div class="form-check mt-3">
    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $medicine->is_active ?? true))>
    <label class="form-check-label" for="is_active">Активно в каталоге</label>
</div>
