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

    #data_table tbody td {
        text-align: center;
        vertical-align: middle;
    }

    #data_table thead th {
        text-align: center;
        vertical-align: middle;
    }
</style>
<div class="row">
    <div class="col-12">

        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">

                <h4 class="font-15 ">النطاقات</h4>

                <div class="add-new-contact ml-20">
                    <a href="#" class="bg-success-light text-success btn ui-sortable-handle" data-toggle="modal"
                        data-target="#projectAddModal" style="float: left;">
                        <i class="fas fa-plus"></i> إضافة نطاق جديد
                    </a>
                </div>
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form action="{{ route('domain.store') }}" method="POST" enctype="multipart/form-data">
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
                                                <label for="name" class="mb-2 black bold">الاسم</label>
                                                <input type="text" class="theme-input-style" id="name"
                                                    name="name" placeholder="اكتب الاسم">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="url" class="mb-2 black bold">النطاق (الدومين)</label>
                                                <input type="text" class="theme-input-style" id="url"
                                                    name="url" placeholder="اكتب اسم النطاق">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="d-flex justify-content-center pt-3" style="padding-bottom: 10px;">
                                <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>
                            </form>
                        </div>
                        <!-- End Modal Body -->
                    </div>
                </div>



                <!-- Invoice List Table -->
                <div class="mt-5 p-5">
                    <table class="text-nowrap bg-white dh-table" id="data_table">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الاسم</th>
                                <th>اسم النطاق</th>
                                <th>الاجراءات</th>
                            </tr>
                        </thead>

                    </table>
                </div>

                <!-- End Invoice List Table -->
            </div>
        </div>
    </div>

</div>
</div>



<script>
    $(function() {
        $('#data_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('domain.getdata') }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'url',
                    name: 'url'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
