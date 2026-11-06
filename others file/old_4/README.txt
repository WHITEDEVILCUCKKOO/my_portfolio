SETUP (XAMPP or any PHP 8+ / MySQL host)
1. Copy this folder into htdocs (or public_html).
2. Import schema.sql in phpMyAdmin (it creates the abhi_portfolio database and seeds your data).
3. Edit config.php with your DB user and password.
4. Open /admin/setup.php, create the admin (12+ char password), then DELETE admin/setup.php.
5. Log in at /admin/login.php. Add email, phone, social links, CV link and screenshots under Settings / Projects.
   Screenshot and CV paths must start with assets/ or https://  (e.g. assets/vedayur.jpg).
6. On a live site use HTTPS, and block public access to schema.sql.
Contact form messages are saved to the database and shown in the admin Messages tab (no email is sent).
