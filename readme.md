
# 🛍️ Super Shop Management System (SSM)

## 📘 Project Description
The **Super Shop Management System (SSM)** is a web-based application designed to help manage and automate the operations of a retail or online store.  
It includes role-based functionalities for **Admin**, **Vendor**, and **Customer**, allowing efficient product management, order tracking, and user interaction.

Built with **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**, this project provides a clean and responsive interface for managing an entire shop system digitally.

### 💡 Motivation
Small and medium shops often struggle with manual inventory and order management.  
This project aims to simplify these operations by providing a digital, role-based management system that is both easy to use and powerful.

### 🎯 Why This Project
- To automate manual shop management processes.  
- To allow vendors to independently manage their products and orders.  
- To provide customers with an easy shopping and review system.  
- To gain real-world web development experience using PHP and MySQL.

### 🧩 Problem It Solves
- Time-consuming manual updates of inventory and sales.  
- Lack of real-time product and order management.  
- Poor tracking of customer feedback.  
- Difficulty managing multiple user roles in a single system.

---

## 🧱 Table of Contents
1. [Features](#-features)
2. [Technologies Used](#-technologies-used)
3. [Installation Guide](#-installation-guide)
4. [Usage Instructions](#-usage-instructions)
5. [Project Structure](#-project-structure)
6. [Screenshots](#-screenshots)
7. [Credits](#-credits)
8. [License](#-license)
9. [How to Contribute](#-how-to-contribute)
10. [Tests](#-tests)
11. [Future Enhancements](#-future-enhancements)

---

## ⚙️ Features
- 🧑‍💼 **Admin Dashboard** – Manage vendors, customers, and all products.  
- 🛒 **Vendor Dashboard** – Add, edit, and approve products.  
- 👥 **Customer Portal** – Browse products, add to cart, and place orders.  
- 💬 **Product Reviews** – Customers can post feedback and ratings.  
- 🔐 **Role-Based Authentication** – Admin, Vendor, and Customer access.  
- 📦 **Order Management** – Vendors and Admins can manage order status.  
- 🧾 **Product Approval System** – Products are verified before display.  

---

## 🛠️ Technologies Used
| Technology | Purpose |
|-------------|----------|
| **PHP** | Backend logic and authentication |
| **MySQL** | Database for user, product, and order data |
| **HTML5** | Page structure |
| **CSS3** | Styling and layout |
| **JavaScript** | Interactivity and validation |
| **XAMPP** | Local server environment |
| **Bootstrap / Custom CSS** | UI Design |
| **FontAwesome** | Icons and visuals |

---

## 🧩 Installation Guide

### Step 1️⃣: Requirements
You’ll need:
- [XAMPP](https://www.apachefriends.org/index.html) installed.
- A web browser (Google Chrome recommended).

### Step 2️⃣: Clone or Download
Clone the project using Git:
```bash
git clone https://github.com/mdAbdullahAnas/SuperShopManagement.git
````

Or manually extract the ZIP file into:

```
C:\xampp\htdocs\
```

### Step 3️⃣: Create Database

1. Start Apache and MySQL in XAMPP.
2. Open **phpMyAdmin**.
3. Create a new database named `ssm`.
4. Import the `ssm.sql` file from the **Database** folder.

### Step 4️⃣: Configure Database

Edit the database connection file:

```
Connection/db.php
```

Update credentials if needed:

```php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ssm";
```

### Step 5️⃣: Run the Project

Open your browser and go to:

```
http://localhost/SSM/
```

---

## 🚀 Usage Instructions

### 🔹 Admin Login

* **Username:** admin
* **Password:** admin123

### 🔹 Vendor Login

* **Username:** vendor
* **Password:** vendor123

### 🔹 Customer Login

* **Username:** customer
* **Password:** customer123

Each role will have different permissions:

* **Admin:** Full access to users, products, and orders.
* **Vendor:** Manage products and order statuses.
* **Customer:** Browse, order, and review products.

---

## 🗂️ Project Structure

```
SSM/
│
├── Connection/
│   └── db.php
│
├── Php/
│   ├── Auth/ (Login, Register, Logout)
│   ├── Admin/
│   ├── Domain/
│   ├── DomainAdmin/
    ├── DomainVendor/
│   ├── DomainCustomer/
│   ├── Product/
│   └── Others/
│
├── Asset/
│   ├── Css/
│   └── Images/
│
├── Database/
│   └── ssm.sql
│
├── index.php
├── README.md
```

---

 

Examples:

* Login Page
* Admin Dashboard
* Vendor Product Management
* Customer Order Page

---

## 👨‍💻 Credits

| Name                  | Role                | GitHub                                             |
| --------------------- | ------------------- | -------------------------------------------------- |
| **Md. Abdullah Anas** | Developer, Designer | [GitHub Profile](https://github.com/mdAbdullahAnas) |

**Resources Used:**

* [W3Schools](https://www.w3schools.com/)
* [PHP.net](https://www.php.net/)
* [YouTube Tutorials](https://www.youtube.com/)

---

 
---

## 🤝 How to Contribute

Contributions are welcome!

To contribute:

1. **Fork** this repository.
2. Create a **new branch**:

   ```bash
   git checkout -b feature-name
   ```
3. **Commit** your changes:

   ```bash
   git commit -m "Add new feature"
   ```
4. **Push** to your fork:

   ```bash
   git push origin feature-name
   ```
5. Submit a **Pull Request**.

---

## 🧪 Tests

To test the system:

1. Register users with different roles (Admin, Vendor, Customer).
2. Add, edit, and delete products.
3. Place and approve orders.
4. Verify database updates in phpMyAdmin.
5. Ensure restricted pages are protected by login.

---

## 🔮 Future Enhancements

* Add **Payment Gateway** integration.
* Enable **Product Image Uploads** for vendors.
* Implement **Live Notifications**.
* Add **Sales Reports & Analytics**.
* Create a **Mobile App version** using Kotlin or Flutter.

---

## 🌟 Final Words

The **Smart Shop Management System (SSM)** is a complete, role-based web application for managing online or offline stores.
It simplifies operations for admins, vendors, and customers through a single, secure system.

> *“Every great system starts with one small script.”* 🚀

```
