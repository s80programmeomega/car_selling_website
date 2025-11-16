<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <a href="{{ route('car.index') }}" class="footer-logo">
                    <img src="{{ asset('img/logoipsum-265.svg') }}" alt="Logo" />
                </a>
                <p class="footer-tagline">Find your dream car with confidence. Quality vehicles, trusted sellers,
                    seamless experience.</p>
                <div class="footer-social">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('car.search') }}">Browse Cars</a></li>
                    <li><a href="{{ route('car.create') }}">Sell Your Car</a></li>
                    <li><a href="{{ route('my-cars') }}">My Listings</a></li>
                    <li><a href="{{ route('favorites') }}">Favorites</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Support</h3>
                <ul class="footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-title">Stay Connected</h3>
                <p class="footer-newsletter-text">Get the latest deals and updates delivered to your inbox.</p>
                <form class="footer-newsletter">
                    <input type="email" placeholder="Your email address" class="footer-input" />
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Car Marketplace. All rights reserved. Built with passion for car enthusiasts.</p>
        </div>
    </div>
</footer>

<style>
    html {
        min-height: 100vh;
    }

    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
    }

    .footer {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        color: #e4e4e4;
        padding: 60px 0 20px;
        margin-top: auto;
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }

    .footer-section {
        display: flex;
        flex-direction: column;
    }

    .footer-logo img {
        height: 40px;
        margin-bottom: 16px;
    }

    .footer-tagline {
        color: #b8b8b8;
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .footer-social {
        display: flex;
        gap: 12px;
    }

    .footer-social a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e4e4e4;
        transition: all 0.3s ease;
    }

    .footer-social a:hover {
        background: var(--primary-color, #3b82f6);
        transform: translateY(-3px);
    }

    .footer-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #fff;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: #b8b8b8;
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 14px;
    }

    .footer-links a:hover {
        color: var(--primary-color, #3b82f6);
        padding-left: 4px;
    }

    .footer-newsletter-text {
        color: #b8b8b8;
        font-size: 14px;
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .footer-newsletter {
        display: flex;
        gap: 8px;
    }

    .footer-input {
        flex: 1;
        padding: 10px 14px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        font-size: 14px;
    }

    .footer-input::placeholder {
        color: #888;
    }

    .footer-input:focus {
        outline: none;
        border-color: var(--primary-color, #3b82f6);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 24px;
        text-align: center;
    }

    .footer-bottom p {
        color: #888;
        font-size: 14px;
        margin: 0;
    }

    @media (max-width: 768px) {
        .footer {
            padding: 40px 0 20px;
        }

        .footer-content {
            gap: 30px;
        }

        .footer-newsletter {
            flex-direction: column;
        }
    }
</style>
