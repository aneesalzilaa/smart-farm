@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">قائمة الأبقار</h5>
                <a href="{{ route('cows.create') }}" class="btn btn-primary">إضافة بقرة جديدة</a>
            </div>

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
              <table class="table text-nowrap align-middle mb-0">
                <thead>
                  <tr class="border-2 border-bottom border-primary border-0">
                    <th scope="col" class="ps-0">رقم البقرة</th>
                    <th scope="col">الاسم</th>
                    <th scope="col">كمية الإطعام الصباحية</th>
                    <th scope="col">كمية الإطعام المسائية</th>
                    <th scope="col">تاريخ الإضافة</th>
                    <th scope="col" class="text-center">الإجراءات</th>
                  </tr>
                </thead>
                <tbody class="table-group-divider">
                  @forelse ($cows as $cow)
                    <tr>
                      <th scope="row" class="ps-0 fw-medium">{{ $cow->id }}</th>
                      <td>{{ $cow->name }}</td>
                      <td>{{ number_format($cow->morning_quantity, 2) }}</td>
                      <td>{{ number_format($cow->evening_quantity, 2) }}</td>
                      <td>{{ $cow->created_at->format('Y-m-d') }}</td>
                      <td class="text-center">
                        <a href="{{ route('cows.edit', $cow->id) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('cows.destroy', $cow->id) }}" method="POST" style="display:inline-block;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه البقرة؟')">حذف</button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center">لا توجد أبقار مسجلة حتى الآن</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
</div>
@endsection
