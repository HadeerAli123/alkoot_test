<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('assets/js/branch-validation.js') }}"></script>
<style>
table.dataTable thead th,
table.dataTable thead td,
table.dataTable tfoot th,
table.dataTable tfoot td {
    text-align: justify !important;
}
.invalid-feedback {
    display: block !important;
    width: 100%;
    margin-top: 5px;
    font-size: 0.875rem;
    color: #dc3545;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <h4 class="font-20">الفروع</h4>
                <div class="add-new-contact ml-20">
                    <a href="#" class="bg-success-light text-success btn ui-sortable-handle" data-toggle="modal" data-target="#projectAddModal" style="float: left;">
                        فرع جديد
                    </a>
                </div>

                <!-- Add New Branch Modal -->
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form id="add-branch-form" action="{{ route('cats.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center" style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                        <h4 class="mb-0" style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                            إضافة فرع جديد
                                        </h4>
                                        <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close" style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    @php
                                        $company = App\Models\Company::find(request()->get('id'));
                                        $theme_id = 4;
                                    @endphp

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="name" class="mb-2 black bold">اسم الفرع <span class="text-danger">*</span></label>
                                                <input type="text" class="theme-input-style @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="أدخل اسم الفرع">
                                                <div class="invalid-feedback"></div>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="geex-input-whatsapp" class="form-label">رقم واتساب</label>
                                                <div class="input-wrapper input-icon position-relative">
                                                    <div class="input-group">
                                                        <span class="input-group-text p-0" style="min-width: 110px;">
                                                            <img id="selected-whatsapp-flag-img" src="{{ asset('assets/flags/sa.png') }}" alt="flag" style="width: 24px; height: 18px; margin-right: 5px;">
                                                            <select name="whatsapp_country_code" id="whatsapp-country-code-select" class="form-select border-0 bg-transparent px-2 @error('whatsapp_country_code') is-invalid @enderror" style="width: 80px;">
                                                                <option value="+966" {{ old('whatsapp_country_code') == '+966' ? 'selected' : '' }} data-flag="sa" data-flag-src="{{ asset('assets/flags/sa.png') }}">+966</option>
                                                                <option value="+20" {{ old('whatsapp_country_code') == '+20' ? 'selected' : '' }} data-flag="eg" data-flag-src="{{ asset('assets/flags/eg.png') }}">+20</option>
                                                                <option value="+971" {{ old('whatsapp_country_code') == '+971' ? 'selected' : '' }} data-flag="ae" data-flag-src="{{ asset('assets/flags/ae.png') }}">+971</option>
                                                                <option value="+965" {{ old('whatsapp_country_code') == '+965' ? 'selected' : '' }} data-flag="kw" data-flag-src="{{ asset('assets/flags/kw.png') }}">+965</option>
                                                                <option value="+964" {{ old('whatsapp_country_code') == '+964' ? 'selected' : '' }} data-flag="iq" data-flag-src="{{ asset('assets/flags/iq.png') }}">+964</option>
                                                                <option value="+962" {{ old('whatsapp_country_code') == '+962' ? 'selected' : '' }} data-flag="jo" data-flag-src="{{ asset('assets/flags/jo.png') }}">+962</option>
                                                                <option value="+963" {{ old('whatsapp_country_code') == '+963' ? 'selected' : '' }} data-flag="sy" data-flag-src="{{ asset('assets/flags/sy.png') }}">+963</option>
                                                                <option value="+968" {{ old('whatsapp_country_code') == '+968' ? 'selected' : '' }} data-flag="om" data-flag-src="{{ asset('assets/flags/om.png') }}">+968</option>
                                                                <option value="+973" {{ old('whatsapp_country_code') == '+973' ? 'selected' : '' }} data-flag="bh" data-flag-src="{{ asset('assets/flags/bh.png') }}">+973</option>
                                                                <option value="+974" {{ old('whatsapp_country_code') == '+974' ? 'selected' : '' }} data-flag="qa" data-flag-src="{{ asset('assets/flags/qa.png') }}">+974</option>
                                                            </select>
                                                        </span>
                                                        <input id="geex-input-whatsapp" type="text" name="whatsapp" placeholder="أدخل رقم واتساب" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        <span class="input-group-text"><i class="uil uil-whatsapp"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                    @error('whatsapp_country_code')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @error('whatsapp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="geex-input-phone" class="form-label">رقم للتواصل</label>
                                                <div class="input-wrapper input-icon position-relative">
                                                    <div class="input-group">
                                                        <span class="input-group-text p-0" style="min-width: 110px;">
                                                            <img id="selected-phone-flag-img" src="{{ asset('assets/flags/sa.png') }}" alt="flag" style="width: 24px; height: 18px; margin-right: 5px;">
                                                            <select name="phone_country_code" id="phone-country-code-select" class="form-select border-0 bg-transparent px-2 @error('phone_country_code') is-invalid @enderror" style="width: 80px;">
                                                                <option value="+966" {{ old('phone_country_code') == '+966' ? 'selected' : '' }} data-flag="sa" data-flag-src="{{ asset('assets/flags/sa.png') }}">+966</option>
                                                                <option value="+20" {{ old('phone_country_code') == '+20' ? 'selected' : '' }} data-flag="eg" data-flag-src="{{ asset('assets/flags/eg.png') }}">+20</option>
                                                                <option value="+971" {{ old('phone_country_code') == '+971' ? 'selected' : '' }} data-flag="ae" data-flag-src="{{ asset('assets/flags/ae.png') }}">+971</option>
                                                                <option value="+965" {{ old('phone_country_code') == '+965' ? 'selected' : '' }} data-flag="kw" data-flag-src="{{ asset('assets/flags/kw.png') }}">+965</option>
                                                                <option value="+964" {{ old('phone_country_code') == '+964' ? 'selected' : '' }} data-flag="iq" data-flag-src="{{ asset('assets/flags/iq.png') }}">+964</option>
                                                                <option value="+962" {{ old('phone_country_code') == '+962' ? 'selected' : '' }} data-flag="jo" data-flag-src="{{ asset('assets/flags/jo.png') }}">+962</option>
                                                                <option value="+963" {{ old('phone_country_code') == '+963' ? 'selected' : '' }} data-flag="sy" data-flag-src="{{ asset('assets/flags/sy.png') }}">+963</option>
                                                                <option value="+968" {{ old('phone_country_code') == '+968' ? 'selected' : '' }} data-flag="om" data-flag-src="{{ asset('assets/flags/om.png') }}">+968</option>
                                                                <option value="+973" {{ old('phone_country_code') == '+973' ? 'selected' : '' }} data-flag="bh" data-flag-src="{{ asset('assets/flags/bh.png') }}">+973</option>
                                                                <option value="+974" {{ old('phone_country_code') == '+974' ? 'selected' : '' }} data-flag="qa" data-flag-src="{{ asset('assets/flags/qa.png') }}">+974</option>
                                                            </select>
                                                        </span>
                                                        <input id="geex-input-phone" type="text" name="phone" placeholder="أدخل رقم للتواصل" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        <span class="input-group-text"><i class="uil uil-phone"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                    @error('phone_country_code')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="instagram" class="mb-2 black bold">رابط إنستجرام</label>
                                                <input type="text" class="theme-input-style @error('instagram') is-invalid @enderror" name="instagram" value="{{ old('instagram') }}" placeholder="أدخل رابط إنستجرام">
                                                <div class="invalid-feedback"></div>
                                                @error('instagram')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="google_Map" class="mb-2 black bold">رابط جوجل ماب</label>
                                                <input type="text" class="theme-input-style @error('google_Map') is-invalid @enderror" name="google_Map" value="{{ old('google_Map') }}" placeholder="أدخل رابط جوجل ماب">
                                                <div class="invalid-feedback"></div>
                                                @error('google_Map')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="google_Map_2" class="mb-2 black bold">رابط جوجل ماب 2</label>
                                                <input type="text" class="theme-input-style @error('google_Map_2') is-invalid @enderror" name="google_Map_2" value="{{ old('google_Map_2') }}" placeholder="أدخل رابط جوجل ماب">
                                                <div class="invalid-feedback"></div>
                                                @error('google_Map_2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if($theme_id == 2)
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="menu" class="mb-2 black bold">قائمة الطعام (PDF)</label>
                                                    <input type="file" class="theme-input-style @error('menu') is-invalid @enderror" name="menu" accept="application/pdf">
                                                    <div class="invalid-feedback"></div>
                                                    @error('menu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                                <label for="description" class="mb-2 black bold">الوصف</label>
                                                <textarea class="theme-input-style @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="وصف">{{ old('description') }}</textarea>
                                                <div class="invalid-feedback"></div>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" name="company_id" value="{{ request()->get('id') }}">
                                    </div>

                                    <div class="d-flex justify-content-center pt-3" style="padding-bottom: 10px;">
                                        <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="text-nowrap bg-white dh-table">
                        <thead class="thead-light">
                            <tr>
                                <th>م</th>
                                <th>اسم الفرع</th>
                                <th>عدد الحملات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $one)
                                @php
                                    $ads = App\Models\Ads::where('company_id', request()->get('id'))->get();
                                    $countAds = 0;
                                    foreach ($ads as $ad) {
                                        $catsIds = is_array($ad->cats_ids) ? $ad->cats_ids : json_decode($ad->cats_ids, true);
                                        $catsIds = is_array($catsIds) ? $catsIds : [];
                                        if (!empty($catsIds) && ($catsIds[0] === 'all' || in_array($one->id, $catsIds))) {
                                            $countAds++;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $one->name }}</td>
                                    <td>
                                        <a href="{{ route('ads_.index', ['comp_id' => request()->get('id'), 'cat_id' => $one->id]) }}" class="text-primary">
                                            {{ $countAds }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm bg-info-light text-info mr-10" data-toggle="modal" data-target="#projectEditModal_{{ $one->id }}">تعديل</a>
                                        <form action="{{ route('cats.destroy', $one->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="company_id" value="{{ request()->get('id') }}">
                                            <button type="submit" class="btn btn-sm bg-danger-light text-danger mr-10" onclick="return confirm('هل أنت متأكد من الحذف؟');">حذف</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                        <div id="projectEditModal_{{$one->id}}" class="modal fade">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                       <form id="edit-branch-form-{{ $one->id }}" action="{{ route('cats.update', $one->id) }}" method="POST" enctype="multipart/form-data">

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
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="edit_name_{{$one->id}}"
                                                                class="mb-2 black bold">اسم الفرع <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" class="theme-input-style" name="name"
                                                                value="{{ $one->name }}">
                                                                <span class="error-text text-danger" id="name_error_{{ $one->id }}"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="edit_whatsapp_{{$one->id}}" class="form-label">رقم واتساب</label>
                                                            <div class="input-wrapper input-icon position-relative">
                                                                <div class="input-group">
                                                                    <span class="input-group-text p-0" style="min-width: 110px;">
                                                                        @php
                                                                            $whatsappNumber = $one->socialMedia->where('type','whatsapp')->first()?->link ?? '';
                                                                            $countryCode = '';
                                                                            $countryCodes = ['+966', '+20', '+971', '+965', '+964', '+962', '+963', '+968', '+973', '+974'];
                                                                            foreach ($countryCodes as $code) {
                                                                                if ($whatsappNumber && strpos($whatsappNumber, $code) === 0) {
                                                                                    $countryCode = $code;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            $whatsappCountryCode = $countryCode ?: '+966';
                                                                            $whatsappFlag = [
                                                                                '+966' => 'sa',
                                                                                '+20' => 'eg',
                                                                                '+971' => 'ae',
                                                                                '+965' => 'kw',
                                                                                '+964' => 'iq',
                                                                                '+962' => 'jo',
                                                                                '+963' => 'sy',
                                                                                '+968' => 'om',
                                                                                '+973' => 'bh',
                                                                                '+974' => 'qa',
                                                                            ][$whatsappCountryCode] ?? 'sa';
                                                                            $whatsappNumberOnly = $whatsappNumber;
                                                                            if ($whatsappNumber && strpos($whatsappNumber, $whatsappCountryCode) === 0) {
                                                                                $whatsappNumberOnly = substr($whatsappNumber, strlen($whatsappCountryCode));
                                                                            }
                                                                        @endphp
                                                                        <img id="edit-whatsapp-flag-img-{{$one->id}}" src="{{ asset('assets/flags/'.$whatsappFlag.'.png') }}" alt="flag" style="width: 24px; height: 18px; margin-right: 5px;">
                                                                        <select name="whatsapp_country_code" id="edit-whatsapp-country-code-select-{{$one->id}}" class="form-select border-0 bg-transparent px-2" style="width: 80px;">
                                                                            <option value="+966" @if($whatsappCountryCode=='+966') selected @endif data-flag="sa" data-flag-src="{{ asset('assets/flags/sa.png') }}">+966</option>
                                                                            <option value="+20" @if($whatsappCountryCode=='+20') selected @endif data-flag="eg" data-flag-src="{{ asset('assets/flags/eg.png') }}">+20</option>
                                                                            <option value="+971" @if($whatsappCountryCode=='+971') selected @endif data-flag="ae" data-flag-src="{{ asset('assets/flags/ae.png') }}">+971</option>
                                                                            <option value="+965" @if($whatsappCountryCode=='+965') selected @endif data-flag="kw" data-flag-src="{{ asset('assets/flags/kw.png') }}">+965</option>
                                                                            <option value="+964" @if($whatsappCountryCode=='+964') selected @endif data-flag="iq" data-flag-src="{{ asset('assets/flags/iq.png') }}">+964</option>
                                                                            <option value="+962" @if($whatsappCountryCode=='+962') selected @endif data-flag="jo" data-flag-src="{{ asset('assets/flags/jo.png') }}">+962</option>
                                                                            <option value="+963" @if($whatsappCountryCode=='+963') selected @endif data-flag="sy" data-flag-src="{{ asset('assets/flags/sy.png') }}">+963</option>
                                                                            <option value="+968" @if($whatsappCountryCode=='+968') selected @endif data-flag="om" data-flag-src="{{ asset('assets/flags/om.png') }}">+968</option>
                                                                            <option value="+973" @if($whatsappCountryCode=='+973') selected @endif data-flag="bh" data-flag-src="{{ asset('assets/flags/bh.png') }}">+973</option>
                                                                            <option value="+974" @if($whatsappCountryCode=='+974') selected @endif data-flag="qa" data-flag-src="{{ asset('assets/flags/qa.png') }}">+974</option>
                                                                        </select>
                                                                    </span>
                                                                    <input id="edit-geex-input-whatsapp-{{$one->id}}" type="text" name="whatsapp" placeholder="أدخل رقم واتساب" class="form-control"
                                                                        value="{{ $whatsappNumberOnly }}" inputmode="numeric" pattern="[0-9]*"
                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                    <span class="input-group-text"><i class="uil uil-whatsapp"></i></span>
                                                                </div>
                                                                <span id="edit-whatsapp-validity-msg-{{$one->id}}" class="mt-2 d-block" style="font-size: 0.95rem;"></span>
                                                                <span class="error-text text-danger" id="whatsapp_error_{{ $one->id }}"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            const whatsappSelect = document.getElementById('edit-whatsapp-country-code-select-{{$one->id}}');
                                                            const whatsappFlagImg = document.getElementById('edit-whatsapp-flag-img-{{$one->id}}');
                                                            const whatsappInput = document.getElementById('edit-geex-input-whatsapp-{{$one->id}}');
                                                            const whatsappMsgSpan = document.getElementById('edit-whatsapp-validity-msg-{{$one->id}}');

                                                            function updateFlag(select, flagImg) {
                                                                const selectedOption = select.options[select.selectedIndex];
                                                                const flagSrc = selectedOption.getAttribute('data-flag-src');
                                                                if(flagSrc) {
                                                                    flagImg.src = flagSrc;
                                                                }
                                                            }

                                                            function validatePhone(select, input, msgSpan) {
                                                                const countryCode = select.value;
                                                                const phone = input.value.trim();
                                                                let valid = false;
                                                                let regex;
                                                                switch(countryCode) {
                                                                    case '+966': regex = /^5\d{8}$/; break; // Saudi Arabia
                                                                    case '+20': regex = /^1\d{9}$/; break; // Egypt
                                                                    case '+971': regex = /^5\d{8}$/; break; // UAE
                                                                    case '+965': regex = /^[569]\d{7}$/; break; // Kuwait
                                                                    case '+964': regex = /^7\d{9}$/; break; // Iraq
                                                                    case '+962': regex = /^7\d{8}$/; break; // Jordan
                                                                    case '+963': regex = /^9\d{8}$/; break; // Syria
                                                                    case '+968': regex = /^9\d{7}$/; break; // Oman
                                                                    case '+973': regex = /^3\d{7}$/; break; // Bahrain
                                                                    case '+974': regex = /^3\d{7}$/; break; // Qatar
                                                                    default: regex = /^\d+$/;
                                                                }
                                                                if (regex.test(phone)) valid = true;
                                                                if (phone.length === 0) {
                                                                    msgSpan.textContent = '';
                                                                    msgSpan.classList.remove('text-success', 'text-danger');
                                                                } else if (valid) {
                                                                    msgSpan.textContent = 'الرقم صحيح';
                                                                    msgSpan.classList.add('text-success');
                                                                    msgSpan.classList.remove('text-danger');
                                                                } else {
                                                                    msgSpan.textContent = 'الرقم غير صحيح';
                                                                    msgSpan.classList.add('text-danger');
                                                                    msgSpan.classList.remove('text-success');
                                                                }
                                                            }

                                                            if (whatsappSelect && whatsappFlagImg && whatsappInput && whatsappMsgSpan) {
                                                                whatsappSelect.addEventListener('change', function() {
                                                                    updateFlag(whatsappSelect, whatsappFlagImg);
                                                                    validatePhone(whatsappSelect, whatsappInput, whatsappMsgSpan);
                                                                });
                                                                whatsappInput.addEventListener('input', function() {
                                                                    validatePhone(whatsappSelect, whatsappInput, whatsappMsgSpan);
                                                                });
                                                                updateFlag(whatsappSelect, whatsappFlagImg);
                                                                validatePhone(whatsappSelect, whatsappInput, whatsappMsgSpan);
                                                            }
                                                        });
                                                    </script> -->
                                                    <!-- رقم للتواصل -->
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="edit_phone_{{$one->id}}" class="form-label">رقم للتواصل</label>
                                                            <div class="input-wrapper input-icon position-relative">
                                                                <div class="input-group">
                                                                    <span class="input-group-text p-0" style="min-width: 110px;">
                                                                        @php
                                                                            $phoneNumber = $one->socialMedia->where('type','phone')->first()?->link ?? '';
                                                                            $phoneCountryCode = '';
                                                                            $countryCodes = ['+966', '+20', '+971', '+965', '+964', '+962', '+963', '+968', '+973', '+974'];
                                                                            foreach ($countryCodes as $code) {
                                                                                if ($phoneNumber && strpos($phoneNumber, $code) === 0) {
                                                                                    $phoneCountryCode = $code;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            $phoneCountryCode = $phoneCountryCode ?: '+966';
                                                                            $phoneFlag = [
                                                                                '+966' => 'sa',
                                                                                '+20' => 'eg',
                                                                                '+971' => 'ae',
                                                                                '+965' => 'kw',
                                                                                '+964' => 'iq',
                                                                                '+962' => 'jo',
                                                                                '+963' => 'sy',
                                                                                '+968' => 'om',
                                                                                '+973' => 'bh',
                                                                                '+974' => 'qa',
                                                                            ][$phoneCountryCode] ?? 'sa';
                                                                            $phoneNumberOnly = $phoneNumber;
                                                                            if ($phoneNumber && strpos($phoneNumber, $phoneCountryCode) === 0) {
                                                                                $phoneNumberOnly = substr($phoneNumber, strlen($phoneCountryCode));
                                                                            }
                                                                        @endphp
                                                                        <img id="edit-phone-flag-img-{{$one->id}}" src="{{ asset('assets/flags/'.$phoneFlag.'.png') }}" alt="flag" style="width: 24px; height: 18px; margin-right: 5px;">
                                                                        <select name="phone_country_code" id="edit-phone-country-code-select-{{$one->id}}" class="form-select border-0 bg-transparent px-2" style="width: 80px;">
                                                                            <option value="+966" @if($phoneCountryCode=='+966') selected @endif data-flag="sa" data-flag-src="{{ asset('assets/flags/sa.png') }}">+966</option>
                                                                            <option value="+20" @if($phoneCountryCode=='+20') selected @endif data-flag="eg" data-flag-src="{{ asset('assets/flags/eg.png') }}">+20</option>
                                                                            <option value="+971" @if($phoneCountryCode=='+971') selected @endif data-flag="ae" data-flag-src="{{ asset('assets/flags/ae.png') }}">+971</option>
                                                                            <option value="+965" @if($phoneCountryCode=='+965') selected @endif data-flag="kw" data-flag-src="{{ asset('assets/flags/kw.png') }}">+965</option>
                                                                            <option value="+964" @if($phoneCountryCode=='+964') selected @endif data-flag="iq" data-flag-src="{{ asset('assets/flags/iq.png') }}">+964</option>
                                                                            <option value="+962" @if($phoneCountryCode=='+962') selected @endif data-flag="jo" data-flag-src="{{ asset('assets/flags/jo.png') }}">+962</option>
                                                                            <option value="+963" @if($phoneCountryCode=='+963') selected @endif data-flag="sy" data-flag-src="{{ asset('assets/flags/sy.png') }}">+963</option>
                                                                            <option value="+968" @if($phoneCountryCode=='+968') selected @endif data-flag="om" data-flag-src="{{ asset('assets/flags/om.png') }}">+968</option>
                                                                            <option value="+973" @if($phoneCountryCode=='+973') selected @endif data-flag="bh" data-flag-src="{{ asset('assets/flags/bh.png') }}">+973</option>
                                                                            <option value="+974" @if($phoneCountryCode=='+974') selected @endif data-flag="qa" data-flag-src="{{ asset('assets/flags/qa.png') }}">+974</option>
                                                                        </select>
                                                                    </span>
                                                                    <input id="edit-geex-input-phone-{{$one->id}}" type="text" name="phone" placeholder="أدخل رقم للتواصل" class="form-control"
                                                                        value="{{ $phoneNumberOnly }}" inputmode="numeric" pattern="[0-9]*"
                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                                    <span class="input-group-text"><i class="uil uil-phone"></i></span>
                                                                </div>
                                                                <span id="edit-phone-validity-msg-{{$one->id}}" class="mt-2 d-block" style="font-size: 0.95rem;"></span>
                                                                <span class="error-text text-danger" id="phone_error_{{ $one->id }}"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            const phoneSelect = document.getElementById('edit-phone-country-code-select-{{$one->id}}');
                                                            const phoneFlagImg = document.getElementById('edit-phone-flag-img-{{$one->id}}');
                                                            const phoneInput = document.getElementById('edit-geex-input-phone-{{$one->id}}');
                                                            const phoneMsgSpan = document.getElementById('edit-phone-validity-msg-{{$one->id}}');

                                                            function updateFlag(select, flagImg) {
                                                                const selectedOption = select.options[select.selectedIndex];
                                                                const flagSrc = selectedOption.getAttribute('data-flag-src');
                                                                if(flagSrc) {
                                                                    flagImg.src = flagSrc;
                                                                }
                                                            }

                                                            function validatePhone(select, input, msgSpan) {
                                                                const countryCode = select.value;
                                                                const phone = input.value.trim();
                                                                let valid = false;
                                                                let regex;
                                                                switch(countryCode) {
                                                                    case '+966': regex = /^5\d{8}$/; break; // Saudi Arabia
                                                                    case '+20': regex = /^1\d{9}$/; break; // Egypt
                                                                    case '+971': regex = /^5\d{8}$/; break; // UAE
                                                                    case '+965': regex = /^[569]\d{7}$/; break; // Kuwait
                                                                    case '+964': regex = /^7\d{9}$/; break; // Iraq
                                                                    case '+962': regex = /^7\d{8}$/; break; // Jordan
                                                                    case '+963': regex = /^9\d{8}$/; break; // Syria
                                                                    case '+968': regex = /^9\d{7}$/; break; // Oman
                                                                    case '+973': regex = /^3\d{7}$/; break; // Bahrain
                                                                    case '+974': regex = /^3\d{7}$/; break; // Qatar
                                                                    default: regex = /^\d+$/;
                                                                }
                                                                if (regex.test(phone)) valid = true;
                                                                if (phone.length === 0) {
                                                                    msgSpan.textContent = '';
                                                                    msgSpan.classList.remove('text-success', 'text-danger');
                                                                } else if (valid) {
                                                                    msgSpan.textContent = 'الرقم صحيح';
                                                                    msgSpan.classList.add('text-success');
                                                                    msgSpan.classList.remove('text-danger');
                                                                } else {
                                                                    msgSpan.textContent = 'الرقم غير صحيح';
                                                                    msgSpan.classList.add('text-danger');
                                                                    msgSpan.classList.remove('text-success');
                                                                }
                                                            }

                                                            if (phoneSelect && phoneFlagImg && phoneInput && phoneMsgSpan) {
                                                                phoneSelect.addEventListener('change', function() {
                                                                    updateFlag(phoneSelect, phoneFlagImg);
                                                                    validatePhone(phoneSelect, phoneInput, phoneMsgSpan);
                                                                });
                                                                phoneInput.addEventListener('input', function() {
                                                                    validatePhone(phoneSelect, phoneInput, phoneMsgSpan);
                                                                });
                                                                updateFlag(phoneSelect, phoneFlagImg);
                                                                validatePhone(phoneSelect, phoneInput, phoneMsgSpan);
                                                            }
                                                        });
                                                    </script> -->
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="edit_name_{{$one->id}}" class="mb-2 black bold">
                                                                رابط إنستجرام </label>
                                                            <input type="text" class="theme-input-style"
                                                                name="instagram"
                                                                value="{{ $one->socialMedia->where('type','instagram')->first()?->link}}">
                                                                <span class="error-text text-danger" id="instagram_error_{{ $one->id }}"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="edit_name_{{$one->id}}" class="mb-2 black bold">
                                                                رابط جوجل ماب </label>
                                                            <input type="text" class="theme-input-style"
                                                                name="google_Map"
                                                                value="{{ $one->socialMedia->where('type','google_Map')->first()?->link }}">
                                                                <span class="error-text text-danger" id="google_Map_error_{{ $one->id }}"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="edit_name_{{$one->id}}" class="mb-2 black bold">
                                                              2  رابط جوجل ماب </label>
                                                            <input type="text" class="theme-input-style"
                                                                name="google_Map_2"
                                                                value="{{ $one->socialMedia->where('type','google_Map_2')->first()?->link }}">
                                                          <span class="error-text text-danger" id="google_Map_2_error_{{ $one->id }}"></span>

                                                        </div>
                                                    </div>
                                                    @if($theme_id == 2)
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label class="mb-2 black bold">
                                                                قائمة الطعام (PDF)</label>
                                                            <input type="file" class="theme-input-style" name="menu"
                                                                accept="application/pdf">

                                                  <span class="error-text text-danger" id="menu_error_{{ $one->id }}"></span>
          
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <a href="{{ isset($one->socialMedia) ? new_asset($one->socialMedia->where('type','menu')->where('id',$one->id)->first()?->link):'' }}"
                                                                target="_blank">
                                                                <img src="{{isset($one->socialMedia) ? new_asset($one->socialMedia->where('type','menu')->where('id',$one->id)->first()?->link):''  }}"
                                                                    style="width: 100px; height: auto; border: 2px solid transparent; border-radius: 8px;">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="col-lg-12">
                                                        <div class="form-group mb-4">
                                                            <label for="edit_description_{{$one->id}}"
                                                                class="mb-2 black bold">الوصف</label>
                                                            <textarea class="theme-input-style"
                                                                id="edit_description_{{$one->id}}" name="description"
                                                                rows="3"
                                                                placeholder="وصف ">{{ $one->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="company_id"
                                                        value="{{ request()->get('id') }}">
                                                </div>
                                                <div class="d-flex justify-content-center pt-3"
                                                    style="padding-bottom: 10px;">
                                                    <button type="submit" class="btn btn-primary ml-3">تعديل</button>
                                                    <button type="reset" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // دالة الفاليديشن الخاصة بالأرقام حسب كود الدولة (نفس اللي في UpdateCategoryRequest)
    function isValidPhoneByCountry(code, number) {
        if (!number) return true; // لو فاضي مسموح (لأن الحقل مش مطلوب أساسًا)
        const regex = {
            '+966': /^5\d{8}$/,      // السعودية: يبدأ بـ 5 و9 أرقام
            '+20': /^1\d{9}$/,       // مصر: يبدأ بـ 1 و10 أرقام
            '+971': /^5\d{8}$/,      // الإمارات: 5 + 8 أرقام
            '+965': /^[569]\d{7}$/,  // الكويت
            '+964': /^7\d{9}$/,      // العراق
            '+962': /^7\d{8}$/,      // الأردن
            '+963': /^9\d{8}$/,      // سوريا
            '+968': /^9\d{7}$/,      // عمان
            '+973': /^3\d{7}$/,      // البحرين
            '+974': /^3\d{7}$/,      // قطر
        }[code];

        return regex ? regex.test(number) : /^\d+$/.test(number);
    }

    // كل الفورمات اللي تبدأ بـ edit-branch-form-
    document.querySelectorAll('form[id^="edit-branch-form-"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            // مسح الأخطاء القديمة أولاً
            form.querySelectorAll('.error-text').forEach(el => el.textContent = '');
            let hasError = false;

            const formId = form.id.split('-').pop(); // id الفرع

            // جلب القيم
            const whatsappCode = form.querySelector(`#edit-whatsapp-country-code-select-${formId}`)?.value;
            const whatsappNumber = form.querySelector(`#edit-geex-input-whatsapp-${formId}`)?.value.trim();
            const phoneCode = form.querySelector(`#edit-phone-country-code-select-${formId}`)?.value;
            const phoneNumber = form.querySelector(`#edit-geex-input-phone-${formId}`)?.value.trim();

            // فاليديشن واتساب
            if (whatsappNumber && whatsappCode) {
                if (!isValidPhoneByCountry(whatsappCode, whatsappNumber)) {
                    const errSpan = document.getElementById(`whatsapp_error_${formId}`);
                    if (errSpan) errSpan.textContent = 'رقم الواتساب غير صالح لهذا الكود.';
                    hasError = true;
                }
            }

            // فاليديشن رقم التواصل
            if (phoneNumber && phoneCode) {
                if (!isValidPhoneByCountry(phoneCode, phoneNumber)) {
                    const errSpan = document.getElementById(`phone_error_${formId}`);
                    if (errSpan) errSpan.textContent = 'رقم التواصل غير صالح لهذا الكود.';
                    hasError = true;
                }
            }

            // لو فيه أي خطأ → نوقف الإرسال
            if (hasError) {
                e.preventDefault();
                return false;
            }

            // لو مفيش أخطاء → نكمل الإرسال بالـ AJAX (الكود القديم بتاعك)
            e.preventDefault(); // لسه هنمنع الإرسال العادي عشان نستخدم AJAX

            const formData = new FormData(form);
            if (!formData.has('_method')) formData.append('_method', 'PUT');
            if (!formData.has('_token')) formData.append('_token', '{{ csrf_token() }}');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.errors) {
                    // backend validation errors
                    for (let key in data.errors) {
                        const errorSpan = document.getElementById(`${key}_error_${formId}`);
                        if (errorSpan) errorSpan.textContent = data.errors[key][0];
                    }
                } else {
                 
                    $(`#projectEditModal_${formId}`).modal('hide');
                    location.reload();
                }
            })
            .catch(err => {
                console.error(err);
                alert('حدث خطأ أثناء الحفظ، حاول مرة أخرى.');
            });
        });
    });
});
</script>