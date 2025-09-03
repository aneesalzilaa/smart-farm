@extends('dashboardlayout.dashboardlayout')

@section('contact')

<style>
  body, .container {
    font-family: 'Cairo', sans-serif;
    background: #f9fafb;
    color: #4a5a6a; /* رمادي هادئ */
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem 1rem;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
  }

  h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    letter-spacing: 0.04em;
    color: #3b4754; /* لون داكن لكن ناعم */
  }

  /* البطاقات العلوية مع إطارات */
  .stat-card {
    background: #fcfdfe;
    border: 1.8px solid rgba(74, 144, 226, 0.22); /* إطار أزرق شفاف */
    border-radius: 16px;
    padding: 1.6rem 1.2rem;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: #2d3e50;
    box-shadow: 0 2px 10px rgba(74, 144, 226, 0.07);
  }

  .stat-card:not(:last-child) {
    margin-bottom: 1.2rem; /* مسافة بين البطاقات */
  }

  .stat-card:hover {
    box-shadow: 0 8px 24px rgba(74, 144, 226, 0.2);
    transform: translateY(-4px);
  }

  .stat-card .value {
    font-size: 2.4rem;
    font-weight: 900;
    margin-top: 0.5rem;
    color: #5599e6; /* أزرق فاتح */
    letter-spacing: 0.03em;
  }

  .stat-card .label {
    font-size: 1rem;
    color: #7a8a99;
    text-transform: uppercase;
    letter-spacing: 0.1em;
  }

  /* العنوان الرئيسي */
  .report-title {
    font-size: 2.8rem;
    text-align: center;
    margin-bottom: 0.4rem;
    color: #2e3c4f;
    font-weight: 900;
    text-transform: uppercase;
  }

  .report-subtitle {
    font-size: 1.25rem;
    font-weight: 600;
    text-align: center;
    color: #738292;
    margin-bottom: 2.8rem;
  }

  /* بطاقة المتبقي */
  .remaining-card {
    background: #e7f1fc;
    border: 1.8px solid rgba(74, 144, 226, 0.25);
    border-radius: 24px;
    padding: 2.8rem 0;
    color: #2a3e52;
    text-align: center;
    box-shadow: 0 6px 22px rgba(74, 144, 226, 0.15);
    margin: 3rem 0 3.5rem;
  }

  .remaining-card h3 {
    font-size: 1.9rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    letter-spacing: 0.06em;
  }

  .remaining-card p {
    font-size: 3rem;
    font-weight: 900;
    margin: 0;
    letter-spacing: 0.04em;
  }

  /* الجداول */
  table {
    border-collapse: separate !important;
    border-spacing: 0 12px !important;
    width: 100%;
    font-weight: 600;
    color: #4c5d6e;
  }

  thead tr th {
    background: #e9f0f7;
    color: #5b6a7a;
    padding: 16px 18px;
    font-size: 1.1rem;
    border-radius: 14px 14px 0 0;
    text-align: right;
    letter-spacing: 0.04em;
  }

  tbody tr {
    background: #fcfdfe;
    border-radius: 18px;
    box-shadow: 0 4px 14px rgba(74, 144, 226, 0.08);
    transition: box-shadow 0.3s ease;
  }

  tbody tr:hover {
    box-shadow: 0 8px 26px rgba(74, 144, 226, 0.18);
  }

  tbody tr td {
    padding: 14px 18px;
    vertical-align: middle;
    border: none !important;
    text-align: right;
    font-size: 1.05rem;
  }

  /* قسم العناوين الفرعية */
  section h2 {
    font-size: 1.9rem;
    font-weight: 800;
    color: #2e3c4f;
    margin-bottom: 1.6rem;
    border-bottom: 3px solid #5599e6;
    padding-bottom: 0.35rem;
    letter-spacing: 0.07em;
  }

  /* الملخص المالي */
  .financial-summary {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2.8rem;
  }

  .finance-card {
    flex: 1 1 280px;
    background: #f8fbfe;
    border: 1.8px solid rgba(74, 144, 226, 0.18);
    border-radius: 18px;
    padding: 1.8rem 1.4rem;
    text-align: center;
    box-shadow: 0 6px 20px rgba(79, 115, 144, 0.10);
    transition: background 0.3s ease;
    color: #3a5068;
  }

  .finance-card.revenue {
    color: #2e7d32; /* أخضر هادئ */
  }

  .finance-card.cost {
    color: #b23a3a; /* أحمر هادئ */
  }

  .finance-card.profit {
    color: #3174b8; /* أزرق متوسط */
  }

  .finance-card h6 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    letter-spacing: 0.06em;
    font-weight: 700;
  }

  .finance-card p {
    font-size: 2.3rem;
    font-weight: 900;
    margin: 0;
    letter-spacing: 0.04em;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .stat-card .value {
      font-size: 2rem;
    }

    .report-title {
      font-size: 2.4rem;
    }

    section h2 {
      font-size: 1.5rem;
    }
  }

  @media (max-width: 576px) {
    .financial-summary {
      flex-direction: column;
      gap: 16px;
    }
    .container {
      padding-left: 1rem;
      padding-right: 1rem;
    }
  }
</style>

 <div class="container-fluid">
<div class="container py-5">

  <h1 class="report-title">
    تقرير المزرعة اليومي
  </h1>
  <p class="report-subtitle mb-5">
    من {{ $start_date }} إلى {{ $end_date }}
  </p>

  <div class="row g-4">
    <div class="col-12 col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="label">
          <!-- أيقونة صندوق أو مخزون لفائض الأمس -->
          <svg xmlns="http://www.w3.org/2000/svg" style="width:18px; height:18px; vertical-align: middle; margin-left:6px;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 4v16h18V4H3zm16 14H5V6h14v12z"/>
            <path d="M7 10h10v2H7z"/>
          </svg>
          فائض من الأمس
        </div>
        <div class="value">{{ $surplusYesterdayQuantity }} كيلو</div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="label">
          <!-- أيقونة بقرة للإنتاج -->
          <svg xmlns="http://www.w3.org/2000/svg" style="width:18px; height:18px; vertical-align: middle; margin-left:6px;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M18 8a3 3 0 1 0-3-3 3 3 0 0 0 3 3zm-8 7c-1.5 0-4 1.5-4 3v2h12v-2c0-1.5-2.5-3-4-3zM6 6c0-1.1 1-3 3-3s3 1.9 3 3v2H6z"/>
          </svg>
          إنتاج الأبقار
        </div>
        <div class="value">{{ $totalProduction }} كيلو</div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="label">
          <!-- أيقونة شاحنة توريد -->
          <svg xmlns="http://www.w3.org/2000/svg" style="width:18px; height:18px; vertical-align: middle; margin-left:6px;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M3 13h2v-2H3v2zm3-2h3v2H6v-2zm8 0h3v2h-3v-2zM3 9h18v2H3V9zm0 6h18v2H3v-2z"/>
          </svg>
          توريدات الموردين
        </div>
        <div class="value">{{ $totalSupplierMilk }} كيلو</div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3">
      <div class="stat-card">
        <div class="label">
          <!-- أيقونة عربة بيع أو سلة -->
          <svg xmlns="http://www.w3.org/2000/svg" style="width:18px; height:18px; vertical-align: middle; margin-left:6px;" fill="currentColor" viewBox="0 0 24 24">
            <path d="M7 18c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm10 0c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm-12.138-2.59l1.12-6.7H19v-2H7.3l-1-6H3v2h2l3.6 7.59-1.35 2.45c-.16.29-.25.62-.25.96 0 1.104.896 2 2 2h12v-2H7.862z"/>
          </svg>
          المبيعات
        </div>
        <div class="value">{{ $soldMilk }} كيلو</div>
      </div>
    </div>
  </div>

  <div class="remaining-card">
    <h3>المتبقي الكلي</h3>
    <p>{{ $remainingMilk }} كيلو</p>
  </div>

</div>

  <h2>
    <svg xmlns="http://www.w3.org/2000/svg" style="width:20px; height:20px; vertical-align: middle; margin-left: 8px;" fill="currentColor" viewBox="0 0 24 24">
      <path d="M18 8a3 3 0 1 0-3-3 3 3 0 0 0 3 3zm-8 7c-1.5 0-4 1.5-4 3v2h12v-2c0-1.5-2.5-3-4-3zM6 6c0-1.1 1-3 3-3s3 1.9 3 3v2H6z"/>
    </svg>
    إنتاج الأبقار
  </h2>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>البقرة</th>
          <th>التاريخ</th>
          <th>الصباح</th>
          <th>المساء</th>
        </tr>
      </thead>
      <tbody>
        @forelse($productions as $prod)
          <tr>
            <td>{{ $prod->cow->name ?? '-' }}</td>
            <td>{{ $prod->date }}</td>
            <td>{{ $prod->morning_amount }} كيلو</td>
            <td>{{ $prod->evening_amount }} كيلو</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center text-muted fst-italic">لا يوجد بيانات</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>


  {{-- جدول توريدات الموردين --}}
<section>
  <h2>
    <svg xmlns="http://www.w3.org/2000/svg" style="width:20px; height:20px; vertical-align: middle; margin-left: 8px;" fill="currentColor" viewBox="0 0 24 24">
      <path d="M3 13h2l3.6 7H19v-2H9.42l-1.35-2.44L16 10V4H3v9zm16-6h-3V4h-2v3H8v2h8v4l3-3v-2zM7 18c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"/>
    </svg>
    توريدات الموردين
  </h2>
  <p>إجمالي كمية الحليب التي تم توريدها من الموردين خلال الفترة: <strong>{{ $totalSupplierMilk }} كغ</strong></p>

  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>المورد</th>
          <th>التاريخ</th>
          <th>الصباحية (كغ)</th>
          <th>المسائية (كغ)</th>
          <th>الإجمالي (كغ)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($supplierDeliveries as $delivery)
          <tr>
            <td>{{ $delivery->milkSupplier->name ?? '-' }}</td>
            <td>{{ $delivery->date }}</td>
            <td>{{ $delivery->morning_quantity ?? 0 }}</td>
            <td>{{ $delivery->evening_quantity ?? 0 }}</td>
            <td>{{ ($delivery->morning_quantity ?? 0) + ($delivery->evening_quantity ?? 0) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted fst-italic">لا يوجد بيانات</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>

  <h2>
    <svg xmlns="http://www.w3.org/2000/svg" style="width:20px; height:20px; vertical-align: middle; margin-left: 8px;" fill="currentColor" viewBox="0 0 24 24">
      <path d="M7 18c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm10 0c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm-12.83-3.1L5.54 5H19V3H5.25l-1.4-3H1v2h2l3.6 7.59-1.35 2.44C5.16 15.37 5 15.68 5 16a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.3z"/>
    </svg>
    المبيعات
  </h2>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>التاريخ</th>
          <th>الكمية</th>
          <th>الإجمالي</th>
          <th>صاحب المعمل / الأهالي</th>
        </tr>
      </thead>
      <tbody>
        @forelse($milkSales as $sale)
          <tr>
            <td>{{ $sale->created_at->format('Y-m-d') }}</td>
            <td>{{ $sale->quantity }} كيلو</td>
            <td>{{ number_format($sale->total) }} ل.س</td>
            <td>
              @if($sale->sale_type === 'معامل')
                {{ $sale->customer ? $sale->customer->name : 'غير معروف' }}
              @else
                أهالي
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center text-muted fst-italic">لا يوجد بيانات</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</section>



<section class="financial-summary">
  <div class="finance-card revenue">
    <h6>
      إجمالي الإيرادات
      <svg xmlns="http://www.w3.org/2000/svg" style="width:16px; height:16px; vertical-align: middle; margin-left:4px;" fill="green" viewBox="0 0 24 24">
        <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2zm1 15h-2v-6h2zm0-8h-2V7h2z"/>
      </svg>
    </h6>
    <p>{{ number_format($totalRevenue) }} ل.س</p>
  </div>

  <div class="finance-card cost">
    <h6>
      تكلفة الإطعام
      <svg xmlns="http://www.w3.org/2000/svg" style="width:16px; height:16px; vertical-align: middle; margin-left:4px;" fill="orange" viewBox="0 0 24 24">
        <path d="M12 2C7.589 2 4 5.589 4 10a8 8 0 0 0 16 0c0-4.411-3.589-8-8-8zm0 13a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
      </svg>
    </h6>
    <p>{{ number_format($totalFeedCost) }} ل.س</p>
  </div>

  <div class="finance-card profit">
    <h6>
      صافي الربح
      <svg xmlns="http://www.w3.org/2000/svg" style="width:16px; height:16px; vertical-align: middle; margin-left:4px;" fill="blue" viewBox="0 0 24 24">
        <path d="M5 12l5 5L20 7" stroke="blue" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </h6>
    <p>{{ number_format($profit) }} ل.س</p>
  </div>
</section>

@endsection
