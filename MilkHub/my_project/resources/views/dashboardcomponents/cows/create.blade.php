@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6 mx-auto">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4">إضافة بقرة جديدة</h5>

          {{-- عرض رسائل الخطأ --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('cows.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">اسم البقرة</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
              <label for="morning_quantity" class="form-label">كمية الإطعام الصباحية</label>
              <input type="number" step="0.01" min="0" class="form-control" id="morning_quantity" name="morning_quantity" value="{{ old('morning_quantity', 0) }}" required>
            </div>

            <div class="mb-3">
              <label for="evening_quantity" class="form-label">كمية الإطعام المسائية</label>
              <input type="number" step="0.01" min="0" class="form-control" id="evening_quantity" name="evening_quantity" value="{{ old('evening_quantity', 0) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">حفظ</button>
            <a href="{{ route('cows.index') }}" class="btn btn-secondary">إلغاء</a>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
