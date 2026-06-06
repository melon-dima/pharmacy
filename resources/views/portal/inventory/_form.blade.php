@php
    $medicine = $item->medicine ?? null;
@endphp

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
    <label class="form-label">Аптека</label>
    <select name="pharmacy_id" class="form-select" required>
        <option value="">Выберите аптеку</option>
        @foreach($pharmacies as $pharmacy)
            <option value="{{ $pharmacy->id }}" @selected(old('pharmacy_id', $item->pharmacy_id ?? null) == $pharmacy->id)>
                {{ $pharmacy->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Название лекарства</label>
        <input type="text" name="medicine_name" class="form-control" value="{{ old('medicine_name', $medicine->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Код / артикул</label>
        <input type="text" name="medicine_sku" class="form-control" value="{{ old('medicine_sku', $medicine->sku ?? '') }}">
    </div>
</div>

<div class="row g-3 mt-0">
    <div class="col-md-6">
        <label class="form-label">Производитель</label>
        <input type="text" name="manufacturer" class="form-control" value="{{ old('manufacturer', $medicine->manufacturer ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Единица учета</label>
        <input type="text" name="unit" class="form-control" value="{{ old('unit', $medicine->unit ?? 'pcs') }}" required>
    </div>
</div>

<div class="row g-3 mt-0">
    <div class="col-md-4">
        <label class="form-label">Количество</label>
        <input type="number" min="0" name="quantity" class="form-control" value="{{ old('quantity', $item->quantity ?? 0) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Минимальный остаток</label>
        <input type="number" min="0" name="minimum_quantity" class="form-control" value="{{ old('minimum_quantity', $item->minimum_quantity ?? 0) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Годен до</label>
        <input type="date" name="expires_on" class="form-control" value="{{ old('expires_on', isset($item) && $item->expires_on ? $item->expires_on->format('Y-m-d') : '') }}">
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Примечание</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $item->notes ?? '') }}</textarea>
</div>
