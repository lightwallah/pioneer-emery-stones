# Pioneer Emery Stones Website

Professional SEO-optimized website for **Pioneer Emery Stones** — emery stone manufacturer and supplier in Rajasthan, India.

Built with **Core PHP 8+**, **MySQL**, **Bootstrap 5**, and a custom MVC architecture.

## Features

- Multi-language support (English / Hindi) with SEO-friendly URLs (`/en/products`, `/hi/products`)
- Product catalog with categories, specifications, sizes, and brochures
- Product comparison tool
- Blog with categories, tags, and search
- FAQ section with Schema markup
- Customer testimonials
- Contact and Dealer/Distributor inquiry forms
- WhatsApp integration (floating button + pre-filled product messages)
- Admin panel (dashboard, products, blogs, FAQs, inquiries, SEO, settings)
- XML Sitemap, robots.txt, breadcrumbs, JSON-LD schema
- Mobile responsive design (Dark Blue + Orange theme)

## Requirements

- PHP 8.0 or higher
- MySQL 5.7+ / MariaDB
- Apache with `mod_rewrite` enabled (or Nginx equivalent)

## Easy hosting install (cPanel)

1. Upload and unzip the project into `public_html`.
2. Create a MySQL database and user in cPanel.
3. Open `https://yourdomain.com/install.php` (or `/pioneer-emery-stones/install.php`).
4. Enter database details and click **Install website**.
5. Delete `install.php` after it succeeds.

Full steps: see `INSTALL.txt`.

## Installation (manual / localhost)

### 1. Clone / copy project

Place the project in your web server directory, e.g.:
`C:\xampp\htdocs\pioneer-emery-stones\`

### 2. Configure database

Edit `config/database.php`:

```php
'host' => 'localhost',
'dbname' => 'pioneer_emery_stones',
'username' => 'root',
'password' => '',
```

### 3. Import database

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
```

### 4. Configure site URL

Edit `config/app.php` and set your base URL:

```php
'url' => 'http://localhost/pioneer-emery-stones/public',
```

Also update `public/robots.txt` sitemap URL to match your domain.

### 5. Apache setup

Point your virtual host document root to the `public/` folder, or access via:
`http://localhost/pioneer-emery-stones/public/en`

Ensure `.htaccess` is enabled (`AllowOverride All`).

### 6. File permissions

Ensure `public/uploads/` is writable for image uploads.

## Default Admin Login

| Field    | Value    |
|----------|----------|
| URL      | `/admin/login` |
| Username | `admin`  |
| Password | `password` |

**Change the password immediately** after first login via Admin → Settings.

## URL Structure

| URL | Page |
|-----|------|
| `/en` | Home (English) |
| `/hi` | Home (Hindi) |
| `/en/products` | All products |
| `/en/products/natraj-emery-stones` | Category |
| `/en/product/natraj-emery-stone-14-inch` | Product detail |
| `/en/compare` | Product comparison |
| `/en/blog` | Blog listing |
| `/en/faq` | FAQ |
| `/en/contact` | Contact form |
| `/en/dealer-inquiry` | Dealer inquiry |
| `/en/sitemap.xml` | XML sitemap |
| `/admin` | Admin dashboard |

## Project Structure

```
pioneer-emery-stones/
├── app/
│   ├── Controllers/     # Frontend + Admin controllers
│   ├── Core/            # MVC framework (Router, Database, etc.)
│   ├── Models/          # Database models
│   ├── Views/           # Templates
│   └── Helpers/         # Utility functions
├── config/              # App & database config
├── database/            # schema.sql + seed.sql
├── lang/                # en.php, hi.php translations
└── public/              # Web root (index.php, assets, uploads)
```

## SEO Setup

1. **Google Analytics**: Paste tracking code in Admin → Settings
2. **Google Search Console**: Paste verification meta tag in Admin → Settings
3. **Sitemap**: Submit `https://yourdomain.com/en/sitemap.xml` to GSC
4. **Page SEO**: Manage meta titles/descriptions in Admin → SEO

## WhatsApp Configuration

Set your WhatsApp business number in Admin → Settings (`whatsapp_number` field, e.g. `919876543210`).

## Product Images

Upload product images to `public/uploads/products/` and add records to `product_images` table, or extend the admin product forms.

Placeholder images are used when no image is assigned.

## License

Proprietary — Pioneer Emery Stones. All rights reserved.
