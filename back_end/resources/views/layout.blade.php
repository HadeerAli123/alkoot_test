@include('includes/head')
<style>
    .card{
  border-radius: 20px !important;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}
.breadcrumb
{
  border-radius: 20px !important;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #fff;   
}
</style>
<body>
    <!-- Offcanval Overlay -->
    <div class="offcanvas-overlay"></div>
    <!-- Offcanval Overlay -->
    <div class="wrapper">
        @include('includes/header')
        <div class="main-wrapper">

            @include('includes/sidebar')
            <div class="main-content">
                <div class="container-fluid">
                    @include('includes/crumb')

           
                    <!--  Content Start -->
                    @include($view)
                    <!--  Content End -->
                </div>
            </div>
        </div>

        @include('includes/footer')
    </div>
</body>