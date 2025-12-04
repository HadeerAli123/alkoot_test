<!-- Header -->
      <header class="header white-bg fixed-top d-flex align-content-center flex-wrap">
         <!-- Logo -->
         <div class="logo">
            <a href="{{ route('home') }}" class="default-logo">
               <img src="{{ asset('assets/img/logo.png') }}" alt="" style="margin-top: 20px;">
            </a>
            <a href="{{ route('home') }}" class="mobile-logo">
               <img src="{{ asset('assets/img/mobile_icon_128.png') }}" alt="" style="margin-top: 20px;">
            </a></div>
         <!-- End Logo -->

         <!-- Main Header -->
         <div class="main-header">
            <div class="container-fluid">
               <div class="row justify-content-between">
                  <div class="col-3 col-lg-1 col-xl-4">
                     <!-- Header Left -->
                     <div class="main-header-left h-100 d-flex align-items-center">
                        <!-- Main Header User -->
                        <div class="main-header-user">
                           <a href="#" class="d-flex align-items-center" data-toggle="dropdown">
                              <div class="menu-icon">
                                 <span></span>
                                 <span></span>
                                 <span></span>
                              </div>

                              <div class="user-profile d-xl-flex align-items-center d-none">
                                 <!-- User Avatar -->
                                 <div class="user-avatar">
                                    <img src="{{ asset('assets/img/avatar/219983.png') }}" alt="">
                                 </div>
                                 <!-- End User Avatar -->

                                 <!-- User Info -->
                                 <div class="user-info">
                                    @if(Auth::check())
                                       <h4 class="user-name">{{ Auth::user()->name }}</h4>                            
                                
                               
                                    <p class="user-email">{{ Auth::user()->email }}</p>
                                         @endif
                                 </div>
                                 <!-- End User Info -->
                              </div>
                           </a>
                           <div class="dropdown-menu">
                           
                              <a href="{{route('logout')}}">تسجيل الخروج </a>
                           </div>
                        </div>
                        <!-- End Main Header User -->

                        <!-- Main Header Menu -->
                        <div class="main-header-menu d-block d-lg-none">
                           <div class="header-toogle-menu">
                              <!-- <i class="icofont-navigation-menu"></i> -->
                              <img src="assets/img/menu.png" alt="">
                           </div>
                        </div>
                        <!-- End Main Header Menu -->
                     </div>
                     <!-- End Header Left -->
                  </div>
                  <div class="col-9 col-lg-11 col-xl-8">
                     <!-- Header Right -->
                     <div class="main-header-right d-flex justify-content-end">
                        <ul class="nav">
                       
                           <li class="d-none d-lg-flex">
                              <!-- Main Header Time -->
                              <div class="main-header-date-time text-right">
                               <h3 class="time">
  <span id="hours"></span>
  <span id="point">:</span>
  <span id="min"></span>
</h3>
                                 <span class="date"><span id="date">Tue, 12 October 2019</span></span>
                              </div>
                              <!-- End Main Header Time -->
                           </li>
                          
                       
                        </ul>
                     </div>
                     <!-- End Header Right -->
                  </div>
               </div>
            </div>
         </div>
         <!-- End Main Header -->
      </header>
      <!-- End Header -->
       <script>
  function updateTime() {
    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();

    // نضيف صفر قبل الأرقام الأقل من 10
    hours = hours < 10 ? "0" + hours : hours;
    minutes = minutes < 10 ? "0" + minutes : minutes;

    document.getElementById("hours").textContent = hours;
    document.getElementById("min").textContent = minutes;
  }

  // أول ما الصفحة تفتح
  updateTime();

  // تحديث الوقت كل دقيقة
  setInterval(updateTime, 1000);
</script>
