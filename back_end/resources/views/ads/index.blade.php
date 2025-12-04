<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<style>
table.dataTable thead th,
table.dataTable thead td,
table.dataTable tfoot th,
table.dataTable tfoot td {
    text-align: justify !important;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <h4 class="font-15 "> الحملات الاعلانية </h4>

                <div class="add-new-contact ml-20" style="float: left;">
                    <button class="btn btn-success dropdown-toggle" type="button" id="actionsDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="background-color: #707072c4; border-color: #28a745; color: #fff;">
                        خيارات
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionsDropdown">
                        <a class="dropdown-item" href="{{ route('excel.files') }}">
                            <i class="fas fa-file-excel text-primary"></i> ملفات الاكسيل
                        </a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#projectAddModal">
                            <i class="fas fa-plus text-success"></i> حملة جديدة
                        </a>
                        <a class="dropdown-item" href="{{ route('excel.export',['id' => 'all']) }}">
                            <i class="fas fa-file-export text-info"></i> تصدير الكل
                        </a>
                    </div>
                </div>
                <br /><br />
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form action="{{ route('ads_.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
                                        style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                        <h4 class="mb-0"
                                            style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                            إضف جديد</h4>
                                        <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close"
                                            style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="name" class="mb-2 black bold">اسم الحملة <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="theme-input-style" id="name" name="name"
                                                    placeholder="أدخل اسم الحملة">
                                            </div>
                                        </div>
                                        <input type="hidden" name="company_id" value="{{  request()->get('comp_id') }}">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="start_date" class="mb-2 black bold">تاريخ البدء <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="theme-input-style" id="start_date"
                                                    name="start_date">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="end_date" class="mb-2 black bold">تاريخ النهاية <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="theme-input-style" id="end_date"
                                                    name="end_date">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="amount_per_day" class="mb-2 black bold">قيمة الاعلان لليوم
                                                    <span class="text-danger">*</span></label>
                                                <input type="number" class="theme-input-style" id="amount_per_day"
                                                    name="amount_per_day">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="number_days" class="mb-2 black bold">عدد الايام</label>
                                                <input type="text" class="theme-input-style" id="number_days"
                                                    name="number_days" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="total_amount" class="mb-2 black bold" >اجمالى القيمة</label>
                                                <input type="number" class="theme-input-style" id="total_amount"
                                                    name="total_amount" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="number_days" class="mb-2 black bold">هاتف الحملة </label>
                                                <input type="number" class="theme-input-style" name="phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="ad_image" class="mb-2 black bold"> رفع صورة او فيديو او
                                                    PDF</label>
                                                <input type="file" class="theme-input-style" id="ad_image" name="image"
                                                    accept="image/*,video/*,application/pdf">
                                            </div>
                                        </div>
                                                       <div class="col-lg-6" id="branches">
                                            <div class="form-group mb-4">
       @php
    $catId = request()->get('cat_id');

    if ($catId) {
        $cats = App\Models\Category::where('id', $catId)->get();
    } else {
        $companyCats = App\Models\Category::where('company_id', request()->get('comp_id'))->get();

        if ($companyCats->count() === 1) {
            $cats = $companyCats;   
        } else {
            $cats = $companyCats;   
        }
    }
@endphp
   @if($catId)
    <input type="hidden" name="cats_ids[]" value="{{ $catId }}">
@elseif($cats->count() > 1)
    <label for="cats_ids" class="mb-2 black bold">الفروع <span class="text-danger">*</span></label>
    <select class="theme-input-style" id="cats_ids" name="cats_ids[]" multiple style="min-height:120px; height:160px;">
        <option value="all">الكل</option>
        @foreach ($cats as $comp)
            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
        @endforeach
    </select>
@endif

                                            </div>
                                        </div>
                                        <div class="col-lg-6" id="products" style="display:none">
                                            <div class="form-group mb-4">
                                                <label for="product_ids" class="mb-2 black bold">المنتجات</label>
                                                <select class="theme-input-style" id="product_ids" name="product_ids[]"
                                                    multiple style="min-height:120px; height:150px;">
                                                </select>
                                            </div>
                                        </div>
                                      @php
    $branchesCount = $cats->count();
@endphp

<div class="{{ $branchesCount === 1 ? 'col-lg-12' : 'col-lg-6' }}">
    <div class="form-group mb-4">
        <label for="note" class="mb-2 black bold">ملاحظة</label>
        <textarea class="theme-input-style" id="note" name="note" rows="3"></textarea>
    </div>
</div>

                                    </div>

                                    <div class="d-flex justify-content-center pt-3" style="    padding-bottom: 10px;">
                                        <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                                        <button type="reset" class="btn btn-secondary"
                                            data-dismiss="modal">إلغاء</button>
                                    </div>
                                </form>
                            </div>
                            <!-- End Modal Body -->
                        </div>
                    </div>
                </div>
                <br /><br />
                <div class="table-responsive">
                    <!-- Invoice List Table -->
                    <table class="text-nowrap bg-white dh-table" id="all_ads-table">
                        <thead>
                            <tr> 
                                 <th>م</th>
                                <th>اسم الحملة</th>
                                <th> تاريخ الاعلان</th>
                                <th>الحالة</th>
                                <th>عدد زيارات اليوم</th>
                                <th>صورة او فيديو</th>
                                <th>الفروع </th>
                                <th>اللينك </th>
                                <th>QR كود</th>
                                <th>احصائيات  </th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>

                    </table>
                    <!-- End Invoice List Table -->
                </div>
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    const compId = @json(request()->get('comp_id'));
    const catId = @json(request()->get('cat_id'));

    // if (compId) {
    //     checkData(compId);
    // }
    console.log(compId);
    var table = $('#all_ads-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('allAds.data') }}",
            data: function(d) {
                d.comp_id = compId; // pass it to the server
                d.cat_id = catId; // pass it to the server
            }
        },
        columns: [{
                data: 'DT_RowIndex', // This field comes from addIndexColumn
                name: 'DT_RowIndex',
                orderable: false, // Optional: Prevent sorting
                searchable: false // Optional: Prevent searching
            },
            
            {
                data: 'name',
                name: 'name',
                searchable: true
            },
            {
                data: 'ads_date',
                name: 'ads_date'
            },
                { data: 'status', name: 'status' }, 
            {
                data: 'visits_count',
                name: 'visits_count'

            },
            {
                data: 'img',
                name: 'img'
            },
            {
                data: 'cat',
                name: 'cat'
            },

            {
                data: 'link',
                name: 'link'
            },
             {
                data: 'qr_code',
                name: 'qr_code',
                orderable: false,
                searchable: false
            },
            
            {
                data: 'statistics',
                name: 'statistics'
            },
            {
                data: 'actions',
                name: 'actions'
            }
        ],
        language: {
            url: "{{ asset('assets/js/datatables/ar.json') }}", // Arabic translations
        }
    });
});
</script>
<script>
const startInput = document.getElementById('start_date');
const endInput = document.getElementById('end_date');
const output = document.getElementById('number_days');
const total_amount = document.getElementById('total_amount');
const amount_per_day = document.getElementById('amount_per_day');

function calculateDateDiff() {
    const start = new Date(startInput.value);
    const end = new Date(endInput.value);
    const perDayAmount = parseFloat(amount_per_day.value);

    if (!isNaN(start) && !isNaN(end)) {
        const diffTime = end - start;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
        output.value = diffDays;
        total_amount.value = (diffDays * perDayAmount);
        // amountPerDay.value = parseFloat(amountPerDay.value).toFixed(3);
        console.log(total_amount.value);
    } else {
        output.value = '';
    }
}

startInput.addEventListener('change', calculateDateDiff);
endInput.addEventListener('change', calculateDateDiff);
amount_per_day.addEventListener('change', calculateDateDiff);
</script>

<!-- <script>
function checkData(comp_id) {
    $.ajax({
        type: 'get',
        dataType: "json",
        url: "{{ route('checkData', ':id') }}".replace(':id', comp_id),

        success: function(res) {
            if (res.cats  && Array.isArray(res.cats) && res.cats.length > 0) {
                console.log(res.cats);
                let select = $('#cats_ids');
                // $('#branches').show();
                select.empty();
                select.append('<option value="all">الكل</option>');
                $.each(res.cats, function(index, cat) {

                    select.append('<option value="' + cat.id + '">' + cat.name + '</option>');
                });

            }
            // if ((res.cats.length == 0) && res.prods && Array.isArray(res.prods) && res.prods.length > 0) {

            //     let select = $('#product_ids');
            //     $('#products').show();
            //     select.empty();
            //     select.append('<option value="all">الكل</option>');
            //     $.each(res.prods, function(index, prod) {
            //         select.append('<option value="' + prod.id + '">' + prod.name + '</option>');
            //     });
            // } 
            // else {
            //     $('#products').hide();
            //     $('#branches').hide();
            // }
        },
        error: function(res) {

        }
    });
}

function editData(comp_id) {
    if (!comp_id) {
        $('#branches_2').hide();
        return;
    }

    $.ajax({
        type: 'get',
        dataType: "json",
        url: "{{ route('checkData', ':id') }}".replace(':id', comp_id),

        success: function(res) {
            console.log(res);
            if (res.cats && Array.isArray(res.cats) && res.cats.length > 0) {
                console.log('incats');
                let select = $('#cats_ids_2');

                select.empty();
                select.append('<option value="all">الكل</option>');
                $.each(res.cats, function(index, cat) {
                    select.append('<option value="' + cat.id + '"' + (cat.isSelected ? ' selected' :
                        '') + '>' + cat.name + '</option>');
                });
                $('#branches_2').show();
            }
            if (res.prods && Array.isArray(res.prods) && res.prods.length > 0) {
                console.log('inprod');

                let select = $('#product_ids_2');

                select.empty();
                select.append('<option value="all">الكل</option>');
                $.each(res.prods, function(index, prod) {
                    select.append('<option value="' + prod.id + '">' + prod.name + '</option>');
                });
            }
            //  else {
            //     console.log('else case');
            //     $('#branches_2').hide();
            // }
        },
        error: function(res) {

        }
    });
}
</script> -->