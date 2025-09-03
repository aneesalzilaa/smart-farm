@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid px-3 px-md-5">
    <h2 class="section-title">إنتاج الحليب</h2>

    <!-- نموذج البحث بتحديد فترة -->
    <form method="GET" action="{{ route('milkproductions.daily') }}" class="row g-3 filter-form mb-5 justify-content-center">
        <div class="col-12 col-md-4">
            <label for="start_date" class="form-label">تاريخ البداية</label>
            <input type="date" id="start_date" name="start_date"
                value="{{ request('start_date', $start_date ?? date('Y-m-d')) }}"
                class="form-control" max="{{ date('Y-m-d') }}">
        </div>

        <div class="col-12 col-md-4">
            <label for="end_date" class="form-label">تاريخ النهاية</label>
            <input type="date" id="end_date" name="end_date"
                value="{{ request('end_date', $end_date ?? date('Y-m-d')) }}"
                class="form-control" max="{{ date('Y-m-d') }}">
        </div>

        <div class="col-12 col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">🔍 بحث</button>
        </div>
    </form>

    <!-- ملخص بيانات الحليب -->
    <div class="summary-cards row g-3 mb-4 justify-content-center">
        @php
            $cards = [
                ['icon' => 'fas fa-cow', 'title' => 'إجمالي إنتاج الأبقار', 'value' => $totalProduction ?? 0, 'bg' => 'card-gradient'],
                ['icon' => 'fas fa-truck', 'title' => 'حليب الموردين', 'value' => $totalSupplierMilk ?? 0, 'bg' => 'card-gradient-2'],
                ['icon' => 'fas fa-shopping-cart', 'title' => 'الكمية المباعة', 'value' => $soldMilk ?? 0, 'bg' => 'card-gradient-3'],
                 ['icon' => 'fas fa-layer-group', 'title' => 'المفرز', 'value' => $surplusYesterdayQuantity ?? 0, 'bg' => 'card-gradient-5'],
                ['icon' => 'fas fa-box-open', 'title' => 'الكمية المتبقية', 'value' => $remainingMilk ?? 0, 'bg' => 'card-gradient-4'],

            ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-6 col-sm-4 col-md-2">
            <div class="card {{ $card['bg'] }} card-hover text-center py-3">
                <div class="card-icon"><i class="{{ $card['icon'] }}"></i></div>
                <h5 class="card-title mb-1">{{ $card['title'] }}</h5>
                <p class="card-value mb-0">{{ number_format($card['value']) }} كغ</p>
            </div>
        </div>
        @endforeach
    </div>

    @if ($productions->isEmpty() && $supplierDeliveries->isEmpty())
        <div class="empty-state text-center">
            <p>😕 لا توجد بيانات إنتاج أو تسليم في الفترة المحددة.</p>
            <p>يرجى تعديل فترة البحث للحصول على نتائج.</p>
        </div>
    @else
        <h4 class="sub-title text-center mb-4">
            عرض البيانات من <strong>{{ $start_date ?? 'بداية' }}</strong> إلى <strong>{{ $end_date ?? 'نهاية' }}</strong>
        </h4>

        {{-- جدول إنتاج الأبقار --}}
        @if ($productions->isNotEmpty())
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>🐄 اسم البقرة</th>
                            <th>صباحاً (كغ)</th>
                            <th>مساءً (كغ)</th>
                            <th>الإجمالي (كغ)</th>
                            <th>السعر (ل.س / كغ)</th>
                            <th>المجموع (ل.س)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productions as $production)
                            @php
                                $morning = $production->morning_amount ?? 0;
                                $evening = $production->evening_amount ?? 0;
                                $total_quantity = $morning + $evening;
                                $price = $production->price ?? 0;
                                $total_price = $total_quantity * $price;
                            @endphp
                            <tr>
                                <td>{{ $production->cow->name ?? 'غير معروف' }}</td>
                                <td>{{ number_format($morning) }}</td>
                                <td>{{ number_format($evening) }}</td>
                                <td>{{ number_format($total_quantity) }}</td>
                                <td>{{ number_format($price) }}</td>
                                <td>{{ number_format($total_price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-section text-center">
                لا يوجد إنتاج أبقار في الفترة المحددة.
            </div>
        @endif

<h4 class="sub-title mt-5 text-center">🚚 مجموع كمية الحليب لكل مورد</h4>

@if ($supplierQuantities->isNotEmpty())
    <div class="table-responsive">
        <table class="table modern-table">
            <thead>
                <tr>
                    <th>اسم المورد</th>
                    <th>📦 مجموع الكمية (كغ)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supplierQuantities as $supplier)
                    <tr>
                        <td>{{ $supplier->name ?? 'غير معروف' }}</td>
                        <td>{{ number_format($supplier->total_quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-section text-center mt-4">
        لا توجد تسليمات من الموردين في الفترة المحددة.
    </div>
@endif
    @endif
</div>
@endsection

@push('styles')
<style>
/* الكروت العامة */
.card-gradient, .card-gradient-2, .card-gradient-3, .card-gradient-4, .card-gradient-5 {
    color: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 15px 10px;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.card-gradient {
    background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
}
.card-gradient-2 {
    background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
}
.card-gradient-3 {
    background: linear-gradient(135deg, #d35400 0%, #e67e22 100%);
}
.card-gradient-4 {
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
}
.card-gradient-5 {
    background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
}

.card-icon {
    font-size: 36px;
    margin-bottom: 10px;
    filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.25));
}

.card-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 6px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.card-value {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 0.02em;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
}

/* العنوان الرئيسي */
.section-title {
    font-weight: 900;
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 40px;
    text-align: center;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    text-shadow: 1px 1px 2px #bdc3c7;
}

/* العناوين الفرعية */
.sub-title {
    font-weight: 700;
    color: #34495e;
    margin-bottom: 25px;
    font-size: 20px;
    text-align: center;
}

/* نموذج البحث */
.filter-form label {
    font-weight: 700;
    color: #34495e;
    font-size: 15px;
}

.filter-form input[type="date"] {
    border-radius: 8px;
    border: 1.5px solid #ccc;
    padding: 8px 12px;
    font-size: 14px;
    transition: border-color 0.3s ease;
    width: 100%;
}
.filter-form input[type="date"]:focus {
    border-color: #2980b9;
    box-shadow: 0 0 8px rgba(41, 128, 185, 0.3);
    outline: none;
}

.filter-form button {
    font-size: 16px;
    font-weight: 700;
    padding: 10px;
}

/* حالات الفراغ */
.empty-state {
    font-size: 18px;
    color: #7f8c8d;
    margin-top: 60px;
}

.empty-section {
    font-size: 16px;
    color: #95a5a6;
    padding: 30px 0;
}

/* الجداول */
.modern-table {
    border-collapse: separate !important;
    border-spacing: 0 15px !important;
    width: 100%;
    font-size: 16px;
    font-weight: 600;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
}

.modern-table thead tr {
    background-color: #34495e;
    color: #fff;
    text-transform: uppercase;
}

.modern-table tbody tr {
    background-color: #f9f9f9;
    transition: background-color 0.3s ease;
}

.modern-table tbody tr:hover {
    background-color: #d6e9f8;
}

.modern-table th, .modern-table td {
    padding: 12px 16px;
    text-align: center;
    border: none;
}

/* استجابة لجميع الأجهزة */
@media (max-width: 767px) {
    .card-value {
        font-size: 16px;
    }
    .card-title {
        font-size: 14px;
    }
    .section-title {
        font-size: 22px;
    }
    .filter-form label {
        font-size: 14px;
    }
    .filter-form button {
        font-size: 14px;
        padding: 8px;
    }
    .modern-table {
        font-size: 14px;
    }
}
</style>
@endpush
