@extends('dashboardlayout.dashboardlayout')

@section('contact')
    <div class="container-fluid">
        <h2 class="mb-4 text-center text-primary">إحصائيات إنتاج وطعام الأبقار</h2>

        {{-- نموذج اختيار البقرة وفترة البحث --}}
        <form method="GET" action="{{ route('cow.statistics') }}" class="mb-5 p-4 shadow-lg rounded bg-light">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="cow_id" class="form-label text-muted">اختر البقرة:</label>
                    <select name="cow_id" id="cow_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- اختر بقرة --</option>
                        <option value="all" {{ request('cow_id') == 'all' ? 'selected' : '' }}>-- عرض كل الأبقار --
                        </option>
                        @foreach ($cows as $cow)
                            <option value="{{ $cow->id }}" {{ request('cow_id') == $cow->id ? 'selected' : '' }}>
                                {{ $cow->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="start_date" class="form-label text-muted">من تاريخ:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                        value="{{ request('start_date') }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="end_date" class="form-label text-muted">إلى تاريخ:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                        value="{{ request('end_date') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 mt-3 py-2 shadow-sm">بحث</button>
        </form>

        @if (request('cow_id'))
            <h4 class="text-center text-info mb-4">
                {{ request('cow_id') == 'all' ? 'إحصائيات جميع الأبقار' : "إحصائيات البقرة: $cowName" }}
            </h4>

            @php $totalNetProfit = 0; @endphp


            @php $totalNetProfit = 0; @endphp

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-light">
                        <tr>
                            <th>التاريخ</th>
                            @if ($cowId == 'all')
                                <th>اسم البقرة</th>
                            @endif
                            <th>إنتاج الصباح</th>
                            <th>إنتاج المساء</th>
                            <th>الإجمالي</th>
                            <th>طعام الصباح</th>
                            <th>طعام المساء</th>
                            <th>الإجمالي</th>
                            <th>صافي الربح</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statistics as $stat)
                            @php
                                $production = $stat['production'];
                                $feed = $stat['feed'];
                                $morningProd = $production->morning_amount ?? 0;
                                $eveningProd = $production->evening_amount ?? 0;
                                $totalProd = $morningProd + $eveningProd;
                                $price = $production->price ?? 0;

                                $morningFeed = $feed->morning_quantity ?? 0;
                                $eveningFeed = $feed->evening_quantity ?? 0;
                                $totalFeed = $morningFeed + $eveningFeed;
                                $feedCost = $feed->total_price ?? 0;

                                $netProfit = $totalProd * $price - $feedCost;
                                $totalNetProfit += $netProfit;
                            @endphp

                            <tr>
                                <td>{{ $stat['date'] }}</td>
                                @if ($cowId == 'all')
                                    <td>{{ $stat['cow_name'] ?? 'غير معروف' }}</td>
                                @endif
                                <td>{{ $morningProd }}</td>
                                <td>{{ $eveningProd }}</td>
                                <td>{{ $totalProd }}</td>
                                <td>{{ $morningFeed }}</td>
                                <td>{{ $eveningFeed }}</td>
                                <td>{{ $totalFeed }}</td>
                                <td class="{{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format($netProfit) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="{{ $cowId == 'all' ? 8 : 7 }}" class="text-end">إجمالي صافي الربح:</th>
                            <th class="{{ $totalNetProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($totalNetProfit) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif

        <p class="text-center text-muted">يرجى اختيار بقرة أو عرض الكل لعرض الإحصائيات.</p>
    </div>
@endsection
