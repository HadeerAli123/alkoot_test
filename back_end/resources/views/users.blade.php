<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

<style>
.theme-input-style {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #ccc !important;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

.theme-input-style:focus {
    border-color: #4a57f5;
    outline: none;
}
</style>
<div class="row">
    <div class="col-12">

        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">

                <h4 class="font-15 ">المستخدمين</h4>

                <div class="add-new-contact ml-20">
                    <a href="#" class="bg-success-light text-success btn ui-sortable-handle" data-toggle="modal"
                        data-target="#projectAddModal" style="float: left;">
                        مستخدم جديد
                    </a>
                </div>
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form  id="userForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" >
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
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_name" class="mb-2 black bold">الاسم</label>
                                                <input type="text" class="theme-input-style" id="user_name" name="name"
                                                    placeholder="اكتب الاسم">
<span class="text-danger error-text name_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_username" class="mb-2 black bold">اسم المستخدم</label>
                                                <input type="text" class="theme-input-style" id="user_username"
                                                    name="username" placeholder="اكتب اسم المستخدم">
    <span class="text-danger error-text username_error"></span>
                                            </div>
                                            
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_email" class="mb-2 black bold">البريد
                                                    الإلكتروني</label>
                                                <input type="email" class="theme-input-style" id="user_email"
                                                    name="email" placeholder="ادخل البريد الإلكتروني">
  <span class="text-danger error-text email_error"></span>                                 </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_password" class="mb-2 black bold">كلمة المرور</label>
                                                <input type="password" class="theme-input-style" id="user_password"
                                                    name="password" placeholder="ادخل كلمة المرور">
 <span class="text-danger error-text password_error"></span>
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
                    <!-- Invoice List Table -->
                    <table class="text-nowrap bg-white dh-table">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الاسم</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الالكترونى</th>
                                <th>الاجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $one)
                            @if (is_object($one) )
                            
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $one->name ?? '' }}</td>
                                <td>{{ $one->username ?? '' }}</td>
                                <td>{{ $one->email ?? ''}}</td>
                                <td>
                                    <a  class="bg-success-light text-success btn ui-sortable-handle"
                                        data-toggle="modal" data-target="#projectEditModal_{{$one->id}}">
                                         تعديل
                                    </a>
                                     <form action="{{ route('users.destroy', $one->id) }}" method="POST"
                                         style="display:inline;">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-sm bg-danger-light text-danger mr-10"
                                             onclick="return confirm(' هل أنت متأكد من الحذف ');">حذف</button>
                                     </form>
                                </td>

                                <div id="projectEditModal_{{$one->id}}" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                             <form class="editUserForm" data-user-id="{{ $one->id }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
                                                        style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                                        <h4 class="mb-0"
                                                            style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                                             تعديل</h4>
                                                        <button type="button" class="close ml-2" data-dismiss="modal"
                                                            aria-label="Close"
                                                            style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_name"
                                                                    class="mb-2 black bold">الاسم</label>
                                                                <input type="text" class="theme-input-style"
                                                                    id="user_name" name="name" value="{{$one->name}}">
      <span class="text-danger error-text name_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_username" class="mb-2 black bold">اسم
                                                                    المستخدم</label>
                                                                <input type="text" class="theme-input-style"
                                                                    id="user_username" name="username"
                                                                    value="{{$one->username}}">
   <span class="text-danger error-text username_error"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_email" class="mb-2 black bold">البريد
                                                                    الإلكتروني</label>
                                                                <input type="email" class="theme-input-style"
                                                                    id="user_email" name="email"
                                                                    value="{{$one->email}}">
      <span class="text-danger error-text email_error"></span>

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_password" class="mb-2 black bold">كلمة
                                                                    المرور</label>
                                                                <input type="password" class="theme-input-style"
                                                                    id="user_password" name="password"
                                                                   >
  <span class="text-danger error-text password_error"></span>

                                                            </div>
                                                        </div>
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
                                
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Invoice List Table -->
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script>
$(document).ready(function() {

    // إخفاء أي أخطاء قديمة لما نفتح المودال من جديد
    $('#projectAddModal').on('show.bs.modal', function () {
        $('.error-text').text('');
        $('#userForm')[0].reset();
    });

    // منع الـ Submit العادي وتحويله لـ AJAX
    $('#userForm').on('submit', function(e) {
        e.preventDefault();

        $('.error-text').text('');

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('users.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                toastr.success('تم إضافة المستخدم بنجاح');
                $('#projectAddModal').modal('hide');
                $('#userForm')[0].reset();
                location.reload(); // أو استخدمي DataTable reload لو عندك
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.name) $('.name_error').text(errors.name[0]);
                    if (errors.username) $('.username_error').text(errors.username[0]);
                    if (errors.email) $('.email_error').text(errors.email[0]);
                    if (errors.password) $('.password_error').text(errors.password[0]);
                } else {
                    toastr.error('حدث خطأ غير متوقع');
                }
            }
        });
    });
});




</script>
<script>
// تعديل المستخدم بالـ AJAX
$(document).on('submit', '.editUserForm', function(e) {
    e.preventDefault();

    let form = $(this);
    let userId = form.data('user-id');
    let modal = form.closest('.modal');

    // مسح الأخطاء القديمة
    modal.find('.error-text').text('');

    let formData = new FormData(this);

    $.ajax({
        url: "{{ url('users') }}" + '/' + userId,  // أو route('users.update', ':id') لو عايزة
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            toastr.success('تم تعديل المستخدم بنجاح');
            modal.modal('hide');
            location.reload(); // أو تحديث الصف فقط بدون reload كامل
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                if (errors.name) modal.find('.name_error').text(errors.name[0]);
                if (errors.username) modal.find('.username_error').text(errors.username[0]);
                if (errors.email) modal.find('.email_error').text(errors.email[0]);
                if (errors.password) modal.find('.password_error').text(errors.password[0]);
            } else {
                toastr.error('حدث خطأ غير متوقع');
            }
        }
    });
});

// تنظيف الأخطاء لما نفتح أي مودال تعديل
$('body').on('show.bs.modal', '.modal', function () {
    $(this).find('.error-text').text('');
});
</script>