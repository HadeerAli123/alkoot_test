// public/assets/js/branch-validation.js

class BranchValidator {
    constructor(form) {
        this.form = form;
        this.fields = {};
        this.init();
    }

    init() {
        this.setupFields();
        this.bindEvents();
        this.setupFlagUpdates();
    }

    setupFields() {
        this.fields = {
            name: this.form.querySelector('[name="name"]'),
            whatsapp_code: this.form.querySelector('[name="whatsapp_country_code"]'),
            whatsapp: this.form.querySelector('[name="whatsapp"]'),
            phone_code: this.form.querySelector('[name="phone_country_code"]'),
            phone: this.form.querySelector('[name="phone"]'),
            instagram: this.form.querySelector('[name="instagram"]'),
            google_Map: this.form.querySelector('[name="google_Map"]'),
            google_Map_2: this.form.querySelector('[name="google_Map_2"]'),
            tiktok: this.form.querySelector('[name="tiktok"]'),
            description: this.form.querySelector('[name="description"]'),
            menu: this.form.querySelector('[name="menu"]'),
            whatsapp_flag: this.form.querySelector('[id*="whatsapp-flag-img"]'),
            phone_flag: this.form.querySelector('[id*="phone-flag-img"]')
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

    updateFlag(select, img) {
        if (!select || !img) return;
        const option = select.options[select.selectedIndex];
        const src = option.getAttribute('data-flag-src');
        if (src) img.src = src;
    }

    // Validation للأكواد الدولية المسموح بها فقط
    isValidCountryCode(code) {
        const validCodes = ['+966', '+20', '+971', '+965', '+964', '+962', '+963', '+968', '+973', '+974'];
        return validCodes.includes(code);
    }

    // Validation لصيغة الأرقام حسب كود الدولة (مطابق تمامًا للـ Laravel)
    validatePhoneFormat(code, number) {
        if (!number) return true;
        const patterns = {
            '+966': /^5\d{8}$/,
            '+20':  /^1\d{9}$/,
            '+971': /^5\d{8}$/,
            '+965': /^[569]\d{7}$/,
            '+964': /^7\d{9}$/,
            '+962': /^7\d{8}$/,
            '+963': /^9\d{8}$/,
            '+968': /^9\d{7}$/,
            '+973': /^3\d{7}$/,
            '+974': /^3\d{7}$/
        };
        return patterns[code] ? patterns[code].test(number) : /^\d+$/.test(number);
    }

    validateName() {
        const val = this.fields.name?.value.trim();
        if (!val) { 
            this.showError(this.fields.name, 'اسم الفرع مطلوب.'); 
            return false; 
        }
        if (val.length > 255) { 
            this.showError(this.fields.name, 'اسم الفرع لا يزيد عن 255 حرفًا.'); 
            return false; 
        }
        this.clearError(this.fields.name); 
        return true;
    }

    validateWhatsapp() {
        const code = this.fields.whatsapp_code?.value;
        const num = this.fields.whatsapp?.value.trim();
        
        // required_with validation
        if (num && !code) { 
            this.showError(this.fields.whatsapp, 'كود دولة الواتساب مطلوب إذا أدخلت الرقم.'); 
            return false; 
        }
        if (code && !num) { 
            this.showError(this.fields.whatsapp, 'رقم الواتساب مطلوب إذا اخترت كود الدولة.'); 
            return false; 
        }
        
        // التحقق من صحة كود الدولة
        if (code && !this.isValidCountryCode(code)) {
            this.showError(this.fields.whatsapp_code, 'كود دولة الواتساب غير صالح.');
            return false;
        }
        
        if (num) {
            // numeric validation
            if (!/^\d+$/.test(num)) { 
                this.showError(this.fields.whatsapp, 'رقم الواتساب يجب أن يكون أرقامًا فقط.'); 
                return false; 
            }
            // digits_between:7,15 validation
            if (num.length < 7 || num.length > 15) { 
                this.showError(this.fields.whatsapp, 'رقم الواتساب يجب أن يكون بين 7 و15 رقمًا.'); 
                return false; 
            }
            // Country-specific format validation
            if (!this.validatePhoneFormat(code, num)) { 
                this.showError(this.fields.whatsapp, 'رقم الواتساب غير صالح لهذا الكود.'); 
                return false; 
            }
        }
        
        this.clearError(this.fields.whatsapp);
        this.clearError(this.fields.whatsapp_code);
        return true;
    }

    validatePhone() {
        const code = this.fields.phone_code?.value;
        const num = this.fields.phone?.value.trim();
        
        // required_with validation
        if (num && !code) { 
            this.showError(this.fields.phone, 'كود دولة التواصل مطلوب إذا أدخلت الرقم.'); 
            return false; 
        }
        if (code && !num) { 
            this.showError(this.fields.phone, 'رقم التواصل مطلوب إذا اخترت كود الدولة.'); 
            return false; 
        }
        
        // التحقق من صحة كود الدولة
        if (code && !this.isValidCountryCode(code)) {
            this.showError(this.fields.phone_code, 'كود دولة التواصل غير صالح.');
            return false;
        }
        
        if (num) {
            // numeric validation
            if (!/^\d+$/.test(num)) { 
                this.showError(this.fields.phone, 'رقم التواصل يجب أن يكون أرقامًا فقط.'); 
                return false; 
            }
            // digits_between:7,15 validation
            if (num.length < 7 || num.length > 15) { 
                this.showError(this.fields.phone, 'رقم التواصل يجب أن يكون بين 7 و15 رقمًا.'); 
                return false; 
            }
            // Country-specific format validation
            if (!this.validatePhoneFormat(code, num)) { 
                this.showError(this.fields.phone, 'رقم التواصل غير صالح لهذا الكود.'); 
                return false; 
            }
        }
        
        this.clearError(this.fields.phone);
        this.clearError(this.fields.phone_code);
        return true;
    }

    // Validation للـ Instagram (مطابق للـ regex في Laravel)
    validateInstagram() {
        const val = this.fields.instagram?.value.trim();
        if (!val) { 
            this.clearError(this.fields.instagram); 
            return true; 
        }
        
        const instagramRegex = /^https?:\/\/(www\.)?instagram\.com\/.+$/;
        if (!instagramRegex.test(val)) { 
            this.showError(this.fields.instagram, 'رابط إنستجرام يجب أن يكون رابطًا صالحًا لموقع Instagram.'); 
            return false; 
        }
        
        this.clearError(this.fields.instagram); 
        return true;
    }

    // Validation للـ Google Maps (مطابق للـ regex في Laravel)
    validateGoogleMap(field, fieldName) {
        const val = field?.value.trim();
        if (!val) { 
            this.clearError(field); 
            return true; 
        }
        
        const googleMapRegex = /^https?:\/\/(www\.)?(google\.com\/maps|goo\.gl\/maps|maps\.app\.goo\.gl)\/.+$/;
        if (!googleMapRegex.test(val)) { 
            this.showError(field, `${fieldName} يجب أن يكون رابطًا صالحًا لخرائط Google.`); 
            return false; 
        }
        
        this.clearError(field); 
        return true;
    }

    // Validation للـ TikTok (مطابق للـ regex في Laravel)
    validateTiktok() {
        const val = this.fields.tiktok?.value.trim();
        if (!val) { 
            this.clearError(this.fields.tiktok); 
            return true; 
        }
        
        const tiktokRegex = /^https?:\/\/(www\.)?(tiktok\.com|vm\.tiktok\.com)\/.+$/;
        if (!tiktokRegex.test(val)) { 
            this.showError(this.fields.tiktok, 'رابط التيك توك يجب أن يكون رابطًا صالحًا لموقع tiktok.'); 
            return false; 
        }
        
        this.clearError(this.fields.tiktok); 
        return true;
    }

    validateDescription() {
        const val = this.fields.description?.value || '';
        if (val.length > 1000) { 
            this.showError(this.fields.description, 'الوصف لا يزيد عن 1000 حرف.'); 
            return false; 
        }
        this.clearError(this.fields.description); 
        return true;
    }

    validateMenu() {
        const file = this.fields.menu?.files[0];
        if (!file) { 
            this.clearError(this.fields.menu); 
            return true; 
        }
        if (file.type !== 'application/pdf') { 
            this.showError(this.fields.menu, 'الملف يجب أن يكون PDF.'); 
            return false; 
        }
        if (file.size > 5 * 1024 * 1024) { 
            this.showError(this.fields.menu, 'حجم الملف لا يزيد عن 5 ميجابايت.'); 
            return false; 
        }
        this.clearError(this.fields.menu); 
        return true;
    }

    bindEvents() {
        this.fields.name?.addEventListener('input', () => this.validateName());
        
        this.fields.whatsapp?.addEventListener('input', () => this.validateWhatsapp());
        this.fields.whatsapp_code?.addEventListener('change', () => {
            this.updateFlag(this.fields.whatsapp_code, this.fields.whatsapp_flag);
            this.validateWhatsapp();
        });
        
        this.fields.phone?.addEventListener('input', () => this.validatePhone());
        this.fields.phone_code?.addEventListener('change', () => {
            this.updateFlag(this.fields.phone_code, this.fields.phone_flag);
            this.validatePhone();
        });
        
        this.fields.instagram?.addEventListener('input', () => this.validateInstagram());
        this.fields.google_Map?.addEventListener('input', () => this.validateGoogleMap(this.fields.google_Map, 'رابط خرائط Google الأول'));
        this.fields.google_Map_2?.addEventListener('input', () => this.validateGoogleMap(this.fields.google_Map_2, 'رابط خرائط Google الثاني'));
        this.fields.tiktok?.addEventListener('input', () => this.validateTiktok());
        this.fields.description?.addEventListener('input', () => this.validateDescription());
        this.fields.menu?.addEventListener('change', () => this.validateMenu());

        this.form.addEventListener('submit', (e) => {
            let valid = true;
            
            // Validate all required fields
            const validations = [
                () => this.validateName(),
                () => this.validateWhatsapp(),
                () => this.validatePhone(),
                () => this.validateInstagram(),
                () => this.validateGoogleMap(this.fields.google_Map, 'رابط خرائط Google الأول'),
                () => this.validateGoogleMap(this.fields.google_Map_2, 'رابط خرائط Google الثاني'),
                () => this.validateTiktok(),
                () => this.validateDescription(),
                () => this.validateMenu()
            ];
            
            validations.forEach(fn => { 
                if (!fn()) valid = false; 
            });

            if (!valid) e.preventDefault();
        });
    }

    setupFlagUpdates() {
        if (this.fields.whatsapp_code && this.fields.whatsapp_flag) {
            this.updateFlag(this.fields.whatsapp_code, this.fields.whatsapp_flag);
        }
        if (this.fields.phone_code && this.fields.phone_flag) {
            this.updateFlag(this.fields.phone_code, this.fields.phone_flag);
        }
    }
}

// تفعيل الـ Validation عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function () {
    // نموذج الإضافة
    const addForm = document.getElementById('add-branch-form');
    if (addForm) {
        new BranchValidator(addForm);
        setupAjaxSubmit(addForm);
    }

    // نماذج التعديل (تُفتح ديناميكيًا)
    document.querySelectorAll('[id^="projectEditModal_"]').forEach(modal => {
        modal.addEventListener('shown.bs.modal', () => {
            const form = modal.querySelector('form');
            if (form && !form.dataset.validatorInitialized) {
                new BranchValidator(form);
                setupAjaxSubmit(form);
                form.dataset.validatorInitialized = 'true';
            }
        });
    });
});

// دالة AJAX منفصلة (يمكن نقلها لملف آخر لاحقًا)
function setupAjaxSubmit(form) {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> جاري الحفظ...';

        try {
            const response = await fetch(form.action, {
                method: form.method,
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            const result = await response.json();

            if (response.ok && result.success) {
                $(form.closest('.modal')).modal('hide');
                toastr.success(result.message || 'تم الحفظ بنجاح');
                window.location.reload();
            } else {
                if (result.errors) {
                    Object.keys(result.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            const validator = input.closest('form').validator;
                            if (validator && validator.showError) {
                                validator.showError(input, result.errors[field][0]);
                            }
                        }
                    });
                } else {
                    toastr.error(result.message || 'فشل في الحفظ');
                }
            }
        } catch (error) {
            toastr.error('حدث خطأ في الاتصال');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
}