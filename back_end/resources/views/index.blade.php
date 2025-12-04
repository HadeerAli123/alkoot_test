<div class="row">
    @php
    $proj_count = \App\Models\Company::count();
    $cats_count = \App\Models\Category::count();
    $prods_count = \App\Models\Product::count();
    $ads_count = \App\Models\Ads::count();
    $ads_count = \App\Models\Ads::count();
    $ads = \App\Models\Ads::orderBy('id','desc')->take(6)->get();
    $visits = \App\Models\Details::where('type','visit')->where('date', Carbon\Carbon::today()->format('Y-m-d'))->sum('count');
    $clicks_count = \App\Models\Details::where('type','!=','visit')->where('date', Carbon\Carbon::today()->format('Y-m-d'))->sum('count');

    @endphp
    <!-- بطاقة عدد المشاريع -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card mb-30 p-3 text-center">
            <h5 class="mb-1">عدد المشاريع</h5>
            <h2>{{ $proj_count }}</h2>
            <p class="font-12 text-muted">إجمالي كل المشاريع</p>
        </div>
    </div>

    <!-- بطاقة عدد الفروع -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card mb-30 p-3 text-center">
            <h5 class="mb-1">عدد الفروع</h5>
            <h2>{{ $cats_count }}</h2>
            <p class="font-12 text-muted">ضمن جميع المشاريع</p>
        </div>
    </div>

    <!-- بطاقة عدد المنتجات -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card mb-30 p-3 text-center">
            <h5 class="mb-1">عدد المنتجات</h5>
            <h2> {{ $prods_count }}</h2>
            <p class="font-12 text-muted">جميع المنتجات </p>
        </div>
    </div>

    <!-- بطاقة عدد الحملات -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card mb-30 p-3 text-center">
            <h5 class="mb-1">عدد الحملات</h5>
            <h2>{{  $ads_count }}</h2>
            <p class="font-12 text-muted">نشطة ومؤرشفة</p>
        </div>
    </div>

    <!-- بطاقة الانطباعات (Impressions) -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card mb-30 p-3 text-center">
            <h5 class="mb-1">الزيارات</h5>
            <h2>{{ $visits }}</h2>
            <p class="font-12 text-muted">اليوم</p>
        </div>
    </div>

    <!-- بطاقة النقرات (Clicks) -->
    <div class="col-xl-2 col-md-4 col-sm-6">
        <div class="card mb-30 p-3 text-center">
            <h5 class="mb-1">الضغطات</h5>
            <h2>{{ $clicks_count }}</h2>
            <p class="font-12 text-muted">اليوم</p>
        </div>
    </div>
</div>

<!-- مخططات سريعة -->
<div class="row">
    <!-- مخطط تطور الانطباعات -->
    <div class="col-xl-6 col-lg-12">
        <div class="card mb-30">
            <div class="card-body">
                <h5> الزيارات</h5>
                <canvas id="impressions-chart" class="chart"></canvas>
            </div>
        </div>
    </div>

    <!-- مخطط تطور النقرات -->
    <div class="col-xl-6 col-lg-12">
        <div class="card mb-30">
            <div class="card-body">
                <h5> الضغطات</h5>
                <canvas id="clicks-chart" class="chart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const impressionsData = {
        labels: ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
        datasets: [{
            label: 'الزيارات',
            data: [200, 400, 350, 500, 700, 600, 800],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    const clicksData = {
        labels: ['الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
        datasets: [{
            label: 'الضغطات',
            data: [50, 80, 60, 120, 90, 100, 150],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    new Chart(document.getElementById('impressions-chart').getContext('2d'), {
        type: 'line',
        data: impressionsData,
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    new Chart(document.getElementById('clicks-chart').getContext('2d'), {
        type: 'line',
        data: clicksData,
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
});
</script>


<div class="row">
    <div class="col-12">
        <div class="card mb-30">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <h5>أحدث الحملات</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>المشروع</th>
                                <th>الفروع / المنتجات</th>
                                <th>الحملة</th>
                                <th>الزيارات</th>
                                <th>الضغطات</th>
                                <th>التكلفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ads as $ad)
                            <tr>
                                <td> {{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('companies.index') }}">{{ $ad->company?->name }} </a>
                                </td>
                                <td>
                                    @php
                                    $selectedProductIds = is_array($ad->cats_ids)
                                    ? $ad->cats_ids
                                    : json_decode($ad->cats_ids, true);

                                    $selectedProductIds = is_array($selectedProductIds) ?
                                    $selectedProductIds : [];

                                    $cats = \App\Models\Category::whereIn('id',
                                    $selectedProductIds)->get();
                                    @endphp

                                    @foreach ($cats as $cat)
                                       <a href="{{ route('cats.index') }}">{{ $cat->name}}, </a>
                                    @endforeach
                                    <br>
                                    @php
                                    $selectedProductIds = is_array($ad->product_ids)
                                    ? $ad->product_ids
                                    : json_decode($ad->product_ids, true);

                                    $selectedProductIds = is_array($selectedProductIds) ?
                                    $selectedProductIds : [];

                                    $products = \App\Models\Product::whereIn('id',
                                    $selectedProductIds)->get();
                                    @endphp

                                    @foreach ($products as $product)
                                      <small>{{ $product->name }}, </small>
                                    @endforeach
                                </td>
                                <td>{{ $ad->name}} </td>
                                <td>{{ $ad->details->where('type','visit')->count() }}</td>
                                <td>{{ $ad->details->where('type','!=','visit')->count() }}</td>
                                <td>{{ $ad->total_amount }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
