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
                                <th style="display: none;">المنتجات</th>
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
                               <!-- Edit Modal -->
                                <div id="projectEditModal_{{ $one->id ?? 0 }}" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form id="editForm_{{ $one->id ?? 0 }}" action="{{ route('companies.update', $one->id ?? 0) }}" method="POST"
                                                    enctype="multipart/form-data" novalidate>
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
                                                            <div class="form-group mb-2">
                                                                <label for="vendor_name_{{ $one->id }}" class="mb-1 black bold">اسم المشروع <span class="text-danger">*</span></label>
                                                                <input type="text" class="theme-input-style" id="vendor_name_{{ $one->id }}" name="name"
                                                                    value="{{ $one->name ?? '' }}" required>
                                                                <span class="text-danger d-block mt-1 error-message" id="name_error_{{ $one->id }}"></span>
                                                                @error('name')
                                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                                @enderror    
                                                            </div>
                                                        </div>
                                                     
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="domain_{{ $one->id }}" class="mb-1 black bold">النطاق (domain) <span class="text-danger">*</span></label>
                                                                <select class="theme-input-style" id="domain_{{ $one->id }}" name="domain" required>
                                                                    <option value="">اختر النطاق</option>
                                                                    @foreach($domain as $d)
                                                                        <option value="{{ $d->id }}" {{ $one->domain == $d->id ? 'selected' : '' }}>{{ $d->url }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger d-block mt-1 error-message" id="domain_error_{{ $one->id }}"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <div class="col-lg-12">
                                                                <label for="vendor_logo_{{ $one->id }}" class="mb-1 black bold">شعار المشروع</label>
                                                                <input type="file" class="theme-input-style" id="vendor_logo_{{ $one->id }}" name="logo" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp">
                                                                <small class="text-muted d-block" style="font-size: 0.75rem;">الصيغ المسموحة: PNG, JPG, JPEG, SVG, WEBP (أقصى حجم: 2 ميجا)</small>
                                                                <span class="text-danger d-block mt-1 error-message" id="logo_error_{{ $one->id }}"></span>
                                                                @error('logo')
                                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                                @enderror   
                                                            </div>
                                                            <div class="col-lg-3 mt-2">
                                                                @if($one->setting && $one->setting->logo)
                                                                <a href="{{ new_asset($one->setting->logo) }}" target="_blank">
                                                                    <img src="{{ new_asset($one->setting->logo) }}"
                                                                        style="width: 80px; height: auto; border: 2px solid transparent; border-radius: 8px;">
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-2">
                                                                <label for="vendor_contact_{{ $one->id }}" class="mb-1 black bold">معلومات التواصل</label>
                                                                <input type="text" class="theme-input-style" id="vendor_contact_{{ $one->id }}" name="phone"
                                                                    value="{{ $one->setting ? $one->setting->phone : '' }}" placeholder="مثال: 01012345678">
                                                                <span class="text-danger d-block mt-1 error-message" id="phone_error_{{ $one->id }}"></span>
                                                                @error('phone')
                                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                                @enderror   
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-2">
                                                                <label for="vendor_desc_{{ $one->id }}" class="mb-1 black bold">الوصف</label>
                                                                <textarea class="theme-input-style" id="vendor_desc_{{ $one->id }}" name="description" rows="3">{{ $one->description ?? '' }}</textarea>
                                                                <small class="text-muted d-block" style="font-size: 0.75rem;">
                                                                    <span id="char_count_{{ $one->id }}">{{ strlen($one->description ?? '') }}</span>/500 حرف
                                                                </small>
                                                                <span class="text-danger d-block mt-1 error-message" id="description_error_{{ $one->id }}"></span>
                                                                @error('description')
                                                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                                @enderror   
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

                                <script>
                                (function() {
                                    const formId = 'editForm_{{ $one->id ?? 0 }}';
                                    const form = document.getElementById(formId);
                                    const id = '{{ $one->id ?? 0 }}';
                                    
                                    if (!form) return;

                                    // Character counter for description
                                    const descField = document.getElementById('vendor_desc_' + id);
                                    const charCount = document.getElementById('char_count_' + id);
                                    
                                    if (descField && charCount) {
                                        descField.addEventListener('input', function() {
                                            charCount.textContent = this.value.length;
                                        });
                                    }

                                    // Clear all error messages
                                    function clearErrors() {
                                        form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                                        form.querySelectorAll('.theme-input-style').forEach(el => {
                                            el.style.borderColor = '';
                                        });
                                    }

                                    // Show error message
                                    function showError(fieldId, message) {
                                        const errorEl = document.getElementById(fieldId + '_error_' + id);
                                        const inputEl = document.getElementById(fieldId + '_' + id);
                                        
                                        if (errorEl) errorEl.textContent = message;
                                        if (inputEl) inputEl.style.borderColor = '#dc3545';
                                    }

                                    // Validate name field
                                    function validateName() {
                                        const nameField = document.getElementById('vendor_name_' + id);
                                        if (!nameField) return true;
                                        const name = nameField.value.trim();
                                        
                                        if (!name) {
                                            showError('name', 'الاسم مطلوب.');
                                            return false;
                                        }
                                        return true;
                                    }

                                    // Validate domain field
                                    function validateDomain() {
                                        const domainField = document.getElementById('domain_' + id);
                                        if (!domainField) return true;
                                        const domain = domainField.value;
                                        
                                        if (!domain) {
                                            showError('domain', 'النطاق مطلوب.');
                                            return false;
                                        }
                                        return true;
                                    }

                                    // Validate logo field
                                    function validateLogo() {
                                        const logoField = document.getElementById('vendor_logo_' + id);
                                        if (!logoField) return true;
                                        
                                        if (logoField.files.length > 0) {
                                            const file = logoField.files[0];
                                            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'];
                                            const maxSize = 2 * 1024 * 1024; // 2MB
                                            
                                            if (!allowedTypes.includes(file.type)) {
                                                showError('logo', 'صيغة الصورة غير مدعومة. الصيغ المسموحة: PNG, JPG, JPEG, SVG, WEBP');
                                                return false;
                                            }
                                            
                                            if (file.size > maxSize) {
                                                showError('logo', 'حجم الصورة يجب ألا يتجاوز 2 ميجا');
                                                return false;
                                            }
                                        }
                                        return true;
                                    }

                                    // Validate phone field
                                    function validatePhone() {
                                        const phoneField = document.getElementById('vendor_contact_' + id);
                                        if (!phoneField) return true;
                                        const phone = phoneField.value.trim();
                                        
                                        if (phone) {
                                            const digitsOnly = phone.replace(/\D/g, '');
                                            
                                            if (digitsOnly.length < 10 || digitsOnly.length > 15) {
                                                showError('phone', 'رقم الهاتف يجب أن يكون بين 10 و 15 رقم');
                                                return false;
                                            }
                                        }
                                        return true;
                                    }

                                    // Validate description field
                                    function validateDescription() {
                                        const descField = document.getElementById('vendor_desc_' + id);
                                        if (!descField) return true;
                                        const description = descField.value.trim();
                                        
                                        if (description) {
                                            if (description.length < 10) {
                                                showError('description', 'وصف المشروع يجب ألا يقل عن 10 حروف');
                                                return false;
                                            }
                                            
                                            if (description.length > 500) {
                                                showError('description', 'وصف المشروع يجب ألا يزيد عن 500 حرف');
                                                return false;
                                            }
                                        }
                                        return true;
                                    }

                                    // Real-time validation on input
                                    const nameField = document.getElementById('vendor_name_' + id);
                                    const domainField = document.getElementById('domain_' + id);
                                    const logoField = document.getElementById('vendor_logo_' + id);
                                    const phoneField = document.getElementById('vendor_contact_' + id);
                                    const descFieldInput = document.getElementById('vendor_desc_' + id);

                                    if (nameField) {
                                        nameField.addEventListener('input', function() {
                                            const name = this.value.trim();
                                            const errorEl = document.getElementById('name_error_' + id);
                                            
                                            if (!name) {
                                                showError('name', 'الاسم مطلوب.');
                                            } else {
                                                if (errorEl) errorEl.textContent = '';
                                                this.style.borderColor = '#28a745';
                                            }
                                        });
                                    }

                                    if (domainField) {
                                        domainField.addEventListener('change', function() {
                                            const domain = this.value;
                                            const errorEl = document.getElementById('domain_error_' + id);
                                            
                                            if (!domain) {
                                                showError('domain', 'النطاق مطلوب.');
                                            } else {
                                                if (errorEl) errorEl.textContent = '';
                                                this.style.borderColor = '#28a745';
                                            }
                                        });
                                    }

                                    if (logoField) {
                                        logoField.addEventListener('change', function() {
                                            const errorEl = document.getElementById('logo_error_' + id);
                                            
                                            if (this.files.length > 0) {
                                                const file = this.files[0];
                                                const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'];
                                                const maxSize = 2 * 1024 * 1024;
                                                
                                                if (!allowedTypes.includes(file.type)) {
                                                    showError('logo', 'صيغة الصورة غير مدعومة. الصيغ المسموحة: PNG, JPG, JPEG, SVG, WEBP');
                                                } else if (file.size > maxSize) {
                                                    showError('logo', 'حجم الصورة يجب ألا يتجاوز 2 ميجا');
                                                } else {
                                                    if (errorEl) errorEl.textContent = '';
                                                    this.style.borderColor = '#28a745';
                                                }
                                            } else {
                                                if (errorEl) errorEl.textContent = '';
                                                this.style.borderColor = '';
                                            }
                                        });
                                    }

                                    if (phoneField) {
                                        phoneField.addEventListener('input', function() {
                                            const phone = this.value.trim();
                                            const errorEl = document.getElementById('phone_error_' + id);
                                            
                                            if (phone) {
                                                const digitsOnly = phone.replace(/\D/g, '');
                                                
                                                if (digitsOnly.length < 10 || digitsOnly.length > 15) {
                                                    showError('phone', 'رقم الهاتف يجب أن يكون بين 10 و 15 رقم');
                                                } else {
                                                    if (errorEl) errorEl.textContent = '';
                                                    this.style.borderColor = '#28a745';
                                                }
                                            } else {
                                                if (errorEl) errorEl.textContent = '';
                                                this.style.borderColor = '';
                                            }
                                        });
                                    }

                                    if (descFieldInput) {
                                        descFieldInput.addEventListener('input', function() {
                                            const description = this.value.trim();
                                            const errorEl = document.getElementById('description_error_' + id);
                                            
                                            if (description) {
                                                if (description.length < 10) {
                                                    showError('description', 'وصف المشروع يجب ألا يقل عن 10 حروف');
                                                } else if (description.length > 500) {
                                                    showError('description', 'وصف المشروع يجب ألا يزيد عن 500 حرف');
                                                } else {
                                                    if (errorEl) errorEl.textContent = '';
                                                    this.style.borderColor = '#28a745';
                                                }
                                            } else {
                                                if (errorEl) errorEl.textContent = '';
                                                this.style.borderColor = '';
                                            }
                                        });
                                    }

                                    // Form submission validation
                                    form.addEventListener('submit', function(e) {
                                        e.preventDefault();
                                        clearErrors();
                                        
                                        let isValid = true;
                                        
                                        if (!validateName()) isValid = false;
                                        if (!validateDomain()) isValid = false;
                                        if (!validateLogo()) isValid = false;
                                        if (!validatePhone()) isValid = false;
                                        if (!validateDescription()) isValid = false;
                                        
                                        if (isValid) {
                                            this.submit();
                                        } else {
                                            const firstError = form.querySelector('.error-message:not(:empty)');
                                            if (firstError) {
                                                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                            }
                                        }
                                    });
                                })();
                                </script>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.error-message {
    font-size: 0.875rem;
    min-height: 1.2rem;
}

.theme-input-style:focus {
    outline: none;
    border-color: #007bff;
}

.theme-input-style.is-invalid {
    border-color: #dc3545 !important;
}
</style>