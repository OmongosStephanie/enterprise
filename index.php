<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>S & R Online Shop</title>
    <style>
        body {
            background-color: #5d6d6d;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #5d6d6d;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 400px;
            border-radius: 5px 0 0 5px;
            border: none;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .nav-bar {
            background-color: blue;
            padding: 15px;
            text-align: center;
        }

        .nav-bar a {
            margin: 0 15px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            padding: 40px;
        }

        .category {
            text-align: center;
        }

        .category img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .category img:hover {
            transform: scale(1.05);
        }

        .category span {
            color: white;
            font-size: 18px;
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">S & R Online Shop</div>
    <div class="search-bar">
        <input type="text" placeholder="Search">
        <button>Search</button>
    </div>
</div>

<div class="nav-bar">
    <a href="#">Groceries</a>
    <a href="#">Fresh</a>
    <a href="#">Pantry</a>
    <a href="#">Frozen</a>
    <a href="#">Membership</a>
</div>

<div class="category-grid">
    <div class="category"><img src="beverages.jpg"><span>Beverages</span></div>
    <div class="category"><img src="bread.jpg"><span>Bread & Bakery</span></div>
    <div class="category"><img src="pantry.jpg"><span>Pantry Items</span></div>
    <div class="category"><img src="eggs.jpg"><span>Eggs & Dairy</span></div>
    <div class="category"><img src="meat.jpg"><span>Meat & Seafood</span></div>
    <div class="category"><img src="frozen.jpg"><span>Frozen Goods</span></div>
    <div class="category"><img src="snacks.jpg"><span>Snacks</span></div>
</div>

</body>
</html>
