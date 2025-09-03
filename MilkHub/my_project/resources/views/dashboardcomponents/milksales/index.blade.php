@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
    {{-- العنوان وزر الإضافة --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h2 class="mb-0">📟 قائمة مبيعات الحليب</h2>
        <a href="{{ route('milksales.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-1"></i> إضافة بيع جديد
        </a>
        <a href="{{ route('milksales.report') }}" class="btn btn-warning mb-3">📊 عرض تقارير البيع</a>
    </div>

    {{-- رسالة النجاح --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    @endif

    {{-- جدول المبيعات --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>نوع البيع</th>
                    <th>العميل</th>
                    <th>الكمية (كيلو)</th>
                    <th>السعر (ليرة)</th>
                    <th>الإجمالي (ليرة)</th>
                    <th>تاريخ البيع</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $sale->sale_type }}</span>
                        </td>
                        <td>{{ $sale->customer ? $sale->customer->name : 'أهالي' }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ number_format($sale->price) }}</td>
                        <td class="fw-bold text-success">{{ number_format($sale->total) }}</td>
                        <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('milksales.edit', $sale->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                            <form action="{{ route('milksales.destroy', $sale->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">لا توجد بيانات مبيعات حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- روابط الصفحات --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $sales->links() }}
    </div>
</div>
@endsection
