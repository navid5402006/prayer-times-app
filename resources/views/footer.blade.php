
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

            <!-- <li class="mb-2"><a href="#contact"><i class="fas fa-arrow-right me-2"></i> @trans('Contact')</a></li> -->
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
                   <div class="moon-phase"></div> <div class="hijri-date text-center" id="ishijriDate" style="color:white;"></div> <script> document.getElementById('ishijriDate').innerHTML = ' ' + new Date().toLocaleDateString('en-u-ca-islamic', { day: 'numeric', month: 'long', year: 'numeric' }) + ' '; </script>

        </div>
      </div>
      <div class="copyright">
        <p>&copy; <span id="currentYear"></span> @trans('NextPrayerTimes. All Rights Reserved.')</p>
      </div>
    </div>
  </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>