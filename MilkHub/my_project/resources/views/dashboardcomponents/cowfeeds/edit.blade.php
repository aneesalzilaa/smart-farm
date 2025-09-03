@extends('dashboardlayout.dashboardlayout')

@section('contact')

<div class="container-fluid">
    <h2>تعديل سجل الإطعام</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cowfeeds.update', $cowFeed->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="cow_id" class="form-label">اختر البقرة</label>
            <select name="cow_id" id="cow_id" class="form-control" required>
                <option value="">-- اختر البقرة --</option>
                @foreach($cows as $cow)
                    <option value="{{ $cow->id }}" {{ (old('cow_id') ?? $cowFeed->cow_id) == $cow->id ? 'selected' : '' }}>
                        {{ $cow->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="feed_id" class="form-label">اختر نوع العلف</label>
            <select name="feed_id" id="feed_id" class="form-control" required>
                <option value="">-- اختر نوع العلف --</option>
                @foreach($feeds as $feed)
                    <option value="{{ $feed->id }}" {{ (old('feed_id') ?? $cowFeed->feed_id) == $feed->id ? 'selected' : '' }}>
                        {{ $feed->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">التاريخ</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') ?? \Carbon\Carbon::parse($cowFeed->date)->format('Y-m-d') }}" required>
        </div>

<div class="mb-3">
    <label for="period" class="form-label">الفترة</label>
    <select name="period" id="period" class="form-control" required>
        <option value="">-- اختر الفترة --</option>
        <option value="morning" {{ (old('period') ?? $cowFeed->period) == 'morning' ? 'selected' : '' }}>صباحية</option>
        <option value="evening" {{ (old('period') ?? $cowFeed->period) == 'evening' ? 'selected' : '' }}>مسائية</option>
    </select>
</div>

<div class="mb-3">
    <label for="quantity" class="form-label">الكمية (كيلو)</label>
    <input type="number" step="0.01" min="0.01" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') ?? ($cowFeed->period == 'morning' ? $cowFeed->morning_quantity : $cowFeed->evening_quantity) }}" required>
</div>

        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('cowfeeds.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const periodSelect = document.getElementById('period');
        const quantityInput = document.getElementById('quantity');

        // تعديل الكمية بناءً على الفترة المختارة
        periodSelect.addEventListener('change', function() {
            const selectedPeriod = periodSelect.value;

            if (selectedPeriod === 'morning') {
                quantityInput.value = '{{ old("morning_quantity") ?? $cowFeed->morning_quantity }}'; // الكمية الصباحية
            } else if (selectedPeriod === 'evening') {
                quantityInput.value = '{{ old("evening_quantity") ?? $cowFeed->evening_quantity }}'; // الكمية المسائية
            }
        });

        // تعيين الكمية الأولية بناءً على الفترة المختارة عند تحميل الصفحة
        const initialPeriod = periodSelect.value;
        if (initialPeriod === 'morning') {
            quantityInput.value = '{{ old("morning_quantity") ?? $cowFeed->morning_quantity }}';
        } else if (initialPeriod === 'evening') {
            quantityInput.value = '{{ old("evening_quantity") ?? $cowFeed->evening_quantity }}';
        }
    });
</script>
@endsection
