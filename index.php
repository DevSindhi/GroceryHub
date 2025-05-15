<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <!-- CSS Link -->
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>

<body> 
    <header style="background-color: #d4edda; padding: 1rem; border-bottom: 1px solid #c3e6cb;">
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <!-- Logo and Store Name -->
            <a href="./about.html" class="d-flex align-items-center mb-2 mb-lg-0 text-decoration-none">
                <img src="./images/shop-logo.svg" alt="store logo" height="30" class="me-2">
                <span class="fs-4" style="color: #155724; margin-right: 1rem;">GroceryHub</span>
            </a>
    
            <!-- Navigation Links -->
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="./index.php" class="nav-link px-2 text-dark">Home</a></li>
                <li><a href="./about.html" class="nav-link px-2 text-dark">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <li><a class="dropdown-item" href="./fruits.html">Fruits</a></li>
                        <li><a class="dropdown-item" href="./vegetables.html">Vegetables</a></li>
                        <li><a class="dropdown-item" href="./dairy.html">Dairy</a></li>
                        <li><a class="dropdown-item" href="./bakery.html">Bakery</a></li>
                    </ul>
                </li>
            </ul>
    
            <!-- Action Buttons -->
            <div class="text-end">
                <?php if (isset($_SESSION['username'])): ?>
                    <span class="me-3">
                        <i class="bi bi-person-circle" style="font-size: 1.2em; margin-right: 5px;"></i> 
                        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                    </span>
                    <a href="./logout.php" class="btn btn-danger text-white">Logout</a>
                <?php else: ?>
                    <a href="./login.php" class="btn btn-outline-success me-2">Login</a>
                    <a href="./register.php" class="btn btn-success text-white">Sign-up</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <main>
        <div id="starItemsCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#starItemsCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#starItemsCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#starItemsCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
        
            <!-- Carousel Items -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="./images/vegetables.jpg" class="d-block w-100 carousel-img" alt="Fresh Vegetables">
                    <div class="carousel-caption">
                        <h5>Fresh Vegetables</h5>
                        <p>Get the freshest products directly from farms.</p>
                    </div>
                </div>
        
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="./images/fruits.jpg" class="d-block w-100 carousel-img" alt="Organic Fruits">
                    <div class="carousel-caption">
                        <h5>Organic Fruits</h5>
                        <p>Delicious and healthy organic fruits for your family.</p>
                    </div>
                </div>
        
                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img src="./images/dairy.jpg" class="d-block w-100 carousel-img" alt="Dairy Products">
                    <div class="carousel-caption">
                        <h5>Premium Dairy</h5>
                        <p>High-quality milk, cheese, and more.</p>
                    </div>
                </div>
            </div>
        
            <!-- Navigation Arrows -->
            <button class="carousel-control-prev" type="button" data-bs-target="#starItemsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#starItemsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>  
        
    <section class="best-selling-products mt-5">
    <h2 class="text-center">🔥 Best Selling Products</h2>
    <div class="best-selling-slider-container">
        <button id="best-selling-prevBtn" class="best-selling-slider-btn">&#10094;</button>
        <div class="best-selling-slider-wrapper">
            <div class="best-selling-slider">
                <div class="best-selling-product" data-name="Milk" data-price="60">
                    <img src="./images/dairy/milk.jpg" alt="Milk">
                    <h3>Milk</h3>
                    <p>₹60/litre</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Apple" data-price="80">
                    <img src="./images/fruits/apple.jpg" alt="Apple">
                    <h3>Apple</h3>
                    <p>₹80/kg</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Tomato" data-price="40">
                    <img src="./images/vegetables/tomato.jpg" alt="Tomato">
                    <h3>Tomato</h3>
                    <p>₹40/kg</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Mango" data-price="150">
                    <img src="./images/fruits/mango.jpg" alt="Mango">
                    <h3>Mango</h3>
                    <p>₹150/kg</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Cheese" data-price="700">
                    <img src="./images/dairy/cheese.jpg" alt="Cheese">
                    <h3>Cheese</h3>
                    <p>₹700/kg</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Bread" data-price="50">
                    <img src="./images/bakery/bread.jpg" alt="Bread">
                    <h3>Bread</h3>
                    <p>₹50/loaf</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Cauliflower" data-price="50">
                    <img src="./images/vegetables/cauliflower.jpg" alt="Cauliflower">
                    <h3>Cauliflower</h3>
                    <p>₹50/kg</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Garlic Bread" data-price="90">
                    <img src="./images/bakery/garlic-bread.jpg" alt="Garlic Bread">
                    <h3>Garlic Bread</h3>
                    <p>₹90/loaf</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
                <div class="best-selling-product" data-name="Butter" data-price="600">
                    <img src="./images/dairy/butter.jpg" alt="Butter">
                    <h3>Butter</h3>
                    <p>₹600/kg</p>
                    <button class="add-to-cart">Add to Cart</button>
                </div>
            </div>
        </div>
        <button id="best-selling-nextBtn" class="best-selling-slider-btn">&#10095;</button>
    </div>
    </section>

    </main>

    <div class="container my-5">
        <footer class="bg-success text-white w-100">
            <div class="container-fluid px-4 py-5">
                <div class="row text-center text-md-start">
                    <!-- Logo & Description -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="rounded-circle bg-white shadow d-flex align-items-center justify-content-center mx-auto mb-3"
                            style="width: 120px; height: 120px;">
                            <img src="./images/footer-logo.webp" height="80" alt="GroceryHub Logo" loading="lazy" />
                        </div>
                        <p class="small" style="text-align: center;">Your trusted online grocery store. GroceryHub delivers fresh products at your doorstep.</p>
                    </div>
    
                    <!-- Categories -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="fw-bold text-uppercase mb-3">Categories</h5>
                        <ul class="list-unstyled">
                            <li><a href="./fruits.html" class="footer-link">Fruits</a></li>
                            <li><a href="./vegetables.html" class="footer-link">Vegetables</a></li>
                            <li><a href="./bakery.html" class="footer-link">Bakery</a></li>
                            <li><a href="./dairy.html" class="footer-link">Dairy</a></li>
                        </ul>
                    </div>
    
                    <!-- Contact -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="fw-bold text-uppercase mb-3">Contact</h5>
                        <ul class="list-unstyled">
                            <li><p>123, GroceryHub Street, Anand, India</p></li>
                            <li><p>+91 7778889999</p></li>
                            <li><p>support@groceryhub.com</p></li>
                        </ul>
                    </div>  
                </div>
            </div>
    
            <!-- Copyright -->
            <div class="text-center py-3 w-100 footer-bottom">
                <p class="mb-0">© 2025 GroceryHub. All rights reserved.</p>
            </div>
        </footer>
    </div>
    
  <!-- Floating Cart Button -->
  <button class="cart-button" onclick="window.location.href='cart.php'">🛒 View Cart</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>
