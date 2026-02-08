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
                <h6 class="font-15 "> احصائيات الزيارات </h6>
                <div class="table-responsive">
                    <table class="text-nowrap bg-white dh-table">
                        <thead class="thead-light">
                            <tr>
                                <th># </th>
                                <th>الاسم </th>
                                <th>عدد الزيارات </th>
                                <th>اخر زيارة   </th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($data as $one)
                                @php
                                    $cat_name = App\Models\Category::where('id',$one->cat_id)->first()->name ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    
                                    @if($one->ads->prods )
                                       <td> {{ optional($one->ads->prods)->name }}</td>
                                     @elseif(isset($one->cat_id))
                                       <td> {{ $cat_name }}</td>
                                    @else
                                    <td>الفروع</td>   
                                    @endif
                                    <td>{{ $one->count }}</td>
                                    <td> {{ \Carbon\Carbon::parse($one->created_at)->format('Y-m-d') }}
                                         <br> 
                                        {{ str_replace(['AM', 'PM'], ['ص', 'م'], \Carbon\Carbon::parse($one->created_at)->format('h:i A')) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>