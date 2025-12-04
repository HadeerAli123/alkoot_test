<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

<div class="row">
    <div class="col-12">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="contact-account-setting media-body d-flex justify-content-center align-items-center"
                        style="background: #eeeff2; border-radius: 12px; padding: 20px 0 15px 0; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <h4 class="mb-0"
                            style="font-weight: bold; letter-spacing: 1px; text-align: center; padding-right: 10px;">
                            إضافة مشروع جديد
                        </h4>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="vendor_name" class="mb-2 black bold">اسم المشروع</label>
                                <input type="text" class="theme-input-style" id="vendor_name" name="name"
                                    placeholder="اكتب اسم المشروع هنا">
                            </div>
                        </div>
                    

                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="domain" class="mb-2 black bold">النطاق (domain)</label>
                                <select class="form-control mb-5" id="domain" name="domain" required >
                                    @foreach($domain as $d)
                                    <option value="{{ $d->id }}" selected>{{ $d->url }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="vendor_logo" class="mb-2 black bold d-block">اللوجو</label>
                                <input type="file" class="form-control mb-5" id="vendor_logo" name="logo">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group mb-4">
                                <label for="vendor_contact" class="mb-2 black bold">معلومات التواصل</label>
                                <input type="number" class="theme-input-style" id="vendor_contact" name="phone"
                                    placeholder="رقم الهاتف ">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <!-- <label for="theme_id" class="mb-2 black bold">الثيم</label> -->
                             
                                <label
                                    style="cursor: pointer; display: inline-flex; align-items: center; margin-right: 12px;">
                                    <input type="radio" name="theme_id" value="4" style="display:none;">
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
    const form = document.querySelector('form[action="{{ route('companies.store') }}"]');
    const hasBranch = document.getElementById('has_branch');
    const hasProduct = document.getElementById('has_product');
    const branchesSection = document.getElementById('branches-section');
    const productsSection = document.getElementById('products-section');
    const addBranchBtn = document.getElementById('add-branch-row');
    const addProductBtn = document.getElementById('add-product-row');
    const branchesRows = document.getElementById('branches-rows');
    const productsRows = document.getElementById('products-rows');

    let branchIndex = branchesRows.querySelectorAll('.branch-row').length || 1;
    let productIndex = productsRows.querySelectorAll('.product-row').length || 1;

    // Show/hide sections initially
    branchesSection.style.display = hasBranch.checked ? 'block' : 'none';
    productsSection.style.display = hasProduct.checked ? 'block' : 'none';

    // Update numbering badges
    function updateBranchNumbers() {
        branchesRows.querySelectorAll('.branch-number').forEach((badge, idx) => {
            badge.textContent = idx + 1;
        });
    }

    function updateProductNumbers() {
        productsRows.querySelectorAll('.product-number').forEach((badge, idx) => {
            badge.textContent = idx + 1;
        });
    }

    hasBranch.addEventListener('change', () => {
        branchesSection.style.display = hasBranch.checked ? 'block' : 'none';
    });
    hasProduct.addEventListener('change', () => {
        productsSection.style.display = hasProduct.checked ? 'block' : 'none';
    });

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
      <div class="col-md-6 mb-3"  style="display: none;">
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

    // Remove branch row
    branchesRows.addEventListener('click', (e) => {
        if (e.target.closest('.remove-branch')) {
            e.target.closest('.branch-row').remove();
            updateBranchNumbers();
        }
    });

    // Remove product row
    productsRows.addEventListener('click', (e) => {
        if (e.target.closest('.remove-product')) {
            e.target.closest('.product-row').remove();
            updateProductNumbers();
        }
    });

    // Validation for at least one branch/product if checked
    form.addEventListener('submit', function(e) {
        if (hasBranch.checked) {
            const branchInputs = document.querySelectorAll(
                '#branches-rows .branch-row input[name^="branches"][name$="[name]"]');
            let hasAtLeastOne = false;
            branchInputs.forEach(input => {
                if (input.value.trim() !== '') hasAtLeastOne = true;
            });
            if (!hasAtLeastOne) {
                e.preventDefault();
                alert('يجب إدخال اسم فرع واحد على الأقل عند اختيار "هل يوجد فروع".');
            }
        }
        if (hasProduct.checked) {
            const productInputs = document.querySelectorAll(
                '#products-rows .product-row input[name^="products"][name$="[name]"]');
            let hasAtLeastOne = false;
            productInputs.forEach(input => {
                if (input.value.trim() !== '') hasAtLeastOne = true;
            });
            if (!hasAtLeastOne) {
                e.preventDefault();
                alert('يجب إدخال اسم منتج واحد على الأقل عند اختيار "هل يوجد منتجات".');
            }
        }
    });

    form.addEventListener("reset", function(e) {
         history.back();
    });
});
</script>
