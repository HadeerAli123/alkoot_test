@if (isset($breadcrumb) && is_array($breadcrumb) && count($breadcrumb) > 0 && url()->current() != url('/') && url()->current() != url('/login'))
    <div class="overflow-hidden position-relative mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white rounded shadow-sm d-flex justify-content-right" dir="rtl" style="font-weight: 500; padding: 15px;">
                @foreach ($breadcrumb as $key => $row)
                    @php
                        // Use 'icon' key if set, otherwise fallback to fa-folder-open or fa-home
                        $icon = isset($row['icon']) ? $row['icon'] : ($key == 0 ? 'fa-home' : 'fa-folder-open');
                        // If icon contains 'fa ', use as is, else prepend 'fas '
                        $iconClass = Str::startsWith($icon, 'fa ') ? $icon : 'fas ' . $icon;
                    @endphp
                    @if ($key == count($breadcrumb) - 1)
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            <i class="{{ $iconClass }}"></i> {{ $row['title'] }}
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $row['url'] }}" class="text-secondary">
                                <i class="{{ $iconClass }}"></i> {{ $row['title'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

