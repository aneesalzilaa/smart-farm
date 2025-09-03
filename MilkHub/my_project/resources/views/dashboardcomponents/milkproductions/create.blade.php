@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
    <h2>إضافة إنتاج الحليب</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('milkproductions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="cow_id" class="form-label">اختر البقرة</label>
            <select name="cow_id" id="cow_id" class="form-control" required>
                <option value="">-- اختر بقرة --</option>
                @foreach(\App\Models\Cow::all() as $cow)
                    <option value="{{ $cow->id }}" {{ old('cow_id') == $cow->id ? 'selected' : '' }}>
                        {{ $cow->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="production_date" class="form-label">تاريخ الإنتاج</label>
            <input type="date" name="date" id="production_date" class="form-control" value="{{ old('production_date', date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الفترة</label>
            <select name="period" id="period" class="form-control" required>
                <option value="">-- اختر الفترة --</option>
                <option value="morning" {{ old('period') == 'morning' ? 'selected' : '' }}>صباحية</option>
                <option value="evening" {{ old('period') == 'evening' ? 'selected' : '' }}>مسائية</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">كمية الحليب (كيلو)</label>
            <input type="number" step="0.01" min="0" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">حفظ</button>
        <a href="{{ route('milkproductions.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection

