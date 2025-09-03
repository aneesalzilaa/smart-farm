@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid" style="max-width: 500px;">
    <h2 style="margin-bottom: 20px; color: #333;">تعديل تسليم المورد</h2>

    <form action="{{ route('milk_supplier_deliveries.update', $delivery->id) }}" method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="milk_supplier_id" style="font-weight: 600;">المورد:</label>
            <select id="milk_supplier_id" name="milk_supplier_id" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="" disabled>اختر المورد</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ $delivery->milk_supplier_id == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
            @error('milk_supplier_id')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="date" style="font-weight: 600;">التاريخ:</label>
            <input type="date" id="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($delivery->date)->format('Y-m-d')) }}" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
            @error('date')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="morning_quantity" style="font-weight: 600;">الكمية الصباحية (كغ):</label>
            <input type="number" step="0.01" id="morning_quantity" name="morning_quantity" value="{{ old('morning_quantity', $delivery->morning_quantity) }}" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
            @error('morning_quantity')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 15px;">
            <label for="evening_quantity" style="font-weight: 600;">الكمية المسائية (كغ):</label>
            <input type="number" step="0.01" id="evening_quantity" name="evening_quantity" value="{{ old('evening_quantity', $delivery->evening_quantity) }}" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
            @error('evening_quantity')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="price_per_liter" style="font-weight: 600;">سعر الكيلو (يُفضل مطابقته لسعر المورد):</label>
            <input type="number" step="0.01" id="price_per_liter" name="price_per_liter" value="{{ old('price_per_liter', $delivery->price_per_liter) }}" required style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
            @error('price_per_liter')
                <div style="color: red; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="background-color: #2196F3; color: white; padding: 12px 20px; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; width: 100%;">💾 تحديث</button>
    </form>
</div>
@endsection
