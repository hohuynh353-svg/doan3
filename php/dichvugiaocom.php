<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch Vụ Giao Cơm Tận Nơi - Chất Lượng Hàng Đầu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #ff6b35 0%, #f9ca24 100%);
            color: white;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .header-content {
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }

        .header h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
            to { text-shadow: 2px 2px 20px rgba(255,255,255,0.5), 0 0 30px rgba(255,255,255,0.3); }
        }

        .header p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(45deg, #fff, #f8f9fa);
            color: #ff6b35;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .cta-button:hover::before {
            left: 100%;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Main Content */
        .main-content {
            padding: 4rem 0;
            background: linear-gradient(to bottom, #f8f9fa, #ffffff);
        }

        .service-intro {
            text-align: center;
            margin-bottom: 4rem;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .service-intro h2 {
            font-size: 2.5rem;
            color: #ff6b35;
            margin-bottom: 1rem;
            position: relative;
        }

        .service-intro h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(45deg, #ff6b35, #f9ca24);
            border-radius: 2px;
        }

        .service-intro p {
            font-size: 1.2rem;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Features Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.8s ease-out both;
        }

        .feature-card:nth-child(1) { animation-delay: 0.2s; }
        .feature-card:nth-child(2) { animation-delay: 0.4s; }
        .feature-card:nth-child(3) { animation-delay: 0.6s; }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(45deg, #ff6b35, #f9ca24);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: bounce 2s ease-in-out infinite;
        }

        .feature-card:nth-child(2) .feature-icon { animation-delay: 0.5s; }
        .feature-card:nth-child(3) .feature-icon { animation-delay: 1s; }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .feature-card h3 {
            font-size: 1.5rem;
            color: #ff6b35;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.7;
        }

        /* Commitment Section */
        .commitment {
            background: linear-gradient(135deg, #ff6b35, #f9ca24);
            color: white;
            padding: 4rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .commitment::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: cover;
        }

        .commitment-content {
            position: relative;
            z-index: 1;
        }

        .commitment h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            animation: fadeInDown 1s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .commitment-text {
            font-size: 1.3rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        /* Stats Section */
        .stats {
            background: #f8f9fa;
            padding: 3rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            animation: countUp 2s ease-out;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            color: #ff6b35;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #666;
            margin-top: 0.5rem;
        }

        @keyframes countUp {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Contact Section */
        .contact {
            background: linear-gradient(to right, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .contact h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .contact-item {
            background: rgba(255,255,255,0.1);
            padding: 1.5rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
        }

        .contact-item h3 {
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 2rem 0;
        }

        /* Floating Elements */
        .floating-rice {
            position: fixed;
            pointer-events: none;
            z-index: -1;
            font-size: 2rem;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-rice:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-rice:nth-child(2) {
            top: 50%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-rice:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2.5rem;
            }
            
            .header p {
                font-size: 1.1rem;
            }
            
            .service-intro h2,
            .commitment h2,
            .contact h2 {
                font-size: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Elements -->
    <div class="floating-rice">🍚</div>
    <div class="floating-rice">🥘</div>
    <div class="floating-rice">🍱</div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <h1>🍚 Dịch Vụ Giao Cơm Tận Nơi</h1>
                <p>Chất lượng - Nhanh chóng - Tin cậy</p>
                <a href="#contact" class="cta-button">🚚 Đặt Ngay Hôm Nay</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <section class="service-intro">
                <h2>Cam Kết Phục Vụ Tận Tâm</h2>
                <p>
                    <strong>Giao cơm tận nơi là trách nhiệm của chúng tôi</strong>, mọi ưu tiên về quyền lợi 
                    và sự hài lòng của khách hàng là tiêu chí hàng đầu. Chúng tôi hiểu rằng bữa cơm không chỉ 
                    là việc ăn uống mà còn là sự quan tâm, là niềm tin mà khách hàng dành cho chúng tôi.
                </p>
            </section>

            <section class="features">
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h3>Giao Hàng Nhanh Chóng</h3>
                    <p>
                        Cam kết giao cơm trong vòng 30 phút. Đội ngũ shipper chuyên nghiệp, 
                        luôn sẵn sàng phục vụ khách hàng 24/7. Cơm nóng hổi đến tay bạn đúng giờ.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">⭐</div>
                    <h3>Chất Lượng Đảm Bảo</h3>
                    <p>
                        Nguyên liệu tươi ngon được chọn lọc kỹ càng. Quy trình chế biến đạt chuẩn 
                        vệ sinh an toàn thực phẩm. Mỗi suất cơm là một tác phẩm nghệ thuật ẩm thực.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💝</div>
                    <h3>Dịch Vụ Tận Tâm</h3>
                    <p>
                        Đội ngũ chăm sóc khách hàng nhiệt tình, chu đáo. Lắng nghe và đáp ứng 
                        mọi yêu cầu của khách hàng. Sự hài lòng của bạn là niềm hạnh phúc của chúng tôi.
                    </p>
                </div>
            </section>
        </div>
    </main>

    <!-- Commitment Section -->
    <section class="commitment">
        <div class="container">
            <div class="commitment-content">
                <h2>🎯 Sứ Mệnh Của Chúng Tôi</h2>
                <p class="commitment-text">
                    Chúng tôi không chỉ đơn thuần là dịch vụ giao cơm, mà là người bạn đồng hành 
                    trong cuộc sống hàng ngày của bạn. Với tinh thần "<strong>Khách hàng là trung tâm</strong>", 
                    chúng tôi cam kết mang đến những bữa cơm ngon miệng, dinh dưỡng và tiện lợi nhất. 
                    Mọi phản hồi của khách hàng đều được chúng tôi ghi nhận và cải thiện không ngừng.
                </p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">10,000+</span>
                    <div class="stat-label">Khách hàng hài lòng</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">50,000+</span>
                    <div class="stat-label">Suất cơm đã giao</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">99%</span>
                    <div class="stat-label">Đánh giá tích cực</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">24/7</span>
                    <div class="stat-label">Phục vụ không nghỉ</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <h2>📞 Liên Hệ Đặt Cơm</h2>
            <p>Sẵn sàng phục vụ bạn mọi lúc, mọi nơi!</p>
            
            <div class="contact-info">
                <div class="contact-item">
                    <h3>📱 Hotline</h3>
                    <p>1900 1234<br>0123 456 789</p>
                </div>
                <div class="contact-item">
                    <h3>🌐 Website</h3>
                    <p>www.giacom24h.vn<br>Đặt online dễ dàng</p>
                </div>
                <div class="contact-item">
                    <h3>📧 Email</h3>
                    <p>info@giacom24h.vn<br>support@giacom24h.vn</p>
                </div>
                <div class="contact-item">
                    <h3>📍 Khu vực phục vụ</h3>
                    <p>Toàn TP. Cần Thơ<br>Mở rộng toàn quốc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Dịch Vụ Giao Cơm Tận Nơi. Tất cả quyền được bảo lưu.</p>
            <p>Phục vụ từ trái tim - Giao cơm với tình yêu ❤️</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add floating animation to CTA button
        const ctaButton = document.querySelector('.cta-button');
        setInterval(() => {
            ctaButton.style.transform = 'translateY(-3px) scale(1.05)';
            setTimeout(() => {
                ctaButton.style.transform = 'translateY(-3px) scale(1)';
            }, 200);
        }, 3000);

        // Animate stats numbers
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(stat => {
                        const finalNumber = stat.textContent;
                        stat.style.animation = 'countUp 2s ease-out forwards';
                    });
                }
            });
        }, observerOptions);

        const statsSection = document.querySelector('.stats');
        if (statsSection) {
            observer.observe(statsSection);
        }

        // Add parallax effect to floating elements
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelectorAll('.floating-rice');
            
            parallax.forEach((element, index) => {
                const speed = 0.5 + (index * 0.1);
                element.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
            });
        });
    </script>
</body>
</html>