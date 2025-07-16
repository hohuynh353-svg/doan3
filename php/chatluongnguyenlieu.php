<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chất Lượng Nguyên Liệu Tươi Sống - Hương Vị Tuyệt Vời</title>
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

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #2e8b57 0%, #98fb98 50%, #228b22 100%);
            color: white;
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.1"><circle cx="200" cy="200" r="50" fill="white"/><circle cx="800" cy="300" r="30" fill="white"/><circle cx="300" cy="700" r="40" fill="white"/><circle cx="700" cy="800" r="25" fill="white"/></svg>');
            animation: float 10s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            text-align: center;
            animation: fadeInUp 1.2s ease-out;
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: glow 3s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 2px 2px 4px rgba(0,0,0,0.3); }
            to { text-shadow: 2px 2px 20px rgba(255,255,255,0.6), 0 0 30px rgba(255,255,255,0.4); }
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            font-weight: 300;
        }

        .hero-description {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 3rem;
            line-height: 1.8;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
            40% { transform: translateX(-50%) translateY(-10px); }
            60% { transform: translateX(-50%) translateY(-5px); }
        }

        /* Quality Promise Section */
        .quality-promise {
            padding: 5rem 0;
            background: linear-gradient(to bottom, #f8fff8, #ffffff);
            position: relative;
        }

        .section-title {
            text-align: center;
            font-size: 3rem;
            color: #2e8b57;
            margin-bottom: 1rem;
            position: relative;
            animation: slideInDown 1s ease-out;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(45deg, #2e8b57, #98fb98);
            border-radius: 2px;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .quality-text {
            text-align: center;
            font-size: 1.3rem;
            color: #555;
            max-width: 900px;
            margin: 0 auto 4rem;
            line-height: 1.8;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
            margin: 4rem 0;
        }

        .feature-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.4s ease;
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
                transform: translateY(60px);
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
            height: 6px;
            background: linear-gradient(45deg, #2e8b57, #98fb98, #228b22);
            background-size: 200% 200%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s ease-in-out infinite;
        }

        .feature-card:nth-child(2) .feature-icon { animation-delay: 0.7s; }
        .feature-card:nth-child(3) .feature-icon { animation-delay: 1.4s; }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .feature-card h3 {
            font-size: 1.8rem;
            color: #2e8b57;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }

        .feature-card p {
            color: #666;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        /* Ingredients Showcase */
        .ingredients-showcase {
            background: linear-gradient(135deg, #f0fff0 0%, #e6ffe6 100%);
            padding: 5rem 0;
            position: relative;
        }

        .ingredients-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .ingredient-item {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: zoomIn 0.6s ease-out both;
        }

        .ingredient-item:nth-child(1) { animation-delay: 0.1s; }
        .ingredient-item:nth-child(2) { animation-delay: 0.2s; }
        .ingredient-item:nth-child(3) { animation-delay: 0.3s; }
        .ingredient-item:nth-child(4) { animation-delay: 0.4s; }
        .ingredient-item:nth-child(5) { animation-delay: 0.5s; }
        .ingredient-item:nth-child(6) { animation-delay: 0.6s; }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .ingredient-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(46, 139, 87, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .ingredient-item:hover::before {
            transform: translateX(100%);
        }

        .ingredient-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .ingredient-emoji {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .ingredient-item h4 {
            color: #2e8b57;
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .ingredient-item p {
            color: #666;
            font-size: 0.95rem;
        }

        /* Benefits Section */
        .benefits {
            background: linear-gradient(135deg, #2e8b57, #228b22);
            color: white;
            padding: 5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .benefits::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: pulse 8s ease-in-out infinite;
        }

        .benefits-content {
            position: relative;
            z-index: 1;
        }

        .benefits h2 {
            font-size: 3rem;
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

        .benefits-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .benefit-item {
            background: rgba(255,255,255,0.1);
            padding: 2rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
            animation: slideInLeft 0.8s ease-out both;
        }

        .benefit-item:nth-child(even) {
            animation: slideInRight 0.8s ease-out both;
        }

        .benefit-item:nth-child(1) { animation-delay: 0.2s; }
        .benefit-item:nth-child(2) { animation-delay: 0.4s; }
        .benefit-item:nth-child(3) { animation-delay: 0.6s; }
        .benefit-item:nth-child(4) { animation-delay: 0.8s; }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .benefit-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
        }

        .benefit-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .benefit-item h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        /* Quality Standards */
        .quality-standards {
            background: #f8f9fa;
            padding: 5rem 0;
        }

        .standards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 3rem;
            margin: 3rem 0;
        }

        .standard-card {
            background: white;
            padding: 3rem;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .standard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1);
            background-size: 200% 200%;
            animation: gradientMove 4s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .standard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.12);
        }

        .standard-number {
            font-size: 3rem;
            font-weight: bold;
            color: #2e8b57;
            margin-bottom: 1rem;
        }

        .standard-card h3 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .standard-card p {
            color: #666;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        /* Call to Action */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
            position: relative;
        }

        .cta-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .cta-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            color: white;
            padding: 18px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
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
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        .cta-button:hover::before {
            left: 100%;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 3rem 0;
        }

        .footer p {
            margin-bottom: 1rem;
        }

        /* Floating Vegetables */
        .floating-veggie {
            position: fixed;
            pointer-events: none;
            z-index: -1;
            font-size: 2rem;
            opacity: 0.1;
            animation: floatVeggie 8s ease-in-out infinite;
        }

        .floating-veggie:nth-child(1) {
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .floating-veggie:nth-child(2) {
            top: 70%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-veggie:nth-child(3) {
            bottom: 20%;
            left: 15%;
            animation-delay: 4s;
        }

        .floating-veggie:nth-child(4) {
            top: 40%;
            right: 20%;
            animation-delay: 6s;
        }

        @keyframes floatVeggie {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(90deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
            75% { transform: translateY(-15px) rotate(270deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .ingredients-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
            
            .standards-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Vegetables -->
    <div class="floating-veggie">🥕</div>
    <div class="floating-veggie">🥬</div>
    <div class="floating-veggie">🍅</div>
    <div class="floating-veggie">🥒</div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>🌱 Chất Lượng Nguyên Liệu Tươi Sống</h1>
                <div class="hero-subtitle">Nền tảng của hương vị tuyệt vời</div>
                <p class="hero-description">
                    <strong>Chất lượng nguyên liệu luôn luôn đứng đầu trong các lựa chọn để có một món ăn ngon miệng, sức khỏe.</strong>
                    Chúng tôi hiểu rằng những nguyên liệu tươi sống chính là linh hồn của mỗi món ăn, 
                    là chìa khóa mở ra cánh cửa hương vị tuyệt vời và dinh dưỡng phong phú.
                </p>
            </div>
        </div>
        <div class="scroll-indicator">⬇️</div>
    </section>

    <!-- Quality Promise -->
    <section class="quality-promise">
        <div class="container">
            <h2 class="section-title">🎯 Cam Kết Chất Lượng</h2>
            <p class="quality-text">
                Chúng tôi tin rằng những nguyên liệu tươi sống không chỉ tạo nên hương vị thơm ngon mà còn 
                mang lại giá trị dinh dưỡng cao nhất cho sức khỏe. Mỗi nguyên liệu đều được chọn lọc kỹ càng, 
                từ những nguồn cung cấp uy tín nhất để đảm bảo chất lượng tuyệt đối.
            </p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🌿</div>
                    <h3>Tươi Sống Tự Nhiên</h3>
                    <p>
                        Tất cả nguyên liệu đều được thu hoạch mỗi ngày, đảm bảo độ tươi sống tự nhiên. 
                        Không sử dụng chất bảo quản, không hóa chất độc hại. Mỗi sản phẩm đều giữ nguyên 
                        hương vị và giá trị dinh dưỡng như vừa mới hái từ vườn.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✅</div>
                    <h3>Kiểm Tra Chất Lượng</h3>
                    <p>
                        Quy trình kiểm tra chất lượng nghiêm ngặt từ khâu thu hoạch đến khi đến tay khách hàng. 
                        Đội ngũ chuyên gia thực phẩm kiểm tra từng sản phẩm, đảm bảo đạt chuẩn an toàn 
                        thực phẩm quốc tế.
                    </p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3>Nguồn Gốc Rõ Ràng</h3>
                    <p>
                        Mỗi nguyên liệu đều có nguồn gốc xuất xứ rõ ràng, truy xuất được từ trang trại 
                        đến bàn ăn. Chúng tôi hợp tác với các nhà cung cấp uy tín, có chứng nhận 
                        chất lượng và an toàn thực phẩm.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Ingredients Showcase -->
    <section class="ingredients-showcase">
        <div class="container">
            <h2 class="section-title">🥗 Kho Tàng Nguyên Liệu</h2>
            <p class="quality-text">
                Từ những loại rau củ quả tươi sống đến thịt cá cao cấp, mỗi nguyên liệu đều được 
                chúng tôi lựa chọn tỉ mỉ để mang đến cho bạn những món ăn hoàn hảo nhất.
            </p>

            <div class="ingredients-grid">
                <div class="ingredient-item">
                    <span class="ingredient-emoji">🥬</span>
                    <h4>Rau Xanh Organic</h4>
                    <p>Rau xanh hữu cơ tươi ngon, không thuốc trừ sâu</p>
                </div>

                <div class="ingredient-item">
                    <span class="ingredient-emoji">🥩</span>
                    <h4>Thịt Tươi Cao Cấp</h4>
                    <p>Thịt tươi từ các trang trại đạt chuẩn chất lượng</p>
                </div>

                <div class="ingredient-item">
                    <span class="ingredient-emoji">🐟</span>
                    <h4>Hải Sản Tươi Sống</h4>
                    <p>Hải sản tươi sống được vận chuyển nhanh chóng</p>
                </div>

                <div class="ingredient-item">
                    <span class="ingredient-emoji">🍅</span>
                    <h4>Rau Củ Quả Tươi</h4>
                    <p>Rau củ quả tươi ngon, giàu vitamin và khoáng chất</p>
                </div>

                <div class="ingredient-item">
                    <span class="ingredient-emoji">🌾</span>
                    <h4>Ngũ Cốc Nguyên Chất</h4>
                    <p>Ngũ cốc nguyên hạt không qua chế biến</p>
                </div>

                <div class="ingredient-item">
                    <span class="ingredient-emoji">🥛</span>
                    <h4>Sản Phẩm Sữa Tươi</h4>
                    <p>Sữa tươi và các sản phẩm từ sữa cao cấp</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits">
        <div class="container">
            <div class="benefits-content">
                <h2>💪 Lợi Ích Sức Khỏe</h2>
                <p style="font-size: 1.2rem; margin-bottom: 3rem;">
                    Nguyên liệu tươi sống mang lại những lợi ích tuyệt vời cho sức khỏe và cuộc sống
                </p>

                <div class="benefits-list">
                    <div class="benefit-item">
                        <span class="benefit-icon">🌟</span>
                        <h3>Dinh Dưỡng Tối Ưu</h3>
                        <p>Giữ nguyên vitamin, khoáng chất và các chất dinh dưỡng thiết yếu</p>
                    </div>

                    <div class="benefit-item">
                        <span class="benefit-icon">💚</span>
                        <h3>An Toàn Tuyệt Đối</h3>
                        <p>Không chất bảo quản, không hóa chất độc hại, an toàn cho mọi lứa tuổi</p>
                    </div>

                    <div class="benefit-item">
                        <span class="benefit-icon">😋</span>
                        <h3>Hương Vị Tự Nhiên</h3>
                        <p>Hương vị nguyên bản, thơm ngon và hấp dẫn từ tự nhiên</p>
                    </div>

                    <div class="benefit-item">
                        <span class="benefit-icon">⚡</span>
                        <h3>Năng Lượng Tích Cực</h3>
                        <p>Cung cấp năng lượng tự nhiên, giúp cơ thể luôn tràn đầy sức sống</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">🌍</span>
                        <h3>Bảo Vệ Môi Trường</h3>
                        <p>Nguyên liệu hữu cơ, thân thiện với môi trường và bền vững</p>
                    </div>
                    <div class="benefit-item">
                        <span class="benefit-icon">👨‍👩‍👧‍👦</span>
                        <h3>Phù Hợp Mọi Gia Đình</h3>
                        <p>Đáp ứng nhu cầu dinh dưỡng cho cả gia đình, từ trẻ nhỏ đến người lớn tuổi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
