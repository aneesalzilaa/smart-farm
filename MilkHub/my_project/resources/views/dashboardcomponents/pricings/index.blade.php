<!-- resources/views/dashboardcomponents/pricing/index.blade.php -->
@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <h1>قائمة الأسعار</h1>
        <a href="{{ route('pricings.create') }}" class="btn btn-primary">إضافة سعر جديد</a>
    </div>

    <table class="table mt-5">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>السعر</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pricings as $pricing)
                <tr>
                    <td>{{ $pricing->name }}</td>
                    <td>{{ number_format($pricing->price, 0) }}</td> <!-- تنسيق الرقم بدون فاصلة -->
                    <td>
                        <a href="{{ route('pricings.edit', $pricing->id) }}" class="btn btn-warning">تعديل</a> ||
                        <form action="{{ route('pricings.destroy', $pricing->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
