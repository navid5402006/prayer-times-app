<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Islamic Insights | Blog & Articles</title>
    <meta name="description" content="Explore insightful articles about Islamic teachings, prayer guidance, and spiritual growth.">
    <meta name="keywords" content="islamic blog, muslim articles, prayer guidance, islamic knowledge, spiritual growth">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #0d6e6e;
            --secondary-color: #054545;
            --accent-color: #d4af37;
            --light-color: #f5f5f0;
            --text-color: #333;
            --light-text: #777;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            color: var(--text-color);
            line-height: 1.6;
            padding-top: 70px;
        }
        
        .arabic-font {
            font-family: 'Scheherazade New', serif;
        }
        
        .navbar {
            background-color: rgb(13 110 110 / .9) !important;
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 20px rgb(0 0 0 / .1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            color: var(--accent-color);
            margin-right: 10px;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            padding: 8px 0 !important;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after, .nav-link.active:after {
            width: 100%;
        }
        
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1519817650390-64a93db51149?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            min-height: 40vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin-top: -10px;
        }
        
        .hero:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><text x="10" y="50" font-family="Arial" font-size="20" fill="rgba(255,255,255,0.05)">ﷲ</text></svg>');
            opacity: .1;
        }
        
        .section {
            padding: 80px 0;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 50px;
            padding-bottom: 20px;
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 2.2rem;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        
        .section-title.center:after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .blog-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 0;
            margin-bottom: 30px;
            transition: all 0.4s ease;
            overflow: hidden;
            height: 100%;
        }
        
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .blog-card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .blog-card-content {
            padding: 25px;
        }
        
        .blog-card-date {
            font-size: 0.9rem;
            color: var(--light-text);
            margin-bottom: 10px;
        }
        
        .blog-card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 15px;
            line-height: 1.3;
        }
        
        .blog-card-excerpt {
            color: var(--light-text);
            margin-bottom: 20px;
        }
        
        .blog-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background-color: rgba(13, 110, 110, 0.05);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .blog-card-category {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .read-more-btn {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        
        .read-more-btn:hover {
            color: var(--secondary-color);
        }
        
        .sidebar-widget {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .widget-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent-color);
        }
        
        .categories-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .categories-list li {
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }
        
        .categories-list li:last-child {
            border-bottom: none;
        }
        
        .categories-list a {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .categories-list a:hover {
            color: var(--primary-color);
        }
        
        .categories-list span {
            background-color: var(--light-color);
            padding: 2px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
        }
        
        .recent-post {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee;
        }
        
        .recent-post:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .recent-post-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
        }
        
        .recent-post-content h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }
        
        .recent-post-content .date {
            font-size: 0.8rem;
            color: var(--light-text);
        }
        
        .tags-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .tag {
            background-color: var(--light-color);
            color: var(--text-color);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .tag:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .pagination {
            justify-content: center;
            margin-top: 50px;
        }
        
        .page-link {
            color: var(--primary-color);
            border: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .page-link:hover {
            color: var(--secondary-color);
        }
        
        .islamic-pattern {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path fill="rgba(13,110,110,0.05)" d="M50,0 C60,20 80,20 100,30 C80,40 80,60 90,80 C70,70 50,80 50,100 C50,80 30,70 10,80 C20,60 20,40 0,30 C20,20 40,20 50,0 Z"></path></svg>');
            background-size: 100px 100px;
        }
        
        .footer {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 50px 0 20px;
        }
        
        .footer a {
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.3s;
            text-decoration: none;
        }
        
        .footer a:hover {
            color: #fff;
            text-decoration: underline;
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 30px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }
        
        @media (max-width: 768px) {
            .section {
                padding: 50px 0;
            }
            
            .section-title {
                font-size: 1.8rem;
                margin-bottom: 30px;
            }
            
            .hero {
                min-height: 30vh;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .section-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-mosque"></i> IslamicPrayerTimes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="prayer-times.html">Prayer Times</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="qibla-finder.html">Qibla Finder</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="blog.html">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Islamic Insights Blog</h1>
                    <p class="lead">Explore articles about Islamic teachings, prayer guidance, and spiritual growth</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title">Latest Articles</h2>
                    
                    <div class="row">
                        <!-- Blog Post 1 -->
                        <div class="col-md-6 mb-5">
                            <div class="blog-card">
                                <div class="blog-card-image" style="background-image: url('https://images.unsplash.com/photo-1587132137050-8d0d13146f4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1180&q=80');"></div>
                                <div class="blog-card-content">
                                    <div class="blog-card-date"><i class="far fa-calendar me-2"></i> October 15, 2023</div>
                                    <h3 class="blog-card-title">The Spiritual Benefits of Praying on Time</h3>
                                    <p class="blog-card-excerpt">Discover how praying at the prescribed times can bring peace and discipline to your daily life while strengthening your connection with Allah.</p>
                                    <a href="blog-single.html" class="read-more-btn">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                                <div class="blog-card-footer">
                                    <span class="blog-card-category">Prayer</span>
                                    <span><i class="far fa-clock me-1"></i> 5 min read</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Blog Post 2 -->
                        <div class="col-md-6 mb-5">
                            <div class="blog-card">
                                <div class="blog-card-image" style="background-image: url('https://images.unsplash.com/photo-1601740986596-3f55e545e352?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80');"></div>
                                <div class="blog-card-content">
                                    <div class="blog-card-date"><i class="far fa-calendar me-2"></i> October 10, 2023</div>
                                    <h3 class="blog-card-title">Understanding the Significance of Qibla Direction</h3>
                                    <p class="blog-card-excerpt">Learn about the historical and spiritual importance of facing the Qibla during prayers and how it unites Muslims worldwide.</p>
                                    <a href="blog-single.html" class="read-more-btn">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                                <div class="blog-card-footer">
                                    <span class="blog-card-category">Qibla</span>
                                    <span><i class="far fa-clock me-1"></i> 7 min read</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Blog Post 3 -->
                        <div class="col-md-6 mb-5">
                            <div class="blog-card">
                                <div class="blog-card-image" style="background-image: url('https://images.unsplash.com/photo-1519733755774-a4bfc0eb10a3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');"></div>
                                <div class="blog-card-content">
                                    <div class="blog-card-date"><i class="far fa-calendar me-2"></i> October 5, 2023</div>
                                    <h3 class="blog-card-title">The Importance of Mosque in Muslim Community</h3>
                                    <p class="blog-card-excerpt">Explore the central role mosques play in Islamic society, from worship and education to community building and social services.</p>
                                    <a href="blog-single.html" class="read-more-btn">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                                <div class="blog-card-footer">
                                    <span class="blog-card-category">Community</span>
                                    <span><i class="far fa-clock me-1"></i> 8 min read</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Blog Post 4 -->
                        <div class="col-md-6 mb-5">
                            <div class="blog-card">
                                <div class="blog-card-image" style="background-image: url('https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80');"></div>
                                <div class="blog-card-content">
                                    <div class="blog-card-date"><i class="far fa-calendar me-2"></i> September 28, 2023</div>
                                    <h3 class="blog-card-title">Ramadan Preparation: Spiritual and Physical Readiness</h3>
                                    <p class="blog-card-excerpt">Practical tips to prepare yourself spiritually and physically for the blessed month of Ramadan, ensuring you make the most of this holy period.</p>
                                    <a href="blog-single.html" class="read-more-btn">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                                </div>
                                <div class="blog-card-footer">
                                    <span class="blog-card-category">Ramadan</span>
                                    <span><i class="far fa-clock me-1"></i> 10 min read</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <nav aria-label="Blog pagination">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- About Widget -->
                    <div class="sidebar-widget mb-5">
                        <h3 class="widget-title">About Blog</h3>
                        <p>Islamic Insights provides authentic articles and resources to help Muslims deepen their understanding of Islam and strengthen their faith through knowledge.</p>
                        <div class="text-center mt-4">
                            <a href="about.html" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="sidebar-widget mb-5">
                        <h3 class="widget-title">Categories</h3>
                        <ul class="categories-list">
                            <li><a href="#">Prayer <span>12</span></a></li>
                            <li><a href="#">Quran <span>8</span></a></li>
                            <li><a href="#">Ramadan <span>5</span></a></li>
                            <li><a href="#">Community <span>7</span></a></li>
                            <li><a href="#">Spirituality <span>10</span></a></li>
                        </ul>
                    </div>
                    
                    <!-- Recent Posts Widget -->
                    <div class="sidebar-widget mb-5">
                        <h3 class="widget-title">Recent Posts</h3>
                        <div class="recent-post">
                            <img src="https://images.unsplash.com/photo-1587132137050-8d0d13146f4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1180&q=80" alt="Post" class="recent-post-image">
                            <div class="recent-post-content">
                                <h4><a href="#">The Spiritual Benefits of Praying on Time</a></h4>
                                <div class="date">October 15, 2023</div>
                            </div>
                        </div>
                        <div class="recent-post">
                            <img src="https://images.unsplash.com/photo-1601740986596-3f55e545e352?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Post" class="recent-post-image">
                            <div class="recent-post-content">
                                <h4><a href="#">Understanding the Significance of Qibla Direction</a></h4>
                                <div class="date">October 10, 2023</div>
                            </div>
                        </div>
                        <div class="recent-post">
                            <img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80" alt="Post" class="recent-post-image">
                            <div class="recent-post-content">
                                <h4><a href="#">Ramadan Preparation: Spiritual and Physical Readiness</a></h4>
                                <div class="date">September 28, 2023</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tags Widget -->
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Tags</h3>
                        <div class="tags-cloud">
                            <a href="#" class="tag">Prayer</a>
                            <a href="#" class="tag">Quran</a>
                            <a href="#" class="tag">Sunnah</a>
                            <a href="#" class="tag">Fiqh</a>
                            <a href="#" class="tag">Hadith</a>
                            <a href="#" class="tag">Ramadan</a>
                            <a href="#" class="tag">Charity</a>
                            <a href="#" class="tag">Hajj</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-white mb-4"><i class="fas fa-mosque me-2"></i> IslamicPrayerTimes</h5>
                    <p>Providing accurate prayer times, Islamic resources, and guidance to help Muslims worldwide fulfill their religious obligations.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.html">Home</a></li>
                        <li class="mb-2"><a href="prayer-times.html">Prayer Times</a></li>
                        <li class="mb-2"><a href="qibla-finder.html">Qibla Finder</a></li>
                        <li class="mb-2"><a href="blog.html">Blog</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-4">Prayer Times</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Fajr</a></li>
                        <li class="mb-2"><a href="#">Dhuhr</a></li>
                        <li class="mb-2"><a href="#">Asr</a></li>
                        <li class="mb-2"><a href="#">Maghrib</a></li>
                        <li><a href="#">Isha</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="text-white mb-4">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Islamic Street, Mecca</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +966 12 345 6789</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@islamicprayertimes.com</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <span id="currentYear"></span> IslamicPrayerTimes. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>
</html>