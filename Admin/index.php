<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* Hero Section */
        .hero {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
        }

        .hero button {
            background-color: #e74c3c;
            color: white;
            font-size: 18px;
            padding: 15px 40px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .hero button:hover {
            background-color: #c0392b;
        }

        /* Features Section */
        .features {
            display: flex;
            justify-content: center;
            padding: 50px 20px;
            background-color: #ecf0f1;
        }

        .feature-card {
            background-color: white;
            border: 1px solid #ddd;
            margin: 0 20px;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            width: 250px;
            transition: all 0.3s ease;
        }

        .feature-card h3 {
            margin-bottom: 20px;
        }

        .feature-card p {
            font-size: 16px;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Call to Action Section */
        .cta {
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 60px 20px;
        }

        .cta h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .cta button {
            background-color: #e74c3c;
            color: white;
            font-size: 18px;
            padding: 15px 40px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .cta button:hover {
            background-color: #c0392b;
        }

        /* Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome to Our Platform</h1>
        <p>Your one-stop solution for everything you need.</p>
        <button onclick="window.location.href='signup.php'">Get Started</button>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="feature-card">
            <h3>Easy to Use</h3>
            <p>Our platform is user-friendly and easy to navigate for everyone.</p>
        </div>
        <div class="feature-card">
            <h3>24/7 Support</h3>
            <p>We offer round-the-clock support to ensure you have the best experience.</p>
        </div>
        <div class="feature-card">
            <h3>Secure & Reliable</h3>
            <p>Your data security is our top priority, and we guarantee reliability.</p>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta">
        <h2>Ready to take the next step?</h2>
        <p>Join thousands of happy users today and get started with our platform!</p>
        <button onclick="window.location.href='signup.php'">Sign Up Now</button>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Our Platform. All rights reserved.</p>
    </footer>

</body>
</html>
