@extends('dashboardlayout.dashboardlayout')
@section('contact')

<style>
  .header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
  }
  .header-row h2 {
    margin: 0;
  }
</style>

<div class="container-fluid">
    <div class="header-row mt-5">
        <h2>قائمة إطعام الأبقار</h2>
        <div>
            <a href="{{ route('cowfeeds.create') }}" class="btn btn-success">إضافة إطعام جديد</a>
            <a href="{{ route('cowfeeds.daily') }}" class="btn btn-info ml-2">عرض الإطعام اليومي</a>
        </div>
    </div>

    {{-- زر إطعام جميع الأبقار --}}
    <div class="mb-4">
      <form action="{{ route('cowfeeds.feedAllCows') }}" method="POST" class="d-flex align-items-center gap-2">
        @csrf
        <label for="feed_id" class="mb-0">اختر نوع العلف لإطعام جميع الأبقار اليوم:</label>
        <select name="feed_id" id="feed_id" class="form-select w-auto" required>
          @foreach($feeds as $feed)
            <option value="{{ $feed->id }}">{{ $feed->name }} - السعر: {{ number_format($feed->price) }} ليرة</option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-success">إطعام جميع الأبقار</button>
      </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>البقرة</th>
                <th>نوع العلف</th>
                <th>التاريخ</th>
                <th>كمية الصباح</th>
                <th>كمية المساء</th>
                <th>سعر الوحدة</th>
                <th>السعر الإجمالي</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cowFeeds as $feed)
            <tr>
                <td>{{ $feed->cow->name }}</td>
                <td>{{ $feed->feed->name }}</td>
                <td>{{ \Carbon\Carbon::parse($feed->date)->format('Y-m-d') }}</td>
                <td>{{ $feed->morning_quantity }}</td>
                <td>{{ $feed->evening_quantity }}</td>
                <td>{{ number_format($feed->price) }}</td>
                <td>{{ number_format($feed->total_price) }}</td>
                <td>
                    <a href="{{ route('cowfeeds.edit', $feed->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
