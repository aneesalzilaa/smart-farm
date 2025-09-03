@extends('dashboardlayout.dashboardlayout')

@section('contact')
<style>
    /* تحسين الخطوط والألوان */
    body, .container-fluid {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    h2 {
        font-weight: 700;
        color: #0d6efd;
        text-align: center;
        margin-bottom: 2rem;
    }

    form.row.g-3.mb-4 {
        justify-content: center;
        gap: 1rem;
    }

    form input[type="date"] {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    form input[type="date"]:focus {
        border-color: #0d6efd;
        outline: none;
        box-shadow: 0 0 6px rgba(13, 110, 253, 0.5);
    }

    form button.btn-primary {
        padding: 0.5rem 1.5rem;
        font-size: 1rem;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    form button.btn-primary:hover {
        background-color: #084298;
    }

    /* بطاقات الإحصائيات */
    .stats-card {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 1.25rem;
        text-align: center;
        transition: transform 0.3s ease;
        background: #fff;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stats-card strong {
        display: block;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #0d6efd;
    }

    .stats-card p {
        font-size: 1.1rem;
        margin: 0;
    }

    /* بطاقات المبيعات حسب النوع */
    .type-card {
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(13, 110, 253, 0.15);
        background: #e7f1ff;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.3s ease;
    }
    .type-card:hover {
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
    }

    .type-card .card-header {
        font-weight: 700;
        font-size: 1.25rem;
        background: transparent !important;
        color: #0d6efd !important;
        border-bottom: none !important;
        padding: 0;
        margin-bottom: 1rem;
    }

    /* الجدول */
    table.table {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        font-size: 1rem;
    }
    table.table thead {
        background-color: #0d6efd;
        color: white;
    }
    table.table thead th {
        border: none;
    }
    table.table tbody tr:hover {
        background-color: #f1f9ff;
    }

    /* الرسم البياني */
    #salesChart {
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 1rem;
        max-width: 100%;
    }

    /* تنسيق عام */
    .container {
        max-width: 1100px;
        margin: 0 auto;
    }
</style>
<div class="container-fluid">
<div class="container-fluid py-5">
    <div class="container">
        <h2>📊 تقارير مبيعات الحليب</h2>

        <!-- نموذج الفكيلوة -->
<form action="{{ route('milksales.report') }}" method="GET" class="row g-3 mb-5 justify-content-center align-items-center">
    <div class="col-auto">
        <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" aria-label="تاريخ البداية">
    </div>
    <div class="col-auto">
        <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" aria-label="تاريخ النهاية">
    </div>
<div class="col-auto">
    <select name="customer_name" class="form-control" aria-label="اسم المعمل">
        <option value="">-- اختر المعمل --</option>
        @foreach($customers as $customer)
            <option value="{{ $customer->name }}" @if(($customerName ?? '') == $customer->name) selected @endif>
                {{ $customer->name }}
            </option>
        @endforeach
    </select>
</div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">تصفية</button>
    </div>
</form>
        <!-- الإحصائيات الرئيسية -->
        <div class="row mb-5 text-center">
            <div class="col-md-6 col-lg-6">
                <div class="stats-card">
                    <strong>🔢 إجمالي الكمية</strong>
                    <p>{{ $totalQuantity }} كيلو</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="stats-card">
                    <strong>💰 إجمالي الإيرادات</strong>
                    <p>{{ number_format($totalRevenue) }} ل.س</p>
                </div>
            </div>
        </div>

        <!-- مبيعات حسب النوع -->
        <div class="row mb-5">
            @foreach($byType as $type => $data)
                <div class="col-md-6">
                    <div class="type-card">
                        <div class="card-header">مبيعات {{ $type }}</div>
                        <div class="card-body p-0">
                            <p>الكمية: <strong>{{ $data['quantity'] }} كيلو</strong></p>
                            <p>الإيرادات: <strong>{{ number_format($data['revenue']) }} ل.س</strong></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- جدول العمليات -->
     <h4 class="mb-4">📋 جدول العمليات</h4>
<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>النوع</th>
                <th>الكمية (كيلو)</th>
                <th>السعر (ل.س)</th>
                <th>الإجمالي (ل.س)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                    <td>
                        {{ $sale->sale_type }}
                        @if($sale->sale_type === 'معامل' && $sale->customer)
                            - {{ $sale->customer->name }}
                        @endif
                    </td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->price) }}</td>
                    <td>{{ number_format($sale->quantity * $sale->price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


        <!-- الرسم البياني -->
        <h4 class="mt-5 mb-4 text-center">📈 رسم بياني للمبيعات حسب النوع</h4>
        <canvas id="salesChart" height="150"></canvas>
    </div>
</div>
  </div>
<!-- مكتبة Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($byType);

    const labels = Object.keys(salesData);
    const quantities = labels.map(type => salesData[type].quantity);
    const revenues = labels.map(type => salesData[type].revenue);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'الكمية (كيلو)',
                    data: quantities,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderRadius: 5,
                    barPercentage: 0.6
                },
                {
                    label: 'الإيرادات (ل.س)',
                    data: revenues,
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    borderRadius: 5,
                    barPercentage: 0.6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
