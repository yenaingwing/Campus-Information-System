# Campus Information System

A comprehensive web-based **Campus Information System** designed to manage campus navigation, facilities, departments, buildings, rooms, canteens, and administrative workflows efficiently.

---

## 🚀 Project Overview

The Campus Information System is a full-featured PHP and MySQL-powered application built to streamline campus administration and enhance navigation for students, faculty, and visitors. It includes administrative dashboards, database abstraction classes, secure authentication, and interactive campus mapping/directory tools.

---

## 📂 Directory Structure & Architecture

```text
Campus Information System/
│
├── 📁 classes/               # Core Object-Oriented PHP Classes
│   ├── Auth.php            # User authentication & session handling
│   ├── Building.php        # Building management operations
│   ├── Database.php        # Database connection & query helper
│   ├── Department.php      # Department management operations
│   ├── Room.php            # Room allocation & details
│   └── Search.php          # Global search functionality
│
├── 📁 Public / Pages & Views
│   ├── index.php / aboutus.php # Main landing and information pages
│   ├── canteen1.html       # Campus dining / canteen directory
│   ├── adminpage.php       # Administrative dashboard interface
│   ├── add-new.php         # General record creation interface
│   ├── addnewDepartment.php# Department creation form
│   ├── add_new_building.php# Building creation form
│   ├── delete.php          # General record deletion handler
│   ├── deletebuilding.php  # Building removal handler
│   └── deleteDepartment.php# Department removal handler
│
├── 📁 Assets & Styling
│   ├── admin.css / de.css  # Administrative & general stylesheets
│   ├── campus-nav.css      # Navigation specific styling
│   ├── admin.js / app.js   # Frontend interactivity & scripts
│   ├── campus-nav.js       # Navigation control scripts
│   └── *.jpg               # Campus imagery & background visuals
│
└── 📁 Configuration & Database
    ├── bootstrap.php       # Application bootstrapping & autoloading
    ├── connection.php      # Database connection parameters
    ├── dbcon.php / db_conn.php # Database driver helpers
    ├── dictionary.txt      # System dictionary / localization reference
    └── .htaccess           # Apache server configuration & URL rewriting
```

---

## ✨ Key Features

- **Administrative Dashboard (`adminpage.php`)**: Complete backend control panel for managing buildings, departments, rooms, and system records securely.
- **Object-Oriented Backend**: Modular architecture utilizing dedicated PHP classes (`Auth`, `Building`, `Department`, `Room`, `Search`, `Database`) for clean separation of concerns and maintainability.
- **Dynamic Database Integration**: Robust connection handling (`connection.php`, `dbcon.php`) supporting secure MySQL interactions via PDO or MySQLi.
- **Responsive Frontend & Navigation**: Clean UI styling (`admin.css`, `campus-nav.css`) coupled with intuitive JavaScript interactions (`app.js`, `campus-nav.js`).
- **Facility Management**: Dedicated modules for adding, viewing, and deleting campus buildings and academic departments.
- **Campus Directory & Services**: Integrated information pages covering campus locations, canteens (`canteen1.html`), and student services.

---

## 🛠️ Technology Stack

- **Backend**: PHP (Object-Oriented Architecture)
- **Database**: MySQL / MariaDB (managed via custom `Database` wrapper class)
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache HTTP Server (`.htaccess` configuration supported)

---

## ⚙️ Installation & Setup

1. **Clone or Download Repository**:
   Place the `Campus Information System` directory inside your local web server root (e.g., `htdocs` for XAMPP or `www` for WAMP/LAMP).

2. **Configure Database**:
   - Create a MySQL database for the system.
   - Update your database credentials in `connection.php`, `dbcon.php`, or `db_conn.php` with your host, username, password, and database name.

3. **Start Web Server**:
   - Ensure Apache and MySQL services are running.
   - Access the project in your browser via:
     ```text
     http://localhost/Campus%20Information%20System/
     ```

---

## 🔒 Security & Configuration

- `.htaccess` is included to manage URL routing, secure sensitive files, and enforce clean URL structures.
- Session-based authentication implemented via `classes/Auth.php` to protect administrative routes.

---

## 📄 License

This project is developed for educational and institutional campus management purposes.