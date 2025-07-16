<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán - Golden Dragon</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gold: #FFD700;
            --secondary-gold: #FFA500;
            --dark-gold: #B8860B;
            --primary-black: #1a1a1a;
            --secondary-black: #2d2d2d;
            --accent-black: #0a0a0a;
            --gradient-gold: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF8C00 100%);
            --gradient-black: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #0a0a0a 100%);
            --success-color: #4CAF50;
            --error-color: #f44336;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gradient-black);
            min-height: 100vh;
            padding: 20px;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            align-items: start;
        }

        .payment-form {
            background: rgba(255, 215, 0, 0.05);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(10px);
        }

        .customer-info {
            background: var(--gradient-black);
            border: 2px solid var(--primary-gold);
            border-radius: 20px;
            padding: 30px;
            position: sticky;
            top: 20px;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5em;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .header p {
            color: #ccc;
            font-size: 1.1em;
        }

        .order-summary {
            background: rgba(255, 215, 0, 0.1);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .order-summary h3 {
            color: var(--primary-gold);
            margin-bottom: 20px;
            font-size: 1.3em;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        }

        .order-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .item-info h4 {
            color: white;
            margin-bottom: 5px;
        }

        .item-info p {
            color: #ccc;
            font-size: 0.9em;
        }

        .item-price {
            color: var(--primary-gold);
            font-weight: 600;
            font-size: 1.1em;
        }

        .total-section {
            border-top: 2px solid var(--primary-gold);
            padding-top: 20px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-row.final {
            font-size: 1.3em;
            font-weight: 600;
            color: var(--primary-gold);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-gold);
            font-weight: 500;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 10px;
            background: rgba(255, 215, 0, 0.05);
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-gold);
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        }

        .form-group input::placeholder {
            color: #888;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .payment-method {
            padding: 20px;
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 215, 0, 0.05);
        }

        .payment-method:hover {
            border-color: var(--primary-gold);
            transform: translateY(-2px);
        }

        .payment-method.active {
            border-color: var(--primary-gold);
            background: rgba(255, 215, 0, 0.1);
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }

        .payment-method .icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .payment-method .name {
            font-size: 0.9em;
            color: #ccc;
        }

        .pay-button {
            width: 100%;
            padding: 18px;
            background: var(--gradient-gold);
            color: var(--primary-black);
            border: none;
            border-radius: 15px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .pay-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.4);
        }

        .pay-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Customer Info Section */
        .customer-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .customer-header h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-gold);
            margin-bottom: 10px;
        }

        .customer-name {
            font-size: 1.2em;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .customer-tier {
            display: inline-block;
            padding: 5px 15px;
            background: var(--gradient-gold);
            color: var(--primary-black);
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .points-section {
            background: rgba(255, 215, 0, 0.1);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: center;
        }

        .points-display {
            font-size: 3em;
            font-weight: 700;
            color: var(--primary-gold);
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .points-label {
            color: #ccc;
            font-size: 1.1em;
            margin-bottom: 20px;
        }

        .points-value {
            background: rgba(255, 215, 0, 0.2);
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .points-value span {
            color: var(--primary-gold);
            font-weight: 600;
        }

        .discount-section {
            background: rgba(76, 175, 80, 0.1);
            border: 2px solid rgba(76, 175, 80, 0.3);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }

        .discount-section h4 {
            color: var(--success-color);
            margin-bottom: 15px;
            text-align: center;
        }

        .discount-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: rgba(255, 215, 0, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .discount-info {
            flex: 1;
        }

        .discount-info h5 {
            color: var(--primary-gold);
            margin-bottom: 5px;
        }

        .discount-info p {
            color: #ccc;
            font-size: 0.9em;
        }

        .apply-btn {
            padding: 10px 20px;
            background: var(--gradient-gold);
            color: var(--primary-black);
            border: none;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9em;
        }

        .apply-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
        }

        .apply-btn:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
        }

        .applied-discount {
            background: rgba(76, 175, 80, 0.2);
            border-color: var(--success-color);
        }

        .applied-discount .apply-btn {
            background: var(--success-color);
            color: white;
        }

        .loyalty-benefits {
            margin-top: 25px;
        }

        .loyalty-benefits h4 {
            color: var(--primary-gold);
            margin-bottom: 15px;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #ccc;
        }

        .benefit-item .icon {
            margin-right: 10px;
            color: var(--primary-gold);
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: var(--success-color);
        }

        .notification.error {
            background: var(--error-color);
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .payment-form,
            .customer-info {
                padding: 25px;
            }
            
            .payment-methods {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Form Thanh Toán -->
        <div class="payment-form">
            <div class="header">
                <h1>💳 Thanh Toán</h1>
                <p>Hoàn tất đơn hàng của bạn</p>
            </div>

            <div class="order-summary">
                <h3>📋 Tóm Tắt Đơn Hàng</h3>
                <div class="order-item">
                    <div class="item-info">
                        <h4>Phở Bò Wagyu</h4>
                        <p>Số lượng: 1</p>
                    </div>
                    <div class="item-price">350,000đ</div>
                </div>
                <div class="order-item">
                    <div class="item-info">
                        <h4>Tôm Hùm Nướng Mỡ Hành</h4>
                        <p>Số lượng: 1</p>
                    </div>
                    <div class="item-price">890,000đ</div>
                </div>
                <div class="order-item">
                    <div class="item-info">
                        <h4>Rượu Vang Bordeaux</h4>
                        <p>Số lượng: 1</p>
                    </div>
                    <div class="item-price">2,500,000đ</div>
                </div>
                
                <div class="total-section">
                    <div class="total-row">
                        <span>Tạm tính:</span>
                        <span id="subtotal">3,740,000đ</span>
                    </div>
                    <div class="total-row">
                        <span>Thuế VAT (10%):</span>
                        <span id="tax">374,000đ</span>
                    </div>
                    <div class="total-row" id="discountRow" style="display: none;">
                        <span>Giảm giá:</span>
                        <span id="discount">-0đ</span>
                    </div>
                    <div class="total-row final">
                        <span>Tổng cộng:</span>
                        <span id="total">4,114,000đ</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Phương Thức Thanh Toán</label>
                <div class="payment-methods">
                    <div class="payment-method active" onclick="selectPayment(this)">
                        <div class="icon">💳</div>
                        <div class="name">Thẻ Tín Dụng</div>
                    </div>
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="icon">🏦</div>
                        <div class="name">Chuyển Khoản</div>
                    </div>
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="icon">💰</div>
                        <div class="name">Tiền Mặt</div>
                    </div>
                    <div class="payment-method" onclick="selectPayment(this)">
                        <div class="icon">📱</div>
                        <div class="name">Ví Điện Tử</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Họ Tên Khách Hàng</label>
                <input type="text" placeholder="Nhập họ tên..." value="Nguyễn Văn A">
            </div>

            <div class="form-group">
                <label>Số Điện Thoại</label>
                <input type="tel" placeholder="Nhập số điện thoại..." value="0123456789">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="Nhập email..." value="customer@email.com">
            </div>

            <button class="pay-button" onclick="processPayment()">
                💎 Thanh Toán Ngay
            </button>
        </div>

        <!-- Thông Tin Khách Hàng -->
        <div class="customer-info">
            <div class="customer-header">
                <h2>👑 Thông Tin Khách Hàng</h2>
                <div class="customer-name">Nguyễn Văn A</div>
                <div class="customer-tier">VIP Gold</div>
            </div>

            <div class="points-section">
                <div class="points-display">10</div>
                <div class="points-label">Điểm Tích Lũy</div>
                <div class="points-value">
                    Giá trị: <span>100,000đ</span>
                </div>
            </div>

            <div class="discount-section">
                <h4>🎁 Ưu Đãi Có Thể Áp Dụng</h4>
                
                <div class="discount-option" id="discount10">
                    <div class="discount-info">
                        <h5>Giảm 10%</h5>
                        <p>Sử dụng 10 điểm tích lũy</p>
                    </div>
                    <button class="apply-btn" onclick="applyDiscount(10, 10)">
                        Áp Dụng
                    </button>
                </div>

                <div class="discount-option">
                    <div class="discount-info">
                        <h5>Giảm 15%</h5>
                        <p>Sử dụng 15 điểm tích lũy</p>
                    </div>
                    <button class="apply-btn" disabled>
                        Không Đủ Điểm
                    </button>
                </div>

                <div class="discount-option">
                    <div class="discount-info">
                        <h5>Giảm 20%</h5>
                        <p>Sử dụng 20 điểm tích lũy</p>
                    </div>
                    <button class="apply-btn" disabled>
                        Không Đủ Điểm
                    </button>
                </div>
            </div>

            <div class="loyalty-benefits">
                <h4>✨ Quyền Lợi VIP</h4>
                <div class="benefit-item">
                    <span class="icon">🍷</span>
                    <span>Rượu vang miễn phí</span>
                </div>
                <div class="benefit-item">
                    <span class="icon">🅿️</span>
                    <span>Ưu tiên chỗ đậu xe</span>
                </div>
                <div class="benefit-item">
                    <span class="icon">🎂</span>
                    <span>Bánh sinh nhật miễn phí</span>
                </div>
                <div class="benefit-item">
                    <span class="icon">📞</span>
                    <span>Hỗ trợ 24/7</span>
                </div>
            </div>
        </div>
    </div>

    <div class="notification" id="notification"></div>

    <script>
        let currentPoints = 10;
        let appliedDiscount = 0;
        let discountPercentage = 0;
        
        const originalTotal = 4114000;
        const subtotal = 3740000;
        const tax = 374000;

        function selectPayment(element) {
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('active');
            });
            element.classList.add('active');
        }

        function applyDiscount(pointsRequired, percentage) {
            if (currentPoints < pointsRequired) {
                showNotification('Không đủ điểm tích lũy!', 'error');
                return;
            }

            if (appliedDiscount > 0) {
                showNotification('Bạn đã áp dụng ưu đãi rồi!', 'error');
                return;
            }

            // Tính toán giảm giá
            discountPercentage = percentage;
            appliedDiscount = Math.floor(originalTotal * (percentage / 100));
            
            // Cập nhật điểm
            currentPoints -= pointsRequired;
            
            // Cập nhật UI
            updateTotalDisplay();
            updatePointsDisplay();
            updateDiscountButtons();
            
            // Hiển thị dòng giảm giá
            document.getElementById('discountRow').style.display = 'flex';
            
            // Đánh dấu ưu đãi đã áp dụng
            const discountOption = document.getElementById('discount10');
            discountOption.classList.add('applied-discount');
            discountOption.querySelector('.apply-btn').textContent = 'Đã Áp Dụng';
            discountOption.querySelector('.apply-btn').disabled = true;
            
            showNotification(`Áp dụng thành công! Giảm ${percentage}%`, 'success');
        }

        function updateTotalDisplay() {
            const newTotal = originalTotal - appliedDiscount;
            document.getElementById('total').textContent = formatCurrency(newTotal);
            document.getElementById('discount').textContent = `-${formatCurrency(appliedDiscount)}`;
        }

        function updatePointsDisplay() {
            document.querySelector('.points-display').textContent = currentPoints;
            document.querySelector('.points-value span').textContent = formatCurrency(currentPoints * 10000);
        }

        function updateDiscountButtons() {
            const buttons = document.querySelectorAll('.discount-option .apply-btn');
            buttons.forEach((btn, index) => {
                const requiredPoints = [10, 15, 20][index];
                if (currentPoints < requiredPoints && !btn.disabled) {
                    btn.disabled = true;
                    btn.textContent = 'Không Đủ Điểm';
                }
            });
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount).replace('₫', 'đ');
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        function processPayment() {
            const paymentMethod = document.querySelector('.payment-method.active .name').textContent;
            const finalAmount = originalTotal - appliedDiscount;
            
            showNotification(`Thanh toán thành công ${formatCurrency(finalAmount)} qua ${paymentMethod}!`, 'success');
            
            // Simulate payment process
            setTimeout(() => {
                alert('🎉 Thanh toán thành công!\n' +
                      `Phương thức: ${paymentMethod}\n` +
                      `Số tiền: ${formatCurrency(finalAmount)}\n` +
                      `Điểm tích lũy còn lại: ${currentPoints}\n` +
                      'Cảm ơn bạn đã sử dụng dịch vụ!');
            }, 1500);
        }

        // Khởi tạo
        document.addEventListener('DOMContentLoaded', function() {
            updatePointsDisplay();
        });
    </script>
</body>
</html>