$(document).ready(function () {
    var table = $('#all_ads-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: allAdsDataUrl, // هنمرر الرابط من Blade
            type: 'GET',
            data: function (d) {
                d.cat_id = $('#cat_id_filter').val();
                d.status = $('#status_filter').val();
                console.log('Filters:', { cat_id: d.cat_id, status: d.status });
            },
            error: function (xhr, error, thrown) {
                console.error('AJAX Error:', xhr, error, thrown);
            }
        },
        columns: adsTableColumns, // هنمرر الأعمدة من Blade
        language: { url: datatableLangUrl }
    });

    $('#filter_btn').on('click', function () {
        var catId = $('#cat_id_filter').val();
        var status = $('#status_filter').val();
        var newUrl = window.location.pathname;
        var params = [];

        if (catId) params.push('cat_id=' + catId);
        if (status) params.push('status=' + status);

        if (params.length > 0) newUrl += '?' + params.join('&');

        console.log('New URL:', newUrl);
        window.history.pushState({}, '', newUrl);
        table.ajax.reload();
    });

    $('#projectAddModal').on('show.bs.modal', function (event) {
        var selectedCatId = $('#cat_id_filter').val();
        var catsSelect = $('#cats_ids');

        if (selectedCatId && selectedCatId !== '') {
            var selectedOption = catsSelect.find('option[value="' + selectedCatId + '"]');
            if (selectedOption.length > 0) {
                catsSelect.empty();
                catsSelect.append(selectedOption.clone().prop('selected', true));
            }
        } else {
            catsSelect.empty();
            catsSelect.append('<option value="all">الكل</option>');
            catsData.forEach(cat => {
                catsSelect.append(`<option value="${cat.id}">${cat.name}</option>`);
            });
        }
    });

    $('#cat_id_filter').on('change', function () {
        let val = $(this).val();
        if (val) {
            $('#cats_ids').closest('.form-group').hide();
            if (!$('input[name="cat_id"][type="hidden"]').length) {
                $('<input>').attr({ type: 'hidden', name: 'cat_id', value: val }).appendTo('form');
            } else {
                $('input[name="cat_id"][type="hidden"]').val(val);
            }
        } else {
            $('#cats_ids').closest('.form-group').show();
            $('input[name="cat_id"][type="hidden"]').remove();
        }
    });
});

// ==================== دوال منفصلة ====================

function checkData(comp_id) {
    $.ajax({
        type: 'get',
        dataType: "json",
        url: checkDataUrl.replace(':id', comp_id),
        success: function (res) {
            const hasCats = Array.isArray(res.cats) && res.cats.length > 0;
            if (hasCats) {
                const selectCats = $('#cats_ids');
                $('#branches').show();
                selectCats.empty().append('<option value="all">الكل</option>');
                $.each(res.cats, function (index, cat) {
                    selectCats.append('<option value="' + cat.id + '">' + cat.name + '</option>');
                });
            } else {
                $('#branches').hide();
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
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
        url: checkDataUrl.replace(':id', comp_id),
        success: function (res) {
            if (res.cats && Array.isArray(res.cats) && res.cats.length > 0) {
                let select = $('#cats_ids_2');
                select.empty();
                select.append('<option value="all">الكل</option>');
                $.each(res.cats, function (index, cat) {
                    select.append('<option value="' + cat.id + '"' + (cat.isSelected ? ' selected' : '') + '>' + cat.name + '</option>');
                });
                $('#branches_2').show();
            }
            if (res.prods && Array.isArray(res.prods) && res.prods.length > 0) {
                let select = $('#product_ids_2');
                select.empty();
                select.append('<option value="all">الكل</option>');
                $.each(res.prods, function (index, prod) {
                    select.append('<option value="' + prod.id + '">' + prod.name + '</option>');
                });
            } else {
                $('#branches_2').hide();
            }
        }
    });
}

// ==================== دالة حساب الأيام ====================
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
        console.log(total_amount.value);
    } else {
        output.value = '';
    }
}

startInput?.addEventListener('change', calculateDateDiff);
endInput?.addEventListener('change', calculateDateDiff);
amount_per_day?.addEventListener('change', calculateDateDiff);

// ==================== التحقق من الفورم ====================
document.addEventListener('DOMContentLoaded', function () {
    const showError = (input, msg) => {
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
    };

    const clearError = (input) => {
        const group = input.closest('.form-group') || input.parentElement;
        const feedback = group.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.textContent = '';
            feedback.style.display = 'none';
        }
        input.classList.remove('is-invalid');
    };

    const setupCampaignValidation = (form) => {
        if (!form) return;
        const fields = {
            name: form.querySelector('[name="name"]'),
            start_date: form.querySelector('[name="start_date"]'),
            end_date: form.querySelector('[name="end_date"]'),
            amount_per_day: form.querySelector('[name="amount_per_day"]'),
            phone: form.querySelector('[name="phone"]'),
            image: form.querySelector('[name="image"]')
        };

        const validateName = () => {
            const val = fields.name.value.trim();
            if (!val) { showError(fields.name, 'اسم الحملة مطلوب.'); return false; }
            if (val.length > 255) { showError(fields.name, 'اسم الحملة لا يزيد عن 255 حرفًا.'); return false; }
            clearError(fields.name); return true;
        };
        const validateDates = () => {
            const start = fields.start_date.value;
            const end = fields.end_date.value;
            if (!start) { showError(fields.start_date, 'تاريخ البدء مطلوب.'); return false; }
            if (!end) { showError(fields.end_date, 'تاريخ النهاية مطلوب.'); return false; }
            if (end < start) { showError(fields.end_date, 'تاريخ النهاية يجب أن يكون بعد تاريخ البدء.'); return false; }
            clearError(fields.start_date);
            clearError(fields.end_date);
            return true;
        };
        const validateAmount = () => {
            const val = parseFloat(fields.amount_per_day.value);
            if (!fields.amount_per_day.value) { showError(fields.amount_per_day, 'قيمة الإعلان لليوم مطلوبة.'); return false; }
            if (isNaN(val) || val <= 0) { showError(fields.amount_per_day, 'قيمة الإعلان يجب أن تكون رقم صحيح أكبر من صفر.'); return false; }
            clearError(fields.amount_per_day); return true;
        };
        const validatePhone = () => {
            const num = fields.phone.value.trim();
            if (!num) { clearError(fields.phone); return true; }
            if (!/^\d+$/.test(num)) { showError(fields.phone, 'رقم الهاتف يجب أن يكون أرقام فقط.'); return false; }
            clearError(fields.phone); return true;
        };
        const validateFile = () => {
            if (!fields.image?.files[0]) { clearError(fields.image); return true; }
            const file = fields.image.files[0];
            const allowed = ['image/jpeg','image/png','image/jpg','image/gif','video/mp4','application/pdf'];
            if (!allowed.includes(file.type)) { showError(fields.image, 'الملف يجب أن يكون صورة أو فيديو أو PDF.'); return false; }
            if (file.size > 20 * 1024 * 1024) { showError(fields.image, 'حجم الملف لا يزيد عن 20 ميجابايت.'); return false; }
            clearError(fields.image); return true;
        };

        fields.name?.addEventListener('input', validateName);
        fields.start_date?.addEventListener('change', validateDates);
        fields.end_date?.addEventListener('change', validateDates);
        fields.amount_per_day?.addEventListener('input', validateAmount);
        fields.phone?.addEventListener('input', validatePhone);
        fields.image?.addEventListener('change', validateFile);

        form.addEventListener('submit', e => {
            let valid = true;
            [validateName, validateDates, validateAmount, validatePhone, validateFile].forEach(fn => { if (!fn()) valid = false; });
            if (!valid) e.preventDefault();
        });
    };

    setupCampaignValidation(document.querySelector('form'));
});

function startNow(id) {
    if (!confirm('هل أنت متأكد من بدء الحملة الآن؟')) return;
    fetch(`/ads/start-now/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(err => console.error(err));
}
