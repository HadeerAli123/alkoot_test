// // public/assets/js/ads-validation.js
// // يدعم فورم الإضافة + التعديل في ملف واحد

// class AdsValidator {
//     constructor(form) {
//         if (!form) return;
//         this.form = form;
//         this.fields = {};
//         this.submitBtn = form.querySelector('button[type="submit"]');
//         this.isEditMode = form.id === 'edit_ads';
//         this.init();
//     }

//     init() {
//         this.cacheFields();
//         this.bindEvents();
//         this.calculateDaysAndTotal();           // مهم للـ edit
//     }

//     cacheFields() {
//         this.fields = {
//             name           : this.form.querySelector('#name'),
//             start_date     : this.form.querySelector('#start_date'),
//             end_date       : this.form.querySelector('#end_date'),
//             amount_per_day : this.form.querySelector('#amount_per_day'),
//             number_days    : this.form.querySelector('#number_days'),
//             total_amount   : this.form.querySelector('#total_amount'),
//             cats_ids       : this.form.querySelector('#cats_ids'),
//             phone          : this.form.querySelector('input[name="phone"]'), // مهم ← بدون #
//         };
//     }

//     showError(input, msg) {
//         if (!input) return;
//         let group = input.closest('.form-group') || input.parentElement;
//         let feedback = group.querySelector('.invalid-feedback');

//         if (!feedback) {
//             feedback = document.createElement('div');
//             feedback.className = 'invalid-feedback';
//             group.appendChild(feedback);
//         }

//         input.classList.add('is-invalid');
//         feedback.textContent = msg;
//         feedback.style.display = 'block';
//     }

//     clearError(input) {
//         if (!input) return;
//         input.classList.remove('is-invalid');
//         const feedback = (input.closest('.form-group') || input.parentElement)
//                             ?.querySelector('.invalid-feedback');
//         if (feedback) {
//             feedback.textContent = '';
//             feedback.style.display = 'none';
//         }
//     }

//     validateName() {
//         const v = (this.fields.name?.value || '').trim();
//         if (!v) {
//             this.showError(this.fields.name, 'اسم الحملة مطلوب');
//             return false;
//         }
//         this.clearError(this.fields.name);
//         return true;
//     }

//     validateDates() {
//         const s = this.fields.start_date;
//         const e = this.fields.end_date;

//         if (!s?.value) { this.showError(s, 'تاريخ البدء مطلوب'); return false; }
//         if (!e?.value) { this.showError(e, 'تاريخ النهاية مطلوب'); return false; }

//         const sd = new Date(s.value);
//         const ed = new Date(e.value);

//         if (ed < sd) {
//             this.showError(e, 'تاريخ النهاية يجب أن يكون بعد أو يساوي البداية');
//             return false;
//         }

//         this.clearError(s);
//         this.clearError(e);
//         return true;
//     }

//     validateAmount() {
//         const v = (this.fields.amount_per_day?.value || '').trim();
//         const n = parseFloat(v);
//         if (!v || isNaN(n) || n <= 0) {
//             this.showError(this.fields.amount_per_day, 'القيمة يجب أن تكون رقم موجب');
//             return false;
//         }
//         this.clearError(this.fields.amount_per_day);
//         return true;
//     }

//     validateBranches() {
//         if (!this.fields.cats_ids) return true;
//         if (this.fields.cats_ids.selectedOptions.length === 0) {
//             this.showError(this.fields.cats_ids, 'اختر فرع واحد على الأقل');
//             return false;
//         }
//         this.clearError(this.fields.cats_ids);
//         return true;
//     }

//     validatePhone() {
//         const p = this.fields.phone;
//         if (!p) return true;
//         const v = (p.value || '').trim();
//         if (!v) return true;
//         if (!/^\d{10,20}$/.test(v)) {
//             this.showError(p, 'رقم الهاتف غير صحيح (10–20 رقم)');
//             return false;
//         }
//         this.clearError(p);
//         return true;
//     }

//     calculateDaysAndTotal() {
//         const s = this.fields.start_date?.value;
//         const e = this.fields.end_date?.value;
//         const amt = parseFloat(this.fields.amount_per_day?.value) || 0;

//         let days = '';
//         let total = '';

//         if (s && e) {
//             const sd = new Date(s);
//             const ed = new Date(e);
//             if (!isNaN(sd) && !isNaN(ed) && ed >= sd) {
//                 const ms = ed - sd;
//                 days = Math.floor(ms / 86400000) + 1;
//                 total = (days * amt).toFixed(2);
//             }
//         }

//         if (this.fields.number_days)  this.fields.number_days.value  = days;
//         if (this.fields.total_amount) this.fields.total_amount.value = total;
//     }

//     bindEvents() {
//         const f = this.fields;

//         f.name?.addEventListener('input',           () => this.validateName());
//         f.amount_per_day?.addEventListener('input',  () => { this.validateAmount(); this.calculateDaysAndTotal(); });
//         f.start_date?.addEventListener('change',     () => { this.validateDates(); this.calculateDaysAndTotal(); });
//         f.end_date?.addEventListener('change',       () => { this.validateDates(); this.calculateDaysAndTotal(); });
//         f.cats_ids?.addEventListener('change',       () => this.validateBranches());
//         f.phone?.addEventListener('input',           () => this.validatePhone());

//         this.form.addEventListener('submit', async e => {
//             e.preventDefault();

//             let ok = true;
//             ok = this.validateName() && ok;
//             ok = this.validateDates() && ok;
//             ok = this.validateAmount() && ok;
//             ok = this.validateBranches() && ok;
//             ok = this.validatePhone() && ok;

//             if (!ok) {
//                 this.form.querySelector('.is-invalid')?.scrollIntoView({behavior: 'smooth', block: 'center'});
//                 return;
//             }

//             await this.submitAsync();
//         });
//     }

//     async submitAsync() {
//         if (!this.submitBtn) return;

//         const btn = this.submitBtn;
//         const orig = btn.innerHTML;
//         btn.disabled = true;
//         btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>جاري الحفظ...';

//         try {
//             const resp = await fetch(this.form.action, {
//                 method: 'POST',
//                 body: new FormData(this.form),
//                 headers: {
//                     'X-Requested-With': 'XMLHttpRequest',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
//                 }
//             });

//             let data;
//             try { data = await resp.json(); }
//             catch { data = { success: false, message: 'استجابة غير متوقعة' }; }

//             if (resp.ok && data.success) {
//                 toastr?.success(data.message || (this.isEditMode ? 'تم تعديل الإعلان بنجاح' : 'تم إضافة الإعلان بنجاح'))
//                    ?? alert('تم الحفظ بنجاح');

//            const modal = this.form.closest('.modal');
//                 if (modal) {
//                     if (typeof $ !== 'undefined' && $.fn.modal) {
//                         $(modal).modal('hide');
//                     } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal && bootstrap.Modal.getInstance) {
//                         const modalInstance = bootstrap.Modal.getInstance(modal);
//                         if (modalInstance) {
//                             modalInstance.hide();
//                         }
//                     } else {
//                         modal.classList.remove('show');
//                         modal.style.display = 'none';
//                         document.body.classList.remove('modal-open');
//                         const backdrop = document.querySelector('.modal-backdrop');
//                         if (backdrop) {
//                             backdrop.remove();
//                         }
//                     }
//                 }

//                 setTimeout(() => {
//                     if (result.redirect) {
//                         window.location.href = result.redirect;
//                     } else {
//                         window.location.reload();
//                     }
//                 });

//             } else {
//                 if (data.errors) {
//                     Object.entries(data.errors).forEach(([k, msgs]) => {
//                         const input = this.form.querySelector(`[name="${k}"], #${k}`);
//                         if (input && msgs?.length) this.showError(input, msgs[0]);
//                     });
//                     this.form.querySelector('.is-invalid')?.scrollIntoView({behavior: 'smooth', block: 'center'});
//                 } else {
//                     toastr?.error(data.message || 'حدث خطأ أثناء الحفظ') ?? alert('حدث خطأ');
//                 }
//             }
//         } catch (err) {
//             console.error(err);
//             toastr?.error('فشل الاتصال بالخادم') ?? alert('فشل الاتصال');
//         } finally {
//             btn.disabled = false;
//             btn.innerHTML = orig;
//         }
//     }
// }

// // ─── تشغيل على كلا الفورمين ───
// document.addEventListener('DOMContentLoaded', () => {
//     document.querySelectorAll('#add_ads, #edit_ads').forEach(form => {
//         if (form) new AdsValidator(form);
//     });
// });