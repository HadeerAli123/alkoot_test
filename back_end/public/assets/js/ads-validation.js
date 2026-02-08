// public/assets/js/ads-validation.js

class AdsValidator {
 constructor(form) {
    if (form.dataset.validatorInitialized === 'true') return;

    this.form = form;
    this.fields = {};
    this.isEditMode = form.id === 'edit_ads' || form.dataset.mode === 'edit';

    // ✅ علّمي الفورم إنه اتعمله init
    form.dataset.validatorInitialized = 'true';

    this.init();
}


    init() {
        this.setupFields();
        this.bindEvents();
        this.calculateDaysAndTotal();
    }

    setupFields() {
        this.fields = {
            name: this.form.querySelector('#name'),
            start_date: this.form.querySelector('#start_date'),
            end_date: this.form.querySelector('#end_date'),
            amount_per_day: this.form.querySelector('#amount_per_day'),
            number_days: this.form.querySelector('#number_days'),
            total_amount: this.form.querySelector('#total_amount'),
            cats_ids: this.form.querySelector('#cats_ids'),
            phone: this.form.querySelector('#phone'),
        };
    }

    showError(input, msg) {
        if (!input) return;

        const group = input.closest('.form-group') || input.parentElement;
        let feedback = group.querySelector('.invalid-feedback');

        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            group.appendChild(feedback);
        }

        input.classList.add('is-invalid');
        feedback.textContent = msg;
        feedback.style.display = 'block';
    }

    clearError(input) {
        if (!input) return;

        const group = input.closest('.form-group') || input.parentElement;
        const feedback = group.querySelector('.invalid-feedback');

        if (feedback) {
            feedback.textContent = '';
            feedback.style.display = 'none';
        }
        input.classList.remove('is-invalid');
    }

    validateName() {
        const val = this.fields.name?.value.trim();
        if (!val) {
            this.showError(this.fields.name, 'اسم الحملة مطلوب');
            return false;
        }
        this.clearError(this.fields.name);
        return true;
    }

    validateDates() {
        const start = this.fields.start_date;
        const end = this.fields.end_date;

        if (!start.value) {
            this.showError(start, 'تاريخ البدء مطلوب');
            return false;
        }
        if (!end.value) {
            this.showError(end, 'تاريخ النهاية مطلوب');
            return false;
        }

        const startDate = new Date(start.value);
        const endDate = new Date(end.value);

        if (endDate < startDate) {
            this.showError(end, 'تاريخ النهاية يجب أن يكون بعد تاريخ البدء');
            return false;
        }

        this.clearError(start);
        this.clearError(end);
        return true;
    }

    validateAmountPerDay() {
        const val = this.fields.amount_per_day?.value.trim();
        const num = parseFloat(val);

        if (!val || isNaN(num) || num <= 0) {
            this.showError(this.fields.amount_per_day, 'قيمة الإعلان يجب أن تكون أكبر من صفر');
            return false;
        }
        this.clearError(this.fields.amount_per_day);
        return true;
    }

    validateBranches() {
        if (!this.fields.cats_ids) return true;

        if (!this.fields.cats_ids.value) {
            this.showError(this.fields.cats_ids, 'يجب اختيار فرع واحد على الأقل');
            return false;
        }
        this.clearError(this.fields.cats_ids);
        return true;
    }

    validatePhone() {
        const phone = this.fields.phone;
        if (!phone) return true;

        const val = phone.value.trim();
        if (!val) return true;

        if (val.length < 10 || val.length > 20 || !/^\d+$/.test(val)) {
            this.showError(phone, 'رقم الهاتف غير صحيح');
            return false;
        }
        this.clearError(phone);
        return true;
    }

    calculateDaysAndTotal() {
        const start = this.fields.start_date?.value;
        const end = this.fields.end_date?.value;
        const amount = parseFloat(this.fields.amount_per_day?.value) || 0;

        if (!start || !end) {
            this.fields.number_days.value = '';
            this.fields.total_amount.value = '';
            return;
        }

        const startDate = new Date(start);
        const endDate = new Date(end);
        const diffTime = endDate - startDate;
        const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

        if (days > 0) {
            this.fields.number_days.value = days;
            this.fields.total_amount.value = (days * amount).toFixed(2);
        } else {
            this.fields.number_days.value = '';
            this.fields.total_amount.value = '';
        }
    }

    bindEvents() {
        this.fields.name?.addEventListener('input', () => this.validateName());
        this.fields.amount_per_day?.addEventListener('input', () => {
            this.validateAmountPerDay();
            this.calculateDaysAndTotal();
        });
        this.fields.start_date?.addEventListener('change', () => {
            this.validateDates();
            this.calculateDaysAndTotal();
        });
        this.fields.end_date?.addEventListener('change', () => {
            this.validateDates();
            this.calculateDaysAndTotal();
        });
        this.fields.cats_ids?.addEventListener('change', () => this.validateBranches());
        this.fields.phone?.addEventListener('input', () => this.validatePhone());

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();

            let valid = true;

            if (!this.validateName()) valid = false;
            if (!this.validateDates()) valid = false;
            if (!this.validateAmountPerDay()) valid = false;
            if (!this.validateBranches()) valid = false;
            if (!this.validatePhone()) valid = false;

            if (!valid) {
                const firstInvalid = this.form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            this.submitForm();
        });
    }

    async submitForm() {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (!submitBtn) return;

        const originalText = submitBtn.innerHTML;
        const loadingText = this.isEditMode ? 'جاري التحديث...' : 'جاري الحفظ...';
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${loadingText}`;

        try {
            const response = await fetch(this.form.action, {
                method: this.form.method || 'POST',
                body: new FormData(this.form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });

            const result = await response.json();

          if (response.ok && result.success) {

    if (typeof toastr !== 'undefined') {
        toastr.success(successMsg);
    }

    if (result.redirect) {
        window.location.href = result.redirect;
        return;
    }

    const modal = this.form.closest('.modal');
    if (modal) {
        $(modal).modal('hide');
    }

    if (window.adsTable) {
        adsTable.ajax.reload(null, false);
    }


            } else {
                if (result.errors) {
                    Object.keys(result.errors).forEach(key => {
                        const input = this.form.querySelector(`[name="${key}"], #${key}`);
                        if (input && result.errors[key]?.[0]) {
                            this.showError(input, result.errors[key][0]);
                        }
                    });

                    const firstInvalid = this.form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    const errorMsg = result.message || 'حدث خطأ أثناء الحفظ';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert(errorMsg);
                    }
                }

                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        } catch (err) {
            console.error('Submit Error:', err);
            
            if (typeof toastr !== 'undefined') {
                toastr.error('فشل الاتصال بالخادم');
            } else {
                alert('فشل الاتصال بالخادم');
            }

            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }
}

// تهيئة النماذج عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function () {
    // نموذج الإضافة
    const addForm = document.getElementById('add_ads');
    if (addForm) {
        new AdsValidator(addForm);
    }

    // نموذج التعديل
    const editForm = document.getElementById('edit_ads');
    if (editForm) {
        new AdsValidator(editForm);
    }
});

// تهيئة النماذج عند فتح المودال (في حالة التحميل الديناميكي)
if (typeof $ !== 'undefined') {
    $(document).on('shown.bs.modal', '.modal', function () {
        const form = this.querySelector('#add_ads, #edit_ads');
        if (form && !form.dataset.validatorInitialized) {
            new AdsValidator(form);
            form.dataset.validatorInitialized = 'true';
        }
    });
} else if (typeof bootstrap !== 'undefined') {
    document.addEventListener('shown.bs.modal', function (e) {
        const modal = e.target;
        const form = modal.querySelector('#add_ads, #edit_ads');
        if (form && !form.dataset.validatorInitialized) {
            new AdsValidator(form);
            form.dataset.validatorInitialized = 'true';
        }
    });

    
}