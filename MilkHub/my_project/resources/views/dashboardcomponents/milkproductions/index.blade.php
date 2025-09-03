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
    <div class="header-row">
        <h2>قائمة إنتاج الحليب</h2>
        <a href="{{ route('milkproductions.create') }}" class="btn btn-success">إضافة إنتاج جديد</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>البقرة</th>
                <th>التاريخ</th>
                <th>كمية الصباح (كيلو)</th>
                <th>كمية المساء (كيلو)</th>
                <th>السعر</th>
                <th>المجموع</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($milkProductions as $production)
            <tr>
                <td>{{ $production->cow->name }}</td>
                <td>{{ $production->date->format('Y-m-d') }}</td>
                <td>{{ $production->morning_amount }}</td>
                <td>{{ $production->evening_amount }}</td>
                <td>{{ number_format($production->price) }} ليرة</td>
                <td>{{ number_format($production->total) }} ليرة </td>
                <td>
                    <a href="{{ route('milkproductions.edit', $production->id) }}" class="btn btn-primary btn-sm">تعديل</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
