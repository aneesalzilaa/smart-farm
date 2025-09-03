@extends('dashboardlayout.dashboardlayout')

@section('contact')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-area, #printable-area * {
            visibility: visible;
        }
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<div class="container-fluid">
    <h3 class="mb-4">📊 بحث وتقارير الموردين</h3>

    <form method="GET" action="{{ route('milk_suppliers.report') }}" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label class="form-label">المورد (اختيار من القائمة)</label>
            <select name="supplier_id" class="form-select">
                <option value="">-- اختر المورد --</option>
                @foreach($allSuppliers as $one)
                    <option value="{{ $one->id }}" {{ request('supplier_id') == $one->id ? 'selected' : '' }}>
                        {{ $one->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">من تاريخ</label>
            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
        </div>

        <div class="col-md-2">
            <label class="form-label">إلى تاريخ</label>
            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
        </div>

        <div class="col-md-3 d-flex gap-3">
            <button type="submit" class="btn btn-primary px-4 py-2">🔍 بحث</button>
            <button type="button" onclick="window.print()" class="btn btn-success px-4 py-2">🖨️ طباعة</button>
        </div>
    </form>

    <div id="printable-area" class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>اسم المورد</th>
                    <th>رقم الهاتف</th>
                    <th>إجمالي الكمية (كيلو)</th>
                    <th>إجمالي المبلغ (ل.س)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->phone ?? '-' }}</td>
                        <td>{{ $supplier->deliveries_sum_quantity ?? 0 }}</td>
                        <td>{{ number_format($supplier->deliveries_sum_total ?? 0) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-muted text-center">لا توجد نتائج</td>
                    </tr>
                @endforelse
            </tbody>
            @if($suppliers->count())
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="2" class="text-end">الإجمالي:</td>
                    <td>{{ $totalQuantity }}</td>
                    <td>{{ number_format($totalAmount) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
