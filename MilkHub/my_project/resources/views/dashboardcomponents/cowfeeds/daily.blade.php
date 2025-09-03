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
        <h2>الإطعام اليومي للأبقار</h2>
        <a href="{{ route('cowfeeds.index') }}" class="btn btn-secondary">العودة إلى قائمة الإطعام</a>
    </div>

    <div class="mt-4 mb-4">
        <form method="GET" action="{{ route('cowfeeds.daily') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="from_date" class="form-label">من تاريخ</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request()->get('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label">إلى تاريخ</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request()->get('to_date') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">بحث</button>
                </div>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-5">
        <thead>
            <tr>
                <th>البقرة</th>
                <th>نوع العلف</th>
                <th>التاريخ</th>
                <th>كمية الصباح</th>
                <th>كمية المساء</th>
                <th>سعر الوحدة</th>
                <th>السعر الإجمالي</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPrice = 0;
            @endphp

            @forelse($cowFeeds as $feed)
            <tr>
                <td>{{ $feed->cow->name }}</td>
                <td>{{ $feed->feed->name }}</td>
                <td>{{ \Carbon\Carbon::parse($feed->date)->format('Y-m-d') }}</td>
                <td>{{ $feed->morning_quantity }}</td>
                <td>{{ $feed->evening_quantity }}</td>
                <td>{{ number_format($feed->price) }}</td>
                <td>{{ number_format($feed->total_price) }}</td>
            </tr>
            @php
                $totalPrice += $feed->total_price;
            @endphp
            @empty
            <tr>
                <td colspan="7" class="text-center">لا توجد بيانات للإطعام اليومي</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($totalPrice > 0)
    <div class="mt-3">
        <h4>المجموع الكلي للأسعار: {{ number_format($totalPrice) }} </h4>
    </div>
    @endif
</div>

@endsection
