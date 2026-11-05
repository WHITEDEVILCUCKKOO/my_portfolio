CREATE DATABASE IF NOT EXISTS abhi_portfolio CHARACTER SET utf8mb4;
USE abhi_portfolio;
CREATE TABLE admins(id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL);
CREATE TABLE settings(skey VARCHAR(50) PRIMARY KEY, svalue TEXT NOT NULL);
CREATE TABLE skills(id INT AUTO_INCREMENT PRIMARY KEY, category VARCHAR(80) NOT NULL, name VARCHAR(80) NOT NULL);
CREATE TABLE services(id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(120) NOT NULL, sort_order INT NOT NULL DEFAULT 0);
CREATE TABLE projects(id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, category VARCHAR(120) NOT NULL, description TEXT NOT NULL, tech VARCHAR(255) NOT NULL DEFAULT '', live_url VARCHAR(255) NOT NULL DEFAULT '', screenshot VARCHAR(255) NOT NULL DEFAULT '', sort_order INT NOT NULL DEFAULT 0);
CREATE TABLE experience(id INT AUTO_INCREMENT PRIMARY KEY, role VARCHAR(120) NOT NULL, company VARCHAR(120) NOT NULL DEFAULT '', period VARCHAR(80) NOT NULL DEFAULT '', details TEXT NOT NULL, sort_order INT NOT NULL DEFAULT 0);
CREATE TABLE messages(id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(100), email VARCHAR(150), phone VARCHAR(30), subject VARCHAR(150), message TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

INSERT INTO settings VALUES
('name','Abhi'),('title','Full-Stack Web Developer & Web Designer'),
('site_description','Portfolio of Abhi, a Full-Stack Web Developer and Web Designer working with PHP, Python, Flask, Django and REST APIs.'),
('hero_heading','Building modern websites and powerful web applications'),
('hero_sub','Full-Stack Web Developer & Web Designer specializing in PHP, Python, Flask, Django, REST APIs and responsive web development.'),
('hero_stack','PHP,Python,Flask,Django,MySQL,REST APIs'),
('about','I am a Web Designer and Full-Stack Web Developer with practical experience in designing, developing, maintaining and deploying responsive, dynamic websites. My work covers the frontend, databases, APIs, admin panels, e-commerce features, hosting, server configuration and website maintenance.'),
('backend_text','I work with PHP and Python for backend development and build web applications with Flask and Django. I also work on REST API development, API integration, authentication, testing, management and documentation.'),
('email',''),('phone',''),('github',''),('linkedin',''),('cv_url','');
INSERT INTO skills(category,name) VALUES
('Languages','PHP'),('Languages','Python'),('Languages','C'),('Languages','C++'),('Languages','JavaScript'),('Languages','SQL'),
('Frontend','HTML5'),('Frontend','CSS3'),('Frontend','Bootstrap'),('Frontend','Responsive Web Design'),
('API & Backend','Flask'),('API & Backend','Django'),('API & Backend','REST API Development'),('API & Backend','API Integration'),
('Database','MySQL'),('Database','SQL'),
('Tools & Hosting','Git'),('Tools & Hosting','GitHub'),('Tools & Hosting','cPanel'),('Tools & Hosting','FastPanel'),('Tools & Hosting','XAMPP');
INSERT INTO services(title,sort_order) VALUES
('Website Design',1),('Frontend Development',2),('PHP Development',3),('Python Development',4),('Flask & Django Development',5),('API & REST API Development',6),('Database Management',7),('E-commerce Development',8),('Admin Panel Development',9),('Website Maintenance',10),('Hosting & Deployment',11);
INSERT INTO projects(name,category,description,tech,live_url,sort_order) VALUES
('Vedayur Healthcare','Healthcare Website','Healthcare website development, enquiry forms, PHP integration, hosting and email configuration.','PHP','https://vedayurhealthcare.com/',1),
('Eagletfly','Education / Institute Website','Institute website development, admin panel, course management, banner management, video management and database integration.','','',2),
('Prudentia Learning','Learning Platform','Landing page development, deck page development and UI improvements.','','',3),
('King Digital','Business Website','Website development, UI improvements, URL rewriting, maintenance and technical troubleshooting.','.htaccess','https://www.kingdigital.in/',4),
('Shivam Uniform','E-commerce Website','E-commerce website development, product management, category management, image uploads and MySQL database operations.','MySQL','https://shivamuniform.com/',5),
('Groom Car','Car Rental Website','Website project.','','https://www.groomcar.co.in/',6),
('Daur Productions','Creative Production Website','Website project.','','https://daurproductions.com/',7),
('PythonAnywhere Web Application','Python Web Application','Web application hosted on PythonAnywhere. Framework and features to be confirmed.','Python','https://abhicuckoo404.pythonanywhere.com/',8);
