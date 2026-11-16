PLATEAU DIGITAL - VERSION 1.0
=============================

This is the first working foundation for Plateau Digital, an initiative of M & Associates Innovation Hub. It includes a responsive public website, installation wizard, administrator login/dashboard, database foundation and the four public module entry pages.

REQUIREMENTS
- Laragon, XAMPP or equivalent
- PHP 8.0+ (PHP 8.2+ recommended)
- MySQL 5.7+ or MariaDB 10.4+

LOCAL INSTALLATION (LARAGON)
1. Extract the plateau_digital folder into D:\laragon\www\
2. Start Apache and MySQL in Laragon.
3. Visit http://localhost/plateau_digital/install.php
4. Use database name plateau_digital, host 127.0.0.1, username root and blank password for a default Laragon setup. Adjust if your local database credentials differ.
5. Create your administrator name, email and password.
6. When installation succeeds, DELETE install.php from the project folder.
7. Public website: http://localhost/plateau_digital/
8. Admin dashboard: http://localhost/plateau_digital/admin/login.php

IMPORTANT
- Change default database credentials on a live server.
- Keep config/config.php private. Configure the web server document root to this project folder only after protecting config, or preferably configure it to the public directory in a later production-hardening stage.
- Do not upload real customer data until privacy, terms, backups, HTTPS and access controls have been reviewed.
- The logo and launch poster are included in assets/images.
- Domain plateaudigital.ng and social handle @PlateauDigital are not included as verified active services; confirm ownership before publishing them as live links.

NEXT BUILD STAGE
Add admin CRUD for business categories and listings, business owner accounts, approval workflow, talent registration, academy course management and service-request management.


VERSION 1.1 UPDATE - ADMIN MANAGEMENT
After replacing the project files with this update, sign in at /admin/login.php. The dashboard now links to Business Listings, Talent Profiles, Academy Courses, Service Requests and Contact Messages. Administrators can create, edit, approve/publish and delete records. Business categories can be added from the Business Listings page.

UPDATE SAFETY
Back up your existing plateau_digital database and project folder before replacing files. This update uses the existing database tables created by install.php and does not require reinstalling. Do not run install.php again on a live database.


VERSION 1.2 UPDATE: PUBLIC SUBMISSIONS
- Business owners can submit a listing at modules/register_business.php.
- Professionals can submit a profile at modules/join_talent.php.
- New submissions enter pending review and are not publicly visible until approved/published by an administrator.
- No database reinstall is required; the forms use the existing businesses and talent_profiles tables.
- Back up your existing project before replacing files. Keep config/config.php and your database.


VERSION 1.3 - MEMBER ACCOUNTS
New features:
- Public account registration for business owners, talents, students and customers.
- Secure sign-in using password_hash/password_verify and session ID regeneration.
- Member dashboard with account type, activity log and relevant quick actions.
- Sign-out endpoint.

After updating from v1.2, copy the new account/ folder and includes/account.php into the existing project, and replace index.php. Keep config/config.php and your database. The account tables are created automatically the first time an account page is opened.

Registration: /account/register.php
Sign in: /account/login.php
Dashboard: /account/dashboard.php

NOTE: Existing public business/talent submission forms remain available separately. Account ownership linking and student course enrolment will be connected in later updates.
