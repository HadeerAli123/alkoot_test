
    // ========== Edit Forms Validation ==========
    document.querySelectorAll('form[id^="edit-branch-form-"]').forEach(form => {
        const formId = form.id.split('-').pop();

        // العناصر
        const whatsappSelect = form.querySelector(`#edit-whatsapp-country-code-select-${formId}`);
        const whatsappInput = form.querySelector(`#edit-geex-input-whatsapp-${formId}`);
        const whatsappFlag = form.querySelector(`#edit-whatsapp-flag-img-${formId}`);
        const whatsappMsg = form.querySelector(`#edit-whatsapp-validity-msg-${formId}`);
        const whatsappError = document.getElementById(`whatsapp_error_${formId}`);

        const phoneSelect = form.querySelector(`#edit-phone-country-code-select-${formId}`);
        const phoneInput = form.querySelector(`#edit-geex-input-phone-${formId}`);
        const phoneFlag = form.querySelector(`#edit-phone-flag-img-${formId}`);
        const phoneMsg = form.querySelector(`#edit-phone-validity-msg-${formId}`);
        const phoneError = document.getElementById(`phone_error_${formId}`);

        const instagramInput = form.querySelector('input[name="instagram"]');
        const googleMapInput = form.querySelector('input[name="google_Map"]');
        const googleMap2Input = form.querySelector('input[name="google_Map_2"]');
        const tiktokInput = form.querySelector('input[name="tiktok"]');

        // Real-time validation للواتساب
        if (whatsappSelect && whatsappInput) {
            whatsappSelect.addEventListener('change', function() {
                updateFlag(this, whatsappFlag);
                validatePhoneWithMessage(this, whatsappInput, whatsappMsg, whatsappError);
            });
            
            whatsappInput.addEventListener('input', function() {
                validatePhoneWithMessage(whatsappSelect, this, whatsappMsg, whatsappError);
            });

            // Initial validation
            updateFlag(whatsappSelect, whatsappFlag);
            validatePhoneWithMessage(whatsappSelect, whatsappInput, whatsappMsg, whatsappError);
        }

        // Real-time validation للتليفون
        if (phoneSelect && phoneInput) {
            phoneSelect.addEventListener('change', function() {
                updateFlag(this, phoneFlag);
                validatePhoneWithMessage(this, phoneInput, phoneMsg, phoneError);
            });
            
            phoneInput.addEventListener('input', function() {
                validatePhoneWithMessage(phoneSelect, this, phoneMsg, phoneError);
            });

            // Initial validation
            updateFlag(phoneSelect, phoneFlag);
            validatePhoneWithMessage(phoneSelect, phoneInput, phoneMsg, phoneError);
        }

        // Real-time validation للـ URLs
        if (instagramInput) {
            const instagramError = document.getElementById(`instagram_error_${formId}`);
            instagramInput.addEventListener('input', function() {
                validateURL(this, instagramError, 'instagram');
            });
        }

        if (googleMapInput) {
            const googleMapError = document.getElementById(`google_Map_error_${formId}`);
            googleMapInput.addEventListener('input', function() {
                validateURL(this, googleMapError, 'google_map');
            });
        }

        if (googleMap2Input) {
            const googleMap2Error = document.getElementById(`google_Map_2_error_${formId}`);
            googleMap2Input.addEventListener('input', function() {
                validateURL(this, googleMap2Error, 'google_map');
            });
        }

        if (tiktokInput) {
            const tiktokError = document.getElementById(`tiktok_error_${formId}`);
            tiktokInput.addEventListener('input', function() {
                validateURL(this, tiktokError, 'tiktok');
            });
        }

        // Submit validation
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // مسح الأخطاء القديمة
            form.querySelectorAll('.error-text').forEach(el => el.textContent = '');
            let hasError = false;

            // Validate whatsapp
            if (whatsappInput && whatsappInput.value.trim()) {
                if (!validatePhoneWithMessage(whatsappSelect, whatsappInput, whatsappMsg, whatsappError)) {
                    hasError = true;
                }
            }

            // Validate phone
            if (phoneInput && phoneInput.value.trim()) {
                if (!validatePhoneWithMessage(phoneSelect, phoneInput, phoneMsg, phoneError)) {
                    hasError = true;
                }
            }

            // Validate URLs
            if (instagramInput && instagramInput.value.trim()) {
                const instagramError = document.getElementById(`instagram_error_${formId}`);
                if (!validateURL(instagramInput, instagramError, 'instagram')) {
                    hasError = true;
                }
            }

            if (googleMapInput && googleMapInput.value.trim()) {
                const googleMapError = document.getElementById(`google_Map_error_${formId}`);
                if (!validateURL(googleMapInput, googleMapError, 'google_map')) {
                    hasError = true;
                }
            }

            if (googleMap2Input && googleMap2Input.value.trim()) {
                const googleMap2Error = document.getElementById(`google_Map_2_error_${formId}`);
                if (!validateURL(googleMap2Input, googleMap2Error, 'google_map')) {
                    hasError = true;
                }
            }

            if (tiktokInput && tiktokInput.value.trim()) {
                const tiktokError = document.getElementById(`tiktok_error_${formId}`);
                if (!validateURL(tiktokInput, tiktokError, 'tiktok')) {
                    hasError = true;
                }
            }

            if (hasError) {
                return false;
            }

            // لو مفيش أخطاء → نكمل بالـ AJAX
            const formData = new FormData(form);
            if (!formData.has('_method')) formData.append('_method', 'PUT');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.errors) {
                    // Backend validation errors
                    for (let key in data.errors) {
                        const errorSpan = document.getElementById(`${key}_error_${formId}`);
                        if (errorSpan) errorSpan.textContent = data.errors[key][0];
                    }
                } else {
                    // Success
                    if (typeof toastr !== 'undefined') {
                        toastr.success('تم التعديل بنجاح');
                    }
                    $(`#projectEditModal_${formId}`).modal('hide');
                    setTimeout(() => location.reload(), 500);
                }
            })
            .catch(err => {
                console.error(err);
                if (typeof toastr !== 'undefined') {
                    toastr.error('حدث خطأ أثناء الحفظ');
                } else {
                    alert('حدث خطأ أثناء الحفظ، حاول مرة أخرى.');
                }
            });
        });
    });