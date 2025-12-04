<div class="row">
    <div class="col-12">

        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                @php
                $name = App\Models\Company::findorFail(request()->get('id'))->name;
                @endphp
                <h4 class="font-20 "> منتجات {{ $name }} </h4>

                <div class="add-new-contact ml-20">
                    <a class="bg-success-light text-success btn ui-sortable-handle" data-toggle="modal"
                        data-target="#projectAddModal" style="float: left;">
                        إضف جديد
                    </a>
                </div>
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form action="{{ route('products.index') }}" method="POST"
                                    enctype="multipart/form-data">
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
                                        <div class="col-md-6 mb-4">
                                            <label class="mb-2 font-weight-bold">الاسم </label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="mb-2 font-weight-bold">الموقع</label>
                                            <input type="text" name="location" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="mb-2 font-weight-bold">الصور </label>
                                            <input type="file" name="images[]" class="form-control" multiple>
                                            <small class="text-muted">يمكنك رفع أكثر من صورة</small>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="mb-2 font-weight-bold">رقم واتساب</label>
                                            <input type="text" name="whatsapp" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="mb-2 font-weight-bold">رقم للتواصل</label>
                                            <input type="text" name="phone" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label class="mb-2 font-weight-bold">رابط إنستجرام</label>
                                            <input type="url" name="instagram" class="form-control">
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="mb-2 font-weight-bold">الوصف الكامل</label>
                                            <textarea name="description" class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="company_id" class="form-control"
                                                        value="{{request()->get('id')}}">
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
                    <!-- Invoice List Table -->
                    <table class="text-nowrap bg-white dh-table">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الاسم </th>
                                <th>اللوكيشن</th>
                                <th>الوصف</th>
                                <th>رقم الاتصال</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $one)
                            <tr>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ is_object($one) ? $one->name : '' }}</td>
                                <td>{{ is_object($one) ? $one->location : '' }}</td>
                                <td>{{ is_object($one) ? $one->description : ''}}</td>
                                <td>
                                    {{
                                        (is_object($one) && isset($one->socialMedia))
                                            ? optional($one->socialMedia->where('type','phone')->first())->link
                                            : ''
                                    }}
                                </td>
                                <td>
                                    <a class="btn btn-sm bg-info-light text-info mr-10" data-toggle="modal"
                                        data-target="#projectEditModal_{{$one->id}}">تعديل</a>
                                    <form action="{{ route('products.destroy',$one->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="company_id" class="form-control"
                                            value="{{request()->get('id')}}"> <button type="submit"
                                            class="btn btn-sm bg-danger-light text-danger mr-10"
                                            onclick="return confirm('هل أنت متأكد من الحذف ');">حذف</button>
                                    </form>
                                </td>
                            </tr>
                            <div id="projectEditModal_{{$one->id}}" class="modal fade">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <form action="{{ route('products.update',$one->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
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
                                                    <div class="col-md-6 mb-4">
                                                        <label class="mb-2 font-weight-bold">الاسم
                                                        </label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $one->name }}">
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <label class="mb-2 font-weight-bold">الموقع</label>
                                                        <input type="text" name="location" class="form-control"
                                                            value="{{ $one->location }}">
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <label class="mb-2 font-weight-bold">الصور
                                                        </label>
                                                        <input type="file" name="images[]" class="form-control"
                                                            multiple>
                                                        <small class="text-muted">يمكنك رفع أكثر من
                                                            صورة</small>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        @php
                                                        $images = json_decode($one->image, true) ?? [];
                                                        @endphp
                                                        @foreach($images as $img)
                                                        <a href="{{ new_asset($img) }}" target="_blank">
                                                            <img src="{{ new_asset($img) }}"
                                                                style="width: 100px; height: auto; border: 2px solid transparent; border-radius: 8px;">
                                                        </a>
                                                        @endforeach
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <label class="mb-2 font-weight-bold">رقم
                                                            واتساب</label>
                                                        <input type="text" name="whatsapp" class="form-control"
                                                            value="{{ $one->socialMedia->where('type','whatsapp')->first()?->link }}">
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <label class="mb-2 font-weight-bold">رقم
                                                            للتواصل</label>
                                                        <input type="text" name="phone" class="form-control"
                                                            value="{{ $one->socialMedia->where('type','phone')->first()?->link }}">
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <label class="mb-2 font-weight-bold">رابط
                                                            إنستجرام</label>
                                                        <input type="url" name="instagram" class="form-control"
                                                            value="{{ $one->socialMedia->where('type','instagram')->first()?->link }}">
                                                    </div>

                                                    <!-- <div class="col-md-6 mb-4">
                                                                   <label class="mb-2 font-weight-bold">روابط
                                                                       إضافية</label>
                                                                   <input type="url" name="extra_links[]"
                                                                       class="form-control"
                                                                       placeholder="رابط إضافي آخر (اختياري)">
                                                               </div> -->
                                                    <div class="col-md-6 mb-4">
                                                        <label class="mb-2 font-weight-bold">الوصف
                                                            الكامل</label>
                                                        <textarea name="description" class="form-control"
                                                            rows="4">{{ $one->description }}</textarea>
                                                    </div>
                                                    <input type="hidden" name="company_id" class="form-control"
                                                        value="{{request()->get('id')}}">
                                                </div>
                                        </div>
                                        <div class="d-flex justify-content-center pt-3"
                                            style="    padding-bottom: 10px;">
                                            <button type="submit" class="btn btn-primary ml-3">تعديل</button>
                                            <button type="reset" class="btn btn-secondary"
                                                data-dismiss="modal">إلغاء</button>
                                        </div>
                                        </form>
                                    </div>
                                    <!-- End Modal Body -->
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Invoice List Table -->
                </div>
            </div>
        </div>

    </div>
</div>