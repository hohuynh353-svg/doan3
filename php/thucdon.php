<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thực Đơn Nhà Hàng</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #8B4513 0%, #D2B48C 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .menu-container {
            max-width: 600px;
            margin: 0 auto;
            background: linear-gradient(145deg, #F5E6D3 0%, #E8D5C1 100%);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            position: relative;
        }

        .header {
            background: linear-gradient(145deg, #8B4513, #5D2E0A);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .logo {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
            backdrop-filter: blur(10px);
        }

        .menu-title {
            color: white;
            font-size: 3rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-left: 20px;
        }

        .menu-items {
            padding: 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0;
            margin-bottom: 2px;
            background: linear-gradient(90deg, #F5E6D3 0%, #E8D5C1 100%);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .menu-item:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .menu-item:nth-child(even) {
            background: linear-gradient(90deg, #E8D5C1 0%, #DBC4A7 100%);
        }

        .food-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 15px 20px;
            border: 4px solid rgba(139, 69, 19, 0.3);
            transition: transform 0.3s ease;
        }

        .menu-item:hover .food-image {
            transform: scale(1.1);
        }

        .food-info {
            flex: 1;
            padding: 20px 0;
        }

        .food-name {
            font-size: 1.4rem;
            font-weight: bold;
            color: #5D2E0A;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .food-description {
            color: #8B4513;
            font-size: 0.95rem;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .food-ingredients {
            color: #A0522D;
            font-size: 0.85rem;
            font-style: italic;
        }

        .price {
            background: linear-gradient(145deg, #8B4513, #5D2E0A);
            color: white;
            padding: 15px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            min-width: 80px;
            text-align: center;
            margin: 15px 20px 15px 0;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .drinks-section {
            background: linear-gradient(90deg, #DEB887 0%, #D2B48C 100%);
            padding: 20px 0;
            margin-top: 20px;
        }

        .drinks-item {
            background: linear-gradient(90deg, #F5DEB3 0%, #DEB887 100%);
            margin-bottom: 1px;
        }

        .drinks-item .food-image {
            width: 80px;
            height: 80px;
            margin: 10px 15px;
        }

        .drinks-item .food-name {
            font-size: 1.2rem;
        }

        .drinks-item .price {
            margin: 10px 15px 10px 0;
            padding: 10px 15px;
            font-size: 1rem;
        }

        .footer {
            background: linear-gradient(145deg, #8B4513, #5D2E0A);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .contact-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
        }

        .hotline {
            font-weight: bold;
        }

        .social {
            opacity: 0.8;
        }

        /* Hiệu ứng hover cho toàn bộ menu item */
        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .menu-item:hover::before {
            left: 100%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .menu-container {
                margin: 10px;
                border-radius: 15px;
            }
            
            .menu-title {
                font-size: 2rem;
                margin-left: 10px;
            }
            
            .food-image {
                width: 80px;
                height: 80px;
                margin: 10px 15px;
            }
            
            .food-name {
                font-size: 1.1rem;
            }
            
            .food-description {
                font-size: 0.85rem;
            }
            
            .price {
                padding: 10px 15px;
                font-size: 1rem;
                margin: 10px 15px 10px 0;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 10px;
            }
        }

        /* Animation khi load trang */
        .menu-item {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .menu-item:nth-child(1) { animation-delay: 0.1s; }
        .menu-item:nth-child(2) { animation-delay: 0.2s; }
        .menu-item:nth-child(3) { animation-delay: 0.3s; }
        .menu-item:nth-child(4) { animation-delay: 0.4s; }
        .menu-item:nth-child(5) { animation-delay: 0.5s; }
        .menu-item:nth-child(6) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="menu-container">
        <div class="header">
            <div class="logo">RESTAURANT LOGO</div>
            <div class="menu-title">THỰC ĐƠN</div>
        </div>

        <div class="menu-items">
            <div class="menu-item" onclick="selectItem(this)">
                <div class="food-image" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23FF6B35%22/><text x=%2250%22 y=%2260%22 text-anchor=%22middle%22 font-size=%2240%22>🍛</text></svg>') center/cover;"></div>
                <div class="food-info">
                    <div class="food-name">CƠM TẤM SÀI GÒN</div>
                    <div class="food-description">Cơm tấm truyền thống Sài Gòn với sườn nướng thơm phức</div>
                    <div class="food-ingredients">Cơm tấm, thịt nướng nướng, đá bầu, trứng, dưa leo, nước mắm</div>
                </div>
                <div class="price">89K</div>
            </div>

            <div class="menu-item" onclick="selectItem(this)">
                <div class="food-image" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23FF4444%22/><text x=%2250%22 y=%2260%22 text-anchor=%22middle%22 font-size=%2240%22>🍜</text></svg>') center/cover;"></div>
                <div class="food-info">
                    <div class="food-name">BÚN BÒ HUẾ</div>
                    <div class="food-description">Món bún truyền thống miền Trung với nước dùng đậm đà</div>
                    <div class="food-ingredients">Bún, thịt bò, giò heo, gà heo, chả cua, ăn kèm rau</div>
                </div>
                <div class="price">89K</div>
            </div>

            <div class="menu-item" onclick="selectItem(this)">
                <div class="food-image" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23FFD700%22/><text x=%2250%22 y=%2260%22 text-anchor=%22middle%22 font-size=%2240%22>🍝</text></svg>') center/cover;"></div>
                <div class="food-info">
                    <div class="food-name">MÌ HOÀNH THÁNH</div>
                    <div class="food-description">Mì tươi dai ngon với hoành thánh tôm thịt</div>
                    <div class="food-ingredients">Mì, hoành thánh, thịt heo băm, trứng cút, tôm tươi</div>
                </div>
                <div class="price">89K</div>
            </div>

            <div class="menu-item" onclick="selectItem(this)">
                <div class="food-image" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23228B22%22/><text x=%2250%22 y=%2260%22 text-anchor=%22middle%22 font-size=%2240%22>🍜</text></svg>') center/cover;"></div>
                <div class="food-info">
                    <div class="food-name">MÌ QUẢNG HỘI AN</div>
                    <div class="food-description">Đặc sản miền Trung với nước dùng đậm đà</div>
                    <div class="food-ingredients">Cơm tấm, thịt nướng nướng, đá bầu, trứng, dưa leo, nước mắm</div>
                </div>
                <div class="price">89K</div>
            </div>
        </div>

        <div class="drinks-section">
            <div class="drinks-item menu-item" onclick="selectItem(this)">
                <div class="food-image" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23FFA500%22/><text x=%2250%22 y=%2260%22 text-anchor=%22middle%22 font-size=%2340%22>🧋</text></svg>') center/cover;"></div>
                <div class="food-info">
                    <div class="food-name">TRÀ SỮA OLONG</div>
                    <div class="food-description">Trà oolong sữa tươi, trân châu đen, trái châu trắng đá</div>
                </div>
                <div class="price">39K</div>
            </div>

            <div class="drinks-item menu-item" onclick="selectItem(this)">
                <div class="food-image" style="background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2250%22 cy=%2250%22 r=%2245%22 fill=%22%23FF69B4%22/><text x=%2250%22 y=%2260%22 text-anchor=%22middle%22 font-size=%2240%22>🥤</text></svg>') center/cover;"></div>
                <div class="food-info">
                    <div class="food-name">SINH TỐ CÁC LOẠI</div>
                    <div class="food-description">Sinh tố bơ các loại trái cây tươi ngày</div>
                    <div class="food-ingredients">Dâu tây, dừa đũ, bơ, măng cầu</div>
                </div>
                <div class="price">39K</div>
            </div>
        </div>

        <div class="footer">
            <div class="contact-info">
                <div class="hotline">HOTLINE: 123-456-7890</div>
                <div class="social">@reallygreatcafe</div>
            </div>
        </div>
    </div>

    <script>
        function selectItem(element) {
            // Remove previous selection
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('selected');
            });
            
            // Add selection to clicked item
            element.classList.add('selected');
            
            // Add pulse effect
            element.style.animation = 'pulse 0.6s ease-in-out';
            setTimeout(() => {
                element.style.animation = '';
            }, 600);
            
            // Get item info
            const name = element.querySelector('.food-name').textContent;
            const price = element.querySelector('.price').textContent;
            
            // Show selection feedback
            showSelection(name, price);
        }

        function showSelection(name, price) {
            // Create notification
            const notification = document.createElement('div');
            notification.innerHTML = `
                <div style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(145deg, #8B4513, #5D2E0A);
                    color: white;
                    padding: 15px 20px;
                    border-radius: 10px;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
                    z-index: 1000;
                    animation: slideIn 0.3s ease;
                ">
                    <strong>Đã chọn:</strong> ${name}<br>
                    <strong>Giá:</strong> ${price}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.02); }
                100% { transform: scale(1); }
            }
            
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            .menu-item.selected {
                background: linear-gradient(90deg, #FFE4B5 0%, #F0E68C 100%) !important;
                border-left: 5px solid #8B4513;
            }
            
            .menu-item.selected .food-name {
                color: #8B4513;
            }
        `;
        document.head.appendChild(style);

        // Add loading animation
        window.addEventListener('load', () => {
            const items = document.querySelectorAll('.menu-item');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>