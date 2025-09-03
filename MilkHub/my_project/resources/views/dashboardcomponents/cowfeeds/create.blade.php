@extends('dashboardlayout.dashboardlayout')
@section('contact')

<div class="container-fluid">
    <h2>إضافة إطعام جديد</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cowfeeds.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="cow_id" class="form-label">اختر البقرة</label>
            <select name="cow_id" id="cow_id" class="form-control" required>
                <option value="">-- اختر البقرة --</option>
                @foreach($cows as $cow)
                    <option value="{{ $cow->id }}" {{ old('cow_id') == $cow->id ? 'selected' : '' }}>
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
                    <option value="{{ $feed->id }}" {{ old('feed_id') == $feed->id ? 'selected' : '' }}>
                        {{ $feed->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">التاريخ</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') ?? date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الفترة</label><br>
            <input type="radio" id="morning" name="period" value="morning" {{ old('period') == 'morning' ? 'checked' : '' }} required>
            <label for="morning">صباحية</label>

            <input type="radio" id="evening" name="period" value="evening" {{ old('period') == 'evening' ? 'checked' : '' }} required>
            <label for="evening">مسائية</label>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">الكمية (كيلو)</label>
            <input type="number" step="0.01" min="0.01" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">حفظ</button>
        <a href="{{ route('cowfeeds.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>

@endsection
