@extends('dashboardlayout.dashboardlayout')
@section('contact')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">إضافة علف جديد</h5>
          <form action="{{ route('feeds.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">اسم العلف</label>
              <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">سعر العلف (بالريال)</label>
              <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required>
              @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-success">حفظ</button>
            <a href="{{ route('feeds.index') }}" class="btn btn-secondary">إلغاء</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
