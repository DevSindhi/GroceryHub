# Grocery Store Website

An online grocery store built with PHP and HTML, allowing users to browse product categories, add items to a cart, and place orders. The backend uses PostgreSQL for database operations.

## 📁 Project Structure
grocery/
├── index.php # Home page
├── about.html # About page
├── fruits.html # Fruits category
├── vegetables.html # Vegetables category
├── bakery.html # Bakery category
├── dairy.html # Dairy category
├── login.php # User login
├── register.php # User registration
├── logout.php # User logout
├── cart.php # Shopping cart page
├── add_to_cart.php # Add item to cart
├── remove_cart.php # Remove item from cart
├── update_cart.php # Update cart quantities
├── checkout.php # Checkout process
├── db_connection.php # PostgreSQL database connection
├── css/ # Stylesheets
├── js/ # JavaScript files
└── images/ # Image assets


---

## 🚀 Features

- 🛒 Add to cart and manage quantities
- 📦 Category-based item browsing
- 👤 User authentication (Login/Register)
- 📱 Responsive layout with clean UI
- 💳 Checkout system (basic)
- 🔐 PostgreSQL-based secure backend

---

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: PostgreSQL
- **Server**: XAMPP (Apache for PHP; PostgreSQL installed separately)

---

## ⚙️ Setup Instructions

1. **Install XAMPP**: [https://www.apachefriends.org](https://www.apachefriends.org)
2. **Install PostgreSQL**: [https://www.postgresql.org/download/](https://www.postgresql.org/download/)
3. **Move Project Folder**:
   - Place the `grocery` folder inside `htdocs` (`C:/xampp/htdocs/grocery`)
4. **Start Server**:
   - Open XAMPP Control Panel and start **Apache**
   - Start your PostgreSQL service separately
5. **Configure Database**:
   - Create a database (e.g., `grocery_db`) in PostgreSQL
   - Import tables using SQL script (not included here—ensure you create one)
   - Update `db_connection.php` with your PostgreSQL credentials
6. **Run Project**:
   - Go to [http://localhost/grocery](http://localhost/grocery)

---

## 👨‍💻 Author

- **Dev Sindhi** 



