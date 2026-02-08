<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

<style>
.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: none;
}
.error-message.show {
    display: block;
}
.form-control.is-invalid, .theme-input-style.is-invalid {
    border-color: #dc3545;
}
.form-control.is-valid, .theme-input-style.is-valid {
    border-color: #28a745;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <form id="companyForm" action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="contact-account-setting media-body d-flex justify-content-center align-items-center"
                        style="background: #eeeff2; border-radius: 12px; padding: 20px 0 15px 0; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <h4 class="mb-0"
                            style="font-weight: bold; letter-spacing: 1px; text-align: center; padding-right: 10px;">
                            إضافة مشروع جديد
                        </h4>
                    </div>

                    <div class="row">
                        <!-- اسم المشروع -->
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="vendor_name" class="mb-2 black bold">اسم المشروع <span class="text-danger">*</span></label>
                                <input type="text" class="theme-input-style" id="vendor_name" name="name"
                                    placeholder="اكتب اسم المشروع هنا" value="{{ old('name') }}">
                                <span class="error-message" id="name-error"></span>
                                @error('name')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- النطاق -->
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="domain" class="mb-2 black bold">النطاق (domain)</label>
                                <select class="form-control mb-5" id="domain" name="domain">
                                    @foreach($domain as $d)
                                    <option value="{{ $d->id }}" {{ old('domain') == $d->id ? 'selected' : '' }}>{{ $d->url }}</option>
                                    @endforeach
                                </select>
                                <span class="error-message" id="domain-error"></span>
                            </div>
                        </div>

                        <!-- اللوجو -->
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="vendor_logo" class="mb-2 black bold d-block">اللوجو</label>
                                <input type="file" class="form-control mb-5" id="vendor_logo" name="logo" accept="image/png,image/jpg,image/jpeg,image/svg+xml,image/webp">
                                <span class="error-message" id="logo-error"></span>
                                @error('logo')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- رقم الهاتف -->
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="vendor_contact" class="mb-2 black bold">معلومات التواصل</label>
                                <input type="text" class="theme-input-style" id="vendor_contact" name="phone"
                                    placeholder="رقم الهاتف" value="{{ old('phone') }}">
                                <span class="error-message" id="phone-error"></span>
                                @error('phone')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror    
                            </div>
                        </div>

                        <!-- الثيم -->
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label style="cursor: pointer; display: inline-flex; align-items: center; margin-right: 12px;">
                                    <input type="radio" name="theme_id" value="4" style="display:none;" checked>
                                </label>
                            </div>
                        </div>

                        <!-- الوصف -->
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label for="vendor_desc" class="mb-2 black bold">الوصف</label>
                                <textarea class="theme-input-style" id="vendor_desc" name="description"
                                    placeholder="نبذة عن المشروع">{{ old('description') }}</textarea>
                                <span class="error-message" id="description-error"></span>
                                @error('description')
                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                @enderror    
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div class="col-lg-6" style="display:none;">
                            <div class="form-group mb-4 d-flex align-items-center">
                                <input type="checkbox" id="has_branch" name="has_branch" value="1"
                                    style="margin-left: 8px;" checked>
                                <label for="has_branch" class="mb-0 black bold">هل يوجد فروع</label>
                            </div>
                        </div>
                        <div class="col-lg-6" style="display:none;">
                            <div class="form-group mb-4 d-flex align-items-center">
                                <input type="checkbox" id="has_product" name="has_product" value="1"
                                    style="margin-left: 8px;">
                                <label for="has_product" class="mb-0 black bold">هل يوجد منتجات</label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-center pt-3" style="padding-bottom: 10px;">
                            <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                            <button type="reset" class="btn btn-secondary">إلغاء</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('companyForm');
    
    // Validation rules based on backend
    const validationRules = {
        name: {
            required: true,
            minLength: 1,
            message: 'الاسم مطلوب'
        },
        logo: {
            required: false,
            fileTypes: ['image/png', 'image/jpg', 'image/jpeg', 'image/svg+xml', 'image/webp'],
            maxSize: 2048, // KB
            messages: {
                fileType: 'صيغة الصورة غير مدعومة (فقط: png, jpg, jpeg, svg, webp)',
                maxSize: 'حجم الصورة يجب ألا يتجاوز 2 ميجا'
            }
        },
        phone: {
            required: false,
            pattern: /^\d{10,15}$/,
            message: 'رقم الهاتف يجب أن يكون بين 10 و 15 رقم'
        },
        description: {
            required: false,
            minLength: 10,
            maxLength: 500,
            messages: {
                minLength: 'وصف المشروع يجب ألا يقل عن 10 حروف',
                maxLength: 'وصف المشروع يجب ألا يزيد عن 500 حرف'
            }
        }
    };

    // Validation functions
    function showError(fieldName, message) {
        const errorElement = document.getElementById(`${fieldName}-error`);
        const inputElement = document.querySelector(`[name="${fieldName}"]`);
        
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }
        if (inputElement) {
            inputElement.classList.add('is-invalid');
            inputElement.classList.remove('is-valid');
        }
    }

    function clearError(fieldName) {
        const errorElement = document.getElementById(`${fieldName}-error`);
        const inputElement = document.querySelector(`[name="${fieldName}"]`);
        
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.classList.remove('show');
        }
        if (inputElement) {
            inputElement.classList.remove('is-invalid');
            inputElement.classList.add('is-valid');
        }
    }

    function validateField(fieldName, value, file = null) {
        const rules = validationRules[fieldName];
        if (!rules) return true;

        // Required validation
        if (rules.required && (!value || value.trim() === '')) {
            showError(fieldName, rules.message);
            return false;
        }

        // If field is empty and not required, clear error and return true
        if (!rules.required && (!value || value.trim() === '')) {
            clearError(fieldName);
            return true;
        }

        // File validation
        if (fieldName === 'logo' && file) {
            // Check file type
            if (rules.fileTypes && !rules.fileTypes.includes(file.type)) {
                showError(fieldName, rules.messages.fileType);
                return false;
            }
            // Check file size (convert to KB)
            if (rules.maxSize && (file.size / 1024) > rules.maxSize) {
                showError(fieldName, rules.messages.maxSize);
                return false;
            }
        }

        // Pattern validation (for phone)
        if (rules.pattern && value && !rules.pattern.test(value)) {
            showError(fieldName, rules.message);
            return false;
        }

        // Min length validation
        if (rules.minLength && value.length < rules.minLength) {
            showError(fieldName, rules.messages?.minLength || rules.message);
            return false;
        }

        // Max length validation
        if (rules.maxLength && value.length > rules.maxLength) {
            showError(fieldName, rules.messages?.maxLength || rules.message);
            return false;
        }

        clearError(fieldName);
        return true;
    }

    // Real-time validation
    const nameInput = document.getElementById('vendor_name');
    const logoInput = document.getElementById('vendor_logo');
    const phoneInput = document.getElementById('vendor_contact');
    const descInput = document.getElementById('vendor_desc');

    if (nameInput) {
        nameInput.addEventListener('input', function() {
            validateField('name', this.value);
        });
        nameInput.addEventListener('blur', function() {
            validateField('name', this.value);
        });
    }

    if (logoInput) {
        logoInput.addEventListener('change', function() {
            const file = this.files[0];
            validateField('logo', file ? file.name : '', file);
        });
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            validateField('phone', this.value);
        });
        phoneInput.addEventListener('blur', function() {
            validateField('phone', this.value);
        });
    }

    if (descInput) {
        descInput.addEventListener('input', function() {
            validateField('description', this.value);
        });
        descInput.addEventListener('blur', function() {
            validateField('description', this.value);
        });
    }

    // Form submission validation
    form.addEventListener('submit', function(e) {
        let isValid = true;

        // Validate name (required)
        if (!validateField('name', nameInput.value)) {
            isValid = false;
        }

        // Validate logo (if selected)
        if (logoInput.files.length > 0) {
            if (!validateField('logo', logoInput.files[0].name, logoInput.files[0])) {
                isValid = false;
            }
        }

        // Validate phone (optional but must be valid if provided)
        if (phoneInput.value) {
            if (!validateField('phone', phoneInput.value)) {
                isValid = false;
            }
        }

        // Validate description (optional but must be valid if provided)
        if (descInput.value) {
            if (!validateField('description', descInput.value)) {
                isValid = false;
            }
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            e.preventDefault();
            
            // Scroll to first error
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    // Original JavaScript for branches and products
    const hasBranch = document.getElementById('has_branch');
    const hasProduct = document.getElementById('has_product');
    const branchesSection = document.getElementById('branches-section');
    const productsSection = document.getElementById('products-section');
    const addBranchBtn = document.getElementById('add-branch-row');
    const addProductBtn = document.getElementById('add-product-row');
    const branchesRows = document.getElementById('branches-rows');
    const productsRows = document.getElementById('products-rows');

    let branchIndex = branchesRows ? branchesRows.querySelectorAll('.branch-row').length || 1 : 1;
    let productIndex = productsRows ? productsRows.querySelectorAll('.product-row').length || 1 : 1;

    // Show/hide sections initially
    if (branchesSection) branchesSection.style.display = hasBranch.checked ? 'block' : 'none';
    if (productsSection) productsSection.style.display = hasProduct.checked ? 'block' : 'none';

    // Update numbering badges
    function updateBranchNumbers() {
        if (branchesRows) {
            branchesRows.querySelectorAll('.branch-number').forEach((badge, idx) => {
                badge.textContent = idx + 1;
            });
        }
    }

    function updateProductNumbers() {
        if (productsRows) {
            productsRows.querySelectorAll('.product-number').forEach((badge, idx) => {
                badge.textContent = idx + 1;
            });
        }
    }

    if (hasBranch) {
        hasBranch.addEventListener('change', () => {
            if (branchesSection) branchesSection.style.display = hasBranch.checked ? 'block' : 'none';
        });
    }

    if (hasProduct) {
        hasProduct.addEventListener('change', () => {
            if (productsSection) productsSection.style.display = hasProduct.checked ? 'block' : 'none';
        });
    }

    if (addBranchBtn) {
        addBranchBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.classList.add('row', 'branch-row');
            row.innerHTML = `
                <div class="col-md-12 mb-3 d-flex align-items-center gap-2">
                    <span class="badge bg-primary text-white branch-number">${branchIndex + 1}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" id="branch_name_${branchIndex}" name="branches[${branchIndex}][name]" placeholder="أدخل اسم الفرع">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="number" class="form-control" name="branches[${branchIndex}][whatsapp]" placeholder="أدخل رقم الواتساب ">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" name="branches[${branchIndex}][phone]" placeholder="أدخل رقم التواصل ">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" name="branches[${branchIndex}][instagram]" placeholder="أدخل رابط الانستجرام ">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" name="branches[${branchIndex}][google_Map]" placeholder="أدخل رابط جوجل ماب " >
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control" name="branches[${branchIndex}][google_Map_2]" placeholder="أدخل رابط جوجل ماب 2" >
                </div>
                <div class="col-md-6 mb-3" style="display: none;">
                    <label class="mb-2 black bold"> قائمة الطعام (PDF)</label>
                    <input type="file" class="form-control" name="branches[${branchIndex}][menu]" accept="application/pdf">
                </div>
                <div class="col-md-11 mb-3">
                    <label for="branch_description_${branchIndex}" class="form-label">الوصف</label>
                    <textarea class="theme-input-style" id="branch_description_${branchIndex}" name="branches[${branchIndex}][description]" rows="4" placeholder="وصف الفرع"></textarea>
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="button" class="btn bg-danger remove-branch" title="حذف الفرع"><i class="fa fa-trash"></i></button>
                </div>
            `;
            branchesRows.appendChild(row);
            branchIndex++;
            updateBranchNumbers();
        });
    }

    if (addProductBtn) {
        addProductBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.classList.add('row', 'product-row');
            row.innerHTML = `
                <div class="col-md-12">
                    <span class="badge bg-primary text-white product-number">${productIndex + 1}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="products[${productIndex}][name]" class="form-control" placeholder="اسم المنتج">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="products[${productIndex}][location]" class="form-control" placeholder="الموقع">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">الصور</label>
                    <input type="file" name="products[${productIndex}][images][]" class="form-control" multiple>
                    <small class="text-muted">يمكنك رفع أكثر من صورة</small>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="products[${productIndex}][whatsapp]" class="form-control" placeholder="رقم واتساب">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="text" name="products[${productIndex}][phone]" class="form-control" placeholder="رقم للتواصل">
                </div>
                <div class="col-md-6 mb-3">
                    <input type="url" name="products[${productIndex}][instagram]" class="form-control" placeholder="رابط إنستجرام">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">الوصف الكامل</label>
                    <textarea name="products[${productIndex}][description]" class="theme-input-style" rows="4" placeholder="الوصف الكامل"></textarea>
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="button" class="btn bg-danger remove-product" title="حذف المنتج"><i class="fa fa-trash"></i></button>
                </div>
            `;
            productsRows.appendChild(row);
            productIndex++;
            updateProductNumbers();
        });
    }

    // Remove branch row
    if (branchesRows) {
        branchesRows.addEventListener('click', (e) => {
            if (e.target.closest('.remove-branch')) {
                e.target.closest('.branch-row').remove();
                updateBranchNumbers();
            }
        });
    }

    // Remove product row
    if (productsRows) {
        productsRows.addEventListener('click', (e) => {
            if (e.target.closest('.remove-product')) {
                e.target.closest('.product-row').remove();
                updateProductNumbers();
            }
        });
    }

    // Reset button behavior
    form.addEventListener("reset", function(e) {
        history.back();
    });
});
</script>