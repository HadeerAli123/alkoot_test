{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<div class="row">
    <div class="col-12">

        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">

                <h6 class="font-15 ">احصائيات اكسيل</h6>

                <div class="add-new-contact ml-20">
                    <a href="#" class="bg-success-light text-success btn ui-sortable-handle" data-toggle="modal"
                        data-target="#projectAddModal" style="float: left;">
                        <i class="fa fa-plus"></i>
                        <span class="ml-2"> رفع ملف</span>
                    </a>
                </div>
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal Header with Title -->
                            <div class="modal-header" style="padding: 1rem 1.5rem;">
                                <h5 class="modal-title">رفع ملف Excel</h5>

                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body" style="padding: 2rem;">
                                <form action="{{ route('excel.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                                <label for="file" class="mb-2 black bold">اختر الملف <span class="text-danger">*</span></label>
                                                <input type="file" class="theme-input-style" id="file" name="file" required>
                                                @error('file')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">رفع</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                </form>
                            </div>
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
                                <th>اسم الحملة</th>
                                <th>اسم المجموعة الإعلانية</th>
                                <th>نوع الإعلان</th>
                                <th>المبلغ الذي تم إنفاقه</th>
                                <th>مرات الظهور المدفوعة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $one)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $one->campaign_name }}</td>
                                <td>{{ $one->ad_Gname }}</td>
                                <td>{{ $one->ad_type }}</td>
                                <td>{{ $one->amount_spent }}</td>
                                <td>{{ $one->uploaded_impressions }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Invoice List Table -->
                </div>
            </div>
        </div>

    </div>
</div>
