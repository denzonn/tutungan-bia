@php
    $footer = \App\Models\Setting::first();
@endphp

<footer>
    <!-- Footer Start-->
    <div class="footer-area footer-padding fix">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-xl-5 col-lg-5 col-md-7 col-sm-12">
                    <div class="single-footer-caption">
                        <div class="single-footer-caption">
                            <!-- logo -->
                            <div class="footer-logo">
                                <a href="index.html">
                                    <img
                                        src="{{ Storage::url($footer->logo) }}"
                                        alt="">
                                    </a>
                            </div>
                            <div class="footer-tittle">
                                <div class="footer-pera">
                                    <p>{{$footer->short_profile}}</p>
                                </div>
                            </div>
                            <!-- social -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4  col-sm-6">
                    <div class="single-footer-caption mt-60">
                        <div class="footer-tittle">
                            <h4>Pengunjung :</h4>
                        </div>
                        <div class="footer-tittle">
                            <ul>
                                <li>
                                    <p><strong>Hari Ini:</strong> {{ formatVisits($todayVisits) }}</p>
                                </li>
                                <li>
                                    <p><strong>Minggu Ini:</strong> {{ formatVisits($weekVisits) }}</p>
                                </li>
                                <li>
                                    <p><strong>Bulan Ini:</strong> {{ formatVisits($monthVisits) }}</p>
                                </li>
                                <li>
                                    <p><strong>Tahun Ini:</strong> {{ formatVisits($yearVisits) }}</p>
                                </li>
                                <li>
                                    <p><strong>Total Kunjungan:</strong> {{ formatVisits($totalVisits) }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6">
                    <div class="single-footer-caption mb-50 mt-60">
                        <div class="footer-tittle">
                            <h4>Social Media</h4>
                        </div>
                        <div class="instagram-gellay">
                            <ul class="insta-feed">
                                <li>
                                    <a href="{{ $footer->sosial_media_1 }}" target="_blank"><i class="fab fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="{{ $footer->sosial_media_2 }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="{{ $footer->sosial_media_3 }}" target="_blank"><i class="fab fa-telegram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer-bottom aera -->
    <div class="footer-bottom-area">
        <div class="container">
            <div class="footer-border">
                <div class="row d-flex align-items-center justify-content-between">
                    <div class="col-lg-6">
                        <div class="footer-copy-right">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright Tutungan Bia' &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved | This is made by <a
                                    href="https://portofoliod.vercel.app/" target="_blank">Denson Patibang</a>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="footer-menu f-right">
                            <ul>
                                <li><a href="#">Terms of use</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
