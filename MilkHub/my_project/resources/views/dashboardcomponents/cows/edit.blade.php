@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">تعديل بيانات البقرة</h5>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('cows.update', $cow->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="mb-3">
                <label for="name" class="form-label">اسم البقرة</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $cow->name) }}" required>
              </div>

              <div class="mb-3">
                <label for="morning_quantity" class="form-label">كمية الإطعام الصباحية</label>
                <input type="number" step="0.01" min="0" name="morning_quantity" id="morning_quantity" class="form-control" value="{{ old('morning_quantity', $cow->morning_quantity) }}" required>
              </div>

              <div class="mb-3">
                <label for="evening_quantity" class="form-label">كمية الإطعام المسائية</label>
                <input type="number" step="0.01" min="0" name="evening_quantity" id="evening_quantity" class="form-control" value="{{ old('evening_quantity', $cow->evening_quantity) }}" required>
              </div>

              <button type="submit" class="btn btn-primary">تحديث</button>
              <a href="{{ route('cows.index') }}" class="btn btn-secondary">إلغاء</a>
            </form>

          </div>
        </div>
      </div>
    </div>
</div>
@endsection
