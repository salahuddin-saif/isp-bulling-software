## ISP Billing System (PHP)

An ISP billing web application built with vanilla PHP (MVC-style), featuring:

- User registration/login with roles (user/admin)
- Plans, invoices, payments
- Stripe Checkout integration (test mode) with webhooks
- Post-payment network access hook (pluggable service)
- Responsive UI using Bootstrap 5

### Requirements

- PHP 8.1+
- PDO extension (MySQL)
- MySQL 8+
- OpenSSL, cURL extensions

Optional:
- Composer (only if you plan to add libraries; this project uses no vendor libs by default)

### Setup

1) Create a database and a DB user.

2) Copy `.env.example` to `.env` and set values:

```
APP_ENV=local
APP_KEY=
APP_URL=http://localhost:8000

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=isp_billing
DB_USERNAME=root
DB_PASSWORD=

STRIPE_SECRET_KEY=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...

NETWORK_PROVIDER=mock
NETWORK_PROVIDER_BASE_URL=
NETWORK_PROVIDER_USERNAME=
NETWORK_PROVIDER_PASSWORD=
```

3) Generate `APP_KEY` (32 random chars). You can use:

```bash
php -r "echo bin2hex(random_bytes(16));"
```

4) Import schema:

```bash
mysql -u <user> -p < isp_billing < database/schema.sql
```

5) Start server from project root:

```bash
php -S localhost:8000 -t public
```

6) Configure your Stripe test keys and add a webhook endpoint to:

`{APP_URL}/webhook/stripe`

Listen to events: `checkout.session.completed`.

7) Admin user: Manually set `role` to `admin` for your user in `users` table to access the admin panel.

### Notes

- If `STRIPE_SECRET_KEY` is empty, the app switches to Demo Payment mode: invoices can be marked as paid via a button for development.
- Network access integration is provided via `app/Services/NetworkAccessService.php` with a `mock` implementation and a place to add your real RADIUS/MikroTik logic.


