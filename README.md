# User-Registration-Form
HTML form for user registration (username, email, password). Posts data to the processing script.

# 🌐 PHP & MySQL Web Development Experiments

This repository contains solutions for a series of web development assignments focused on building fundamental server-side functionality using **PHP** and **MySQL**. The experiments cover database connection, full CRUD (Create, Read, Update, Delete) operations, and basic security measures like prepared statements and password hashing.

---

## 🛠️ Setup Instructions

To run these experiments locally, you will need a server environment with PHP and MySQL (e.g., XAMPP, MAMP, or WAMP).

1.  **Clone the Repository:**
    ```bash
    git clone [YOUR_REPOSITORY_URL]
    cd [repository-name]
    ```

2.  **Database Configuration:**
    * Start your Apache and MySQL services.
    * Open your MySQL tool (phpMyAdmin, etc.).
    * Execute the SQL commands in the `setup.sql` file (located in Experiment 1) to create the `web_experiment_db` database and the initial `users` table.
    * **CRITICAL:** Update the database connection credentials (`$servername`, `$username`, `$password`, `$dbname`) in **ALL** PHP files to match your local environment.

3.  **Run Experiments:**
    * Place all PHP and HTML files in your local web server's root directory (e.g., `/htdocs` or `/www`).
    * Access the files via your browser (e.g., `http://localhost/index.php`).

---

## 🧪 Experiments Summary (CRUD Operations)

### 2. User Registration Form (CREATE)

| File | Description |
| :--- | :--- |
| `register.html` | Client-side form to collect registration data (name, email, password). |
| `process_registration.php` | Server-side script that handles form submission, uses **`password_hash()`** (for security), and executes a secure **INSERT** query using **prepared statements**. |
