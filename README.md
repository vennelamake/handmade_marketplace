# Handmade Marketplace(A multi venodr ecommerce system)

An e-commerce platform for handmade goods with role-based access control for customers, vendors, and admins, offering a secure and user-friendly shopping and management experience.
## Demo Video

[![Watch the video](https://img.youtube.com/vi/OYqT1PnNTYI/0.jpg)](https://www.youtube.com/watch?v=OYqT1PnNTYI&t=38s)



## Table of Contents
1. [Introduction](#introduction)
2. [User Roles](#user-roles)
3. [Features](#features)
4. [System Design](#system-design)
5. [Development](#development)
6. [Proposed Enhancements](#proposed-enhancements)
7. [Technologies Used](#technologies-used)
8. [How to Download and Setup](#how-to-download-and-setup)
9. [Conclusion and References](#conclusion-and-references)
10. [License](#license)

---

## Introduction

**Project Title:** Handmade Marketplace  
**Technologies Used:** PHP, MySQL  

The Handmade Marketplace is an e-commerce website where users can register as customers or vendors, and an admin oversees all operations. It ensures:

- Role-based authentication
- Vendor verification by admin
- Product uploads and orders management
- A smooth shopping and payment experience for customers

---

## User Roles

### 👤 Customer
- Register and login
- Browse products and add to cart
- Checkout and make payments
- View order history

### 🧵 Vendor
- Register with business info and upload proof
- Can login only after **admin approval**
- Upload/manage products
- View orders related to their products

### 🛡️ Admin
- Dedicated dashboard
- Approves or rejects vendor registrations
- Manages users, vendors, products, orders, and payments

---

## Features

### Advantages
- Role-based secure authentication
- Admin-managed vendor approval system
- Real-time order and payment tracking
- User-friendly product listing and cart system

### Limitations
- No physical product inspection before purchase
- Unique nature of products may complicate returns/exchanges

---

## System Design

### Key Components
- **Use Case Diagram**: Defines interactions between users, vendors, and admin
- **Class Diagram**: Shows database relationships and structure
- **Data Dictionary**: Contains field names, types, and constraints for all tables

---

## Development

### Coding Standards
- Secure session-based login system
- Structured, modular PHP code
- Error handling and input validation
- Vendor login protected until admin approval

### Database Schema
Includes tables:
- `users`
- `vendors`
- `admins`
- `products`
- `orders`
- `payments`
- `cart`

---

## Proposed Enhancements
- **Password Hashing**: Encrypt passwords using `password_hash()`
- **Wishlist**: Allow customers to save favorite products
- **Ratings & Reviews**: Enable user feedback
- **Order Tracking**: Real-time updates for orders
- **Vendor Notifications**: Alert on new orders or low inventory
- **Multiple Product Images**: Improve visual experience

---

## Technologies Used
- **Languages**: PHP, SQL
- **Database**: MySQL
- **Frontend**: HTML, CSS
- **Tools**: Visual Studio Code, XAMPP

---

## How to Download and Setup

### 1: Download the Project Using ZIP
1. Visit the [GitHub repository](https://github.com/handmade-marketplace)
2. Click on the green **Code** button and select **Download ZIP**
3. Extract and move the folder to `htdocs` in XAMPP

### 2: Download the Project Using Git
```bash
git clone https://github.com/Dss155/handmade-marketplace.git
```

### 3: Set Up the Database
1. Open **phpMyAdmin**
2. Create a database (e.g., `handmade_marketplace`)
3. Import the `.sql` file from the project folder

---

## Conclusion and References

This project creates a digital bridge between artisans and customers, offering a secure and scalable online marketplace. It encourages creativity and entrepreneurship while giving users a smooth shopping experience.

## References

**Books References**:
- SQL, PL/SQL: The Programming Language of Oracle
- The Joy of PHP Programming
- PHP & MySQL Novice to Ninja

**Website References**:
- W3Schools
- Learn Microsoft
- Google
- YouTube

---

## License
This project is licensed under the [MIT License](LICENSE). You may freely use, modify, and distribute it.



