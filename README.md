# 🛒 Laravel E-Commerce with AI Product Generator

![Laravel E-Commerce](https://res.cloudinary.com/ddf0fuu2a/image/upload/v1743896676/3ea662e0-905f-4e05-979a-53b4d93831ff.png)

A modern e-commerce platform built with Laravel, featuring an AI-powered product generator that automatically creates compelling product descriptions, pricing, and inventory suggestions.

## ✨ Features

-   🤖 **AI Product Generator** - Create product listings instantly using AI
-   🔐 **User Authentication & Authorization** - Secure role-based access control
-   📊 **Admin Dashboard** - Comprehensive analytics at a glance
-   🗃️ **Product Management** - CRUD operations for products and categories
-   🛒 **Shopping Cart** - Intuitive cart functionality
-   💳 **Order Processing** - Complete order lifecycle management

## 📋 Requirements

-   PHP 8.0+
-   Composer
-   MySQL 5.7+ or PostgreSQL
-   Node.js & NPM (for asset compilation)
-   Hugging Face API key for AI functionality

## 🚀 Installation

### Clone the repository

```bash
git clone https://github.com/yourusername/ecommerce-laravel.git
cd ecommerce-laravel
```

### Install dependencies

```bash
composer install
npm install
npm run dev
```

### Set up environment variables

```bash
cp .env.example .env
php artisan key:generate
```

Edit your `.env` file to include database credentials and AI API key:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

HUGGINGFACE_API_KEY=your_api_key_here
HUGGINGFACE_API_URL=https://api-inference.huggingface.co/models/facebook/bart-large-cnn
```

### Run migrations and seeders

```bash
php artisan migrate
php artisan db:seed
```

### Link storage for product images

```bash
php artisan storage:link
```

### Start the server

```bash
php artisan serve
```

## 🏗️ Project Structure

```
e-commerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/            # Admin panel controllers
│   │   │   │   ├── AIProductController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── OrderController.php
│   │   │   │   └── ProductController.php
│   │   │   ├── CartController.php
│   │   │   ├── HomeController.php
│   │   │   ├── OrderController.php
│   │   │   └── ProductController.php
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   ├── Models/
│   │   ├── Category.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Product.php
│   │   └── User.php
│   └── Services/
│       └── MistralAIService.php  # AI integration service
├── resources/
│   └── views/
│       ├── admin/                # Admin panel views
│       │   ├── ai-products/
│       │   │   ├── index.blade.php
│       │   │   └── preview.blade.php
│       │   ├── categories/
│       │   ├── dashboard.blade.php
│       │   ├── orders/
│       │   └── products/
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   └── app.blade.php
│       ├── products/
│       ├── cart/
│       └── orders/
└── routes/
    └── web.php
```

## 🌟 AI Product Generator

One of the standout features of this application is the AI Product Generator, which uses Hugging Face's API to create compelling product descriptions and suggest pricing:

![AI Product Generator](https://res.cloudinary.com/ddf0fuu2a/image/upload/v1743896764/c7f12d38-c581-44f7-a25a-27d7fa825074.png)

### How It Works

1. Admin selects a product category and enters a product name
2. AI generates a complete product profile with:
    - Refined product name
    - Marketing description
    - Suggested price point
    - Recommended inventory level
3. Admin can review, edit, and save the generated product

### Configuration

The AI service can be configured with different models by updating the `.env` file:

```
# Default model (optimized for text generation)
HUGGINGFACE_API_URL=https://api-inference.huggingface.co/models/facebook/bart-large-cnn

# Alternative models
# HUGGINGFACE_API_URL=https://api-inference.huggingface.co/models/gpt2
# HUGGINGFACE_API_URL=https://api-inference.huggingface.co/models/mistralai/Mistral-7B-Instruct-v0.1
```

## 📊 Admin Dashboard

The admin dashboard provides a comprehensive overview of your store's performance:

![Admin Dashboard](https://res.cloudinary.com/ddf0fuu2a/image/upload/v1743896735/ac027bbd-8ab3-4044-9d20-7400d2a3bb21.png)

Features:

-   Sales and revenue metrics
-   Recent orders with status tracking
-   Low-stock product alerts
-   Latest product additions

## 🔒 Security & Roles

The application implements a role-based access control system:

-   **Admin**: Full access to the admin panel and all management functions
-   **User**: Can browse products, place orders, and view order history

## 📱 Responsive Design

The application is fully responsive and works on all device sizes:

![Responsive Design](https://res.cloudinary.com/ddf0fuu2a/image/upload/v1743896822/142345c8-dfbf-43f3-b14b-86b6194e9c3e.png)

## 🛠️ Customization

### Theme Customization

You can customize the appearance by editing the CSS files in `public/css/` or by editing the Blade templates in `resources/views/`.

### Adding Payment Gateways

To add a payment gateway, create a new service in `app/Services/` and implement the necessary payment processing logic.

## 🧪 Testing

Run the test suite with:

```bash
php artisan test
```

## 🌐 Deployment

For production deployment:

1. Set appropriate environment variables
2. Optimize the application:

```bash
php artisan optimize
php artisan route:cache
php artisan config:cache
php artisan view:cache
```

## 📖 API Documentation

API endpoints are documented using Swagger. View the documentation at `/api/documentation` after installing and publishing the Swagger package.

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

Made with ❤️ by Ayoub Benrqiq & Hamza El-alamy
