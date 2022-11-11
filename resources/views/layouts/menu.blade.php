<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" class="navbar-brand-img">
            </a>
        </div>
        <div class="navbar-inner">
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('home*') ? 'active' : '' }}" href="{{ route('home'); }}">
                            <i class="fa fa-pie-chart text-primary"></i>
                            <span class="nav-link-text">Arayüz</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('vehicles*') ? 'active' : '' }}" href="{{ route('vehicle.index'); }}">
                            <i class="fa fa-car text-primary"></i>
                            <span class="nav-link-text">Araçlar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}" href="{{ route('customer.index'); }}">
                            <i class="fa fa-users text-primary"></i>
                            <span class="nav-link-text">Müşteriler</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;">
                            <i class="fa fa-wpforms text-primary"></i>
                            <span class="nav-link-text">Formlar</span>
                            <i class="fa fa-caret-right sub-icon"></i>
                        </a>
                        <ul class="nav-item_sub">
                            <li>
                                <a href="{{ route('contactform.index', ['startDate' => date("Y-m-d"), 'endDate' => date("Y-m-d")]) }}">
                                    <span>İletişim Formları</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bookingform.index', ['startDate' => date("Y-m-d"), 'endDate' => date("Y-m-d")]) }}">
                                    <span>Rezervasyon Formları</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;">
                            <i class="fa fa-calendar text-primary"></i>
                            <span class="nav-link-text">Takvimler</span>
                            <i class="fa fa-caret-right sub-icon"></i>
                        </a>
                        <ul class="nav-item_sub">
                            <li>
                                <a href="{{ route('reservation.calendar') }}">
                                    <span>Rezervasyon Takvimi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;">
                            <i class="fa fa-tasks text-primary"></i>
                            <span class="nav-link-text">Tanımlamalar</span>
                            <i class="fa fa-caret-right sub-icon"></i>
                        </a>
                        <ul class="nav-item_sub">
                            <li>
                                <a href="{{ route('formstatus.index'); }}">
                                    <span>Form Durumları</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('discount.index'); }}">
                                    <span>İndirimler</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('paymenttype.index'); }}">
                                    <span>Ödeme Türleri</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('brand.index'); }}">
                                    <span>Markalar</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('source.index'); }}">
                                    <span>Rezervasyon Kaynakları</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item {{ request()->is('reports*') ? 'active' : '' }}">
                        <a class="nav-link" href="javascript:;">
                            <i class="fa fa-file-text text-primary"></i>
                            <span class="nav-link-text">Raporlar</span>
                            <i class="fa fa-caret-right sub-icon"></i>
                        </a>
                        <ul class="nav-item_sub">
                            <li>
                                <a href="{{ route('report.reservation', ['startDate' => date("Y-m-d"), 'endDate' => date("Y-m-d")]) }}">
                                    <span>Rezervasyon Raporu</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report.payment', ['startDate' => date("Y-m-d"), 'endDate' => date("Y-m-d")]) }}">
                                    <span>Ciro Raporu</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report.comission', ['startDate' => date("Y-m-d"), 'endDate' => date("Y-m-d")]) }}">
                                    <span>Komisyon Raporu</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;">
                            <i class="fa fa-check text-primary"></i>
                            <span class="nav-link-text">Rezervasyonlar</span>
                            <i class="fa fa-caret-right sub-icon"></i>
                        </a>
                        <ul class="nav-item_sub">
                            <li>
                                <a href="{{ route('reservation.create') }}">
                                    <span>Yeni Rezervasyon</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('reservation.index', ['startDate' => date("Y-m-d"), 'endDate' => date("Y-m-d")]) }}">
                                    <span>Rezervasyon Listesi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:;">
                            <i class="fa fa-user text-primary"></i>
                            <span class="nav-link-text">Kullanıcılar</span>
                            <i class="fa fa-caret-right sub-icon"></i>
                        </a>
                        <ul class="nav-item_sub">
                            <li>
                                <a href="{{ route('role.index'); }}">
                                    <span>Roller</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.index'); }}">
                                    <span>Tüm Kullanıcılar</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <hr class="my-3">
            </div>
        </div>
    </div>
</nav>
