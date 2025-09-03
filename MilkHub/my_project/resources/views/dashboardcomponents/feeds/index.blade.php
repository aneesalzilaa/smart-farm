@extends('dashboardlayout.dashboardlayout')
@section('contact')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title d-flex justify-content-between align-items-center">
            قائمة الأعلاف
            <a href="{{ route('feeds.create') }}" class="btn btn-primary btn-sm">إضافة علف جديد</a>
          </h5>
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          <div class="table-responsive">
            <table class="table table-striped text-nowrap align-middle mb-0">
              <thead>
                <tr>
                  <th>رقم العلف</th>
                  <th>اسم العلف</th>
                  <th>السعر (باليرة)</th>
                  <th class="text-center">الإجراءات</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($feeds as $feed)
                <tr>
                  <td>{{ $feed->id }}</td>
                  <td>{{ $feed->name }}</td>
                  <td>{{ number_format($feed->price) }}</td>
                  <td class="text-center">
                    <a href="{{ route('feeds.edit', $feed->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                    <form action="{{ route('feeds.destroy', $feed->id) }}" method="POST" style="display:inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا العلف؟')" class="btn btn-danger btn-sm">حذف</button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center">لا توجد أعلاف مسجلة حتى الآن</td>
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
