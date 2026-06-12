        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h4 class="mb-4"><i class="fas fa-mosque me-2"></i> {{ config('app.name') }}</h4>
                        <p>@trans('Providing accurate prayer times for Muslims worldwide since 2023. Our mission is to help Muslims maintain their salah on time.')</p>
                    </div>
                    
                    <div class="col-md-2 mb-4">
                        <h5 class="mb-4">@trans('Quick Links')</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="/{{$lang ?? ''}}"><i class="fas fa-arrow-right me-2"></i> @trans('Home')</a></li>
                            <li class="mb-2"><a href="{{url('/aboutus')}}"><i class="fas fa-arrow-right me-2"></i> @trans('About')</a></li>
                            <li class="mb-2"><a href="{{url('/blogs')}}"><i class="fas fa-arrow-right me-2"></i> @trans('Blogs')</a></li>
                            <li class="mb-2"><a href="{{url('/write-for-us')}}"><i class="fas fa-arrow-right me-2"></i> @trans('write for us')</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <h5 class="mb-4">@trans('Islamic Tools')</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="{{ $lang ? "/$lang/islamic-calendar" : '/islamic-calendar' }}">
                                    <i class="fas fa-arrow-right me-2"></i> @trans('Hijri Calendar')
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ $lang ? "/$lang/ramadan-timing" : '/ramadan-timing' }}">
                                    <i class="fas fa-arrow-right me-2"></i> @trans('Ramadan Timings')
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ $lang ? "/$lang/Tasbeeh-counter" : '/Tasbeeh-counter' }}">
                                    <i class="fas fa-arrow-right me-2"></i> @trans('Tasbeeh Counter')
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <h5 class="mb-4">@trans('Connect With Us')</h5>
                        <div class="social-links mb-4">
                            <a href="https://www.facebook.com/nextprayertime" 
                               rel="nofollow noopener noreferrer" 
                               target="_blank" 
                               class="me-3"
                               title="Follow us on Facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span class="visually-hidden">Facebook</span>
                            </a>
                            
                            <a href="https://twitter.com/nextprayertime" 
                               rel="nofollow noopener noreferrer" 
                               target="_blank" 
                               class="me-3"
                               title="Follow us on Twitter">
                                <i class="fab fa-twitter"></i>
                                <span class="visually-hidden">Twitter</span>
                            </a>
                            
                            <a href="https://www.instagram.com/nextprayertime" 
                               rel="nofollow noopener noreferrer" 
                               target="_blank" 
                               class="me-3"
                               title="Follow us on Instagram">
                                <i class="fab fa-instagram"></i>
                                <span class="visually-hidden">Instagram</span>
                            </a>
                            
                            <a href="https://www.youtube.com/@nextprayertime" 
                               rel="nofollow noopener noreferrer" 
                               target="_blank" 
                               class="me-3"
                               title="Subscribe to our YouTube channel">
                                <i class="fab fa-youtube"></i>
                                <span class="visually-hidden">YouTube</span>
                            </a>
                        </div>
                        
                        <div class="hijri-date" style="color:white;" id="hijriDate">
                            {{ \Carbon\Carbon::now()->format('j F Y') }} 
                            ({{ \Carbon\Carbon::now()->format('Y') }} AH)
                        </div>
                    </div>
                </div>
                
                <div class="copyright">
                    <p>&copy; <span id="copyrightYear">{{ date('Y') }}</span> @trans('NextPrayerTimes. All Rights Reserved.')</p>
                </div>
            </div>
        </footer>
    </div> <!-- Close npt-main -->

    <!-- AMP State for loader -->
    <amp-state id="pageState">
        <script type="application/json">
            {
                "loaded": false
            }
        </script>
    </amp-state>

    <!-- Hide loader after page load using amp-bind -->
    <div hidden 
         [hidden]="!pageState.loaded" 
         [class]="pageState.loaded ? 'npt-loader fade-out' : 'npt-loader'">
    </div>

    <!-- Set loaded state after page is ready -->
    <amp-script layout="container" script="hide-loader-script"></amp-script>
    <script id="hide-loader-script" type="text/plain" target="amp-script">
        window.addEventListener('load', function() {
            document.getElementById('loader').classList.add('fade-out');
            setTimeout(function() {
                document.getElementById('loader').style.display = 'none';
            }, 500);
        });
    </script>

    <!-- Bootstrap Icons (AMP doesn't allow external CSS, so we use Unicode/emoji fallbacks) -->
    <style amp-custom>
        /* Footer Styles */
        .footer {
            background: var(--primary-dark);
            color: white;
            padding: 3rem 0 1.5rem;
            margin-top: 3rem;
        }

        .footer h4, .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
        }

        .footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: white;
        }

        .footer .list-unstyled {
            list-style: none;
            padding: 0;
        }

        .footer .list-unstyled li {
            margin-bottom: 0.5rem;
        }

        .footer .social-links a {
            display: inline-block;
            margin-right: 1rem;
            font-size: 1.25rem;
        }

        .footer .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
        }

        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            border: 0;
        }

        .hijri-date {
            margin-top: 1rem;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Grid system */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-2, .col-md-3, .col-md-4 {
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 768px) {
            .col-md-2 { flex: 0 0 16.666667%; max-width: 16.666667%; }
            .col-md-3 { flex: 0 0 25%; max-width: 25%; }
            .col-md-4 { flex: 0 0 33.333333%; max-width: 33.333333%; }
        }

        .mb-4 { margin-bottom: 1.5rem; }
        .me-2 { margin-right: 0.5rem; }
        .me-3 { margin-right: 1rem; }
        .text-center { text-align: center; }

        /* Icon fallbacks */
        .fab {
            font-family: 'Font Awesome 5 Brands', 'Font Awesome 6 Brands';
            font-style: normal;
        }

        .fa-facebook-f:before { content: ""; }
        .fa-twitter:before { content: ""; }
        .fa-instagram:before { content: ""; }
        .fa-youtube:before { content: ""; }
    </style>
</body>
</html>