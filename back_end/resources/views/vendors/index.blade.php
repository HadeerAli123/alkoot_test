<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<div class="row">
    <div class="col-12">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <div class="add-new-contact ml-20">
                    @if(!\App\Models\Company::exists())
                        <a href="{{ route('companies.create') }}"
                            class="bg-success-light text-success btn ui-sortable-handle" style="float: left;">
                            مشروع جديد
                        </a>
                    @endif
                </div>
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form action="{{ route('companies.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
                                        style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                        <h4 class="mb-0"
                                            style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                            إضف جديد</h4>
                                        <button type="button" class="close ml-2" data-dismiss="modal"
                                            aria-label="Close"
                                            style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="vendor_name" class="mb-2 black bold">اسم
                                                    المشروع</label>
                                                <input type="text" class="theme-input-style" id="vendor_name"
                                                    name="name" placeholder="اكتب اسم المشروع هنا">
                                            </div>
                                        </div>
                                     
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="vendor_logo" class="mb-2 black bold">شعار
                                                    المشروع</label>
                                                <input type="file" class="theme-input-style" id="vendor_logo"
                                                    name="logo">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="vendor_contact" class="mb-2 black bold">معلومات
                                                    التواصل</label>
                                                <input type="number" class="theme-input-style" id="vendor_contact"
                                                    name="phone" placeholder="رقم الهاتف ">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                               
                                                <label
                                                    style="cursor: pointer; display: inline-flex; align-items: center; margin-right: 12px;">
                                                    <input type="radio" name="theme_id" value="4"
                                                        style="display:none;">
                                                       
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                                <label for="vendor_desc" class="mb-2 black bold">الوصف</label>
                                                <textarea class="theme-input-style" id="vendor_desc" name="description"
                                                    placeholder="نبذة عن المشروع"></textarea>
                                            </div>
                                        </div>

                                    </div>

                            </div>
                            <div class="d-flex justify-content-center pt-3" style="    padding-bottom: 10px;">
                                <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>
                            </form>
                        </div>
                        <!-- End Modal Body -->
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="text-nowrap bg-white dh-table" id="companies-table">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>اسم المشروع</th>
                                <th>النطاق</th>
                                <th>الفروع</th>
                                <th  style="display: none;">المنتجات</th>
                                <th>الحملات</th>
                                <th>رقم الهاتف</th>
                                <th> الصورة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $one)
                                @if(is_object($one))
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $one->name ?? '' }}</td>
                                    <td>{{ $one->domains ? $one->domains->url : '' }}</td>
                                    <td><a href="{{ route('cats.index', ['id' => $one->id ?? 0])}}"
                                            class="text-primary">{{ count($one->categories ?? []) }}</a></td>
                                    <td style="display: none;"><a href="{{ route('products.index', ['id' => $one->id ?? 0])}}"
                                            class="text-primary">{{ count($one->products ?? []) }}</a></td>
                                    <td><a href="{{ route('all_ads', ['comp_id' => $one->id ?? 0, 'name' => $one->name ?? '']) }}"
                                            class="text-primary">{{ count($one->ads ?? []) }}</a></td>
                                    <td>{{ $one->setting ? $one->setting->phone : '' }}</td>
                                    <td>
                                        @if($one->setting && $one->setting->logo)
                                        <a href="{{ new_asset($one->setting->logo) }}" target="_blank">
                                            <img src="{{ new_asset($one->setting->logo) }}" alt="Logo"
                                                style="width: 50px; height: 50px; object-fit: contain;">
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-sm bg-info-light text-info mr-10" data-toggle="modal"
                                            data-target="#projectEditModal_{{ $one->id ?? 0 }}">تعديل</a>
                                        <form action="{{ route('companies.destroy', $one->id ?? 0) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm bg-danger-light text-danger mr-10"
                                                onclick="return confirm('سيتم حذف الفروع والمنتجات المتعلقة بهذا المشروع هل أنت متأكد من الحذف ');">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <div id="projectEditModal_{{ $one->id ?? 0 }}" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="{{ route('companies.update', $one->id ?? 0) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    {{ $one->id }}
                                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
                                                        style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                                        <h4 class="mb-0"
                                                            style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                                            تعديل </h4>
                                                        <button type="button" class="close ml-2" data-dismiss="modal"
                                                            aria-label="Close"
                                                            style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="vendor_name" class="mb-2 black bold">اسم المشروع</label>
                                                                <input type="text" class="theme-input-style" id="vendor_name" name="name"
                                                                    value="{{ $one->name ?? '' }}">
                                                            </div>
                                                        </div>
                                                     
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="domain" class="mb-2 black bold">النطاق (domain)</label>
                                                                <select class="theme-input-style mb-5" id="domain" name="domain" required>
                                                                    <option value="">اختر نطاقاً</option>
                                                                    @foreach($domain as $d)
                                                                        <option value="{{ $d->id }}" {{ $one->domain == $d->id ? 'selected' : '' }}>{{ $d->url }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <div class="col-lg-12">
                                                                <label for="vendor_logo" class="mb-2 black bold">شعار المشروع</label>
                                                                <input type="file" class="theme-input-style" id="vendor_logo" name="logo">
                                                            </div>
                                                            <div class="col-lg-3">
                                                                @if($one->setting && $one->setting->logo)
                                                                <a href="{{ new_asset($one->setting->logo) }}" target="_blank">
                                                                    <img src="{{ new_asset($one->setting->logo) }}"
                                                                        style="width: 100px; height: auto; border: 2px solid transparent; border-radius: 8px;">
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="vendor_contact" class="mb-2 black bold">معلومات التواصل</label>
                                                                <input type="text" class="theme-input-style" id="vendor_contact" name="phone"
                                                                    value="{{ $one->setting ? $one->setting->phone : '' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-4">
                                                                <label for="vendor_desc" class="mb-2 black bold">الوصف</label>
                                                                <textarea class="theme-input-style" name="description">{{ $one->description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center pt-3" style="padding-bottom: 10px;">
                                                        <button type="submit" class="btn btn-primary ml-3">تعديل</button>
                                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>