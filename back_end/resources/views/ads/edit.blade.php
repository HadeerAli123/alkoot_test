<div class="card">
    <div class="card-body">
        <form action="{{ route('ads_.update',$data->id)}}" method="POST" enctype="multipart/form-data" id="edit_ads">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="name" class="mb-2 black bold">اسم الحملة </label>
                        <input type="text" class="theme-input-style" id="name" name="name" value="{{ $data->name }}">
                        @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
                    </div>
                </div>
                <div class="col-lg-6">
        <div class="form-group mb-4">
            <label for="start_date" class="mb-2 black bold">تاريخ البدء</label>
            <input type="date" class="theme-input-style" id="start_date" name="start_date"
                   value="{{ old('start_date', $data->start_date) }}" min="{{ date('Y-m-d') }}">
            @error('start_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-4">
            <label for="end_date" class="mb-2 black bold">تاريخ النهاية</label>
            <input type="date" class="theme-input-style" id="end_date" name="end_date"
                   value="{{ old('end_date', $data->end_date) }}">
            @error('end_date')
                <span class="text-danger">{{ $message }}</span>
            @enderror

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="amount_per_day" class="mb-2 black bold">قيمة الاعلان لليوم
                        </label>
                        <input type="number" class="theme-input-style" id="amount_per_day" name="amount_per_day"
                            value="{{ $data->amount_per_day }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="number_days" class="mb-2 black bold">عدد الايام</label>
                        <input type="text" class="theme-input-style" id="number_days" name="number_days"
                            value="{{ $data->number_days }}" >
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="total_amount" class="mb-2 black bold">اجمالى القيمة</label>
                        <input type="number" class="theme-input-style" id="total_amount" name="total_amount"
                            value="{{ $data->total_amount }}" >
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="number_days" class="mb-2 black bold">هاتف الحملة </label>
                        <input type="number" class="theme-input-style" name="phone" value="{{ $data->phone }}">
                    </div>
                </div>
                <div class="row col-lg-6">
                    <div class="form-group col-lg-9 mb-4">
                        <label for="ad_image" class="mb-2 black bold"> رفع صورة او فيديو او
                            PDF</label>
                        <input type="file" class="theme-input-style" id="ad_image" name="image"
                            accept="image/*,video/*,application/pdf">

                    </div>
                    <div class="col-lg-3">
                        <img src="{{ new_asset($data->image)}}" class="img-fluid" style="width: 50px; height: 50px;">
                    </div>
                </div>
                <div class="col-lg-6" id="branches">
                    <div class="form-group mb-4">
                        <label for="cats_ids" class="mb-2 black bold">الفروع</label>
                        <select class="theme-input-style" id="cats_ids" name="cats_ids[]" multiple
                            style="min-height: 120px; height: 160px;">
                           @php
                            $cats = App\Models\Category::all();
                            $selectedCats = is_array($data->cats_ids) ? $data->cats_ids : json_decode($data->cats_ids, true);
                        @endphp

                        <option value="all" {{ in_array('all', $selectedCats ?? []) ? 'selected' : '' }}>الكل</option>

                        @foreach ($cats as $cat)
                            <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCats ?? []) ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6" id="products" style="display:none">
                    <div class="form-group mb-4">
                        <label for="product_ids" class="mb-2 black bold">المنتجات</label>
                        <select class="theme-input-style" id="product_ids" name="product_ids[]" multiple
                            style="min-height:120px; height:150px;">
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="note" class="mb-2 black bold">ملاحظة</label>
                        <textarea class="theme-input-style" id="note" name="note" rows="3">{{ $data->note }}</textarea>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-center pt-3" style="    padding-bottom: 10px;">
                <button type="submit" class="btn btn-primary ml-3">تعديل</button>
    <button type="button" class="btn btn-secondary" onclick="goBack()">إلغاء</button>

            </div>
        </form>
    </div>

</div>


<script>
function goBack() {
    if (confirm('هل أنت متأكد من إلغاء التعديلات؟')) {
        window.history.back();
    }
}
</script>
<script src="{{ asset('assets/js/ads-validation.js') }}"></script>
