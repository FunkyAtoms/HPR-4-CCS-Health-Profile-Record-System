# HPR-4-CCS-Health-Profile-Record-System

## 1. What to Download

- **XAMPP** (for Apache, PHP, and MySQL):  
  [Download XAMPP](https://www.apachefriends.org/index.html)

- **SQL Database File**  
  (Provided with this project, e.g., `hpr3_database.sql`)

- **A Modern Web Browser**  
  (e.g., Chrome, Firefox, Edge)

---

## 2. Setting Up XAMPP and the Database

### a. Install XAMPP

1. Download and install XAMPP from the official website.
2. Launch the XAMPP Control Panel.
3. Start the **Apache** and **MySQL** modules.

### b. Set Up the Project Files

1. Copy the entire `HPR_3` project folder into `C:\xampp\htdocs\`.
2. Your project path should be:  
   `C:\xampp\htdocs\HPR_3\`

### c. Import the Database

1. Open your browser and go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
2. Click **New** to create a new database (e.g., `hpr3_db`).
3. With the new database selected, click **Import**.
4. Choose the provided SQL file (e.g., `hpr3_database.sql`) and click **Go**.
5. Wait for the import to finish. You should now see the tables in your database.

### d. Configure Database Connection (if needed)

- Open `db_connection.php` (or similar config file).
- Make sure the database name, username, and password match your XAMPP/MySQL setup:
    ```php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hpr3_db";
    ```
- Save any changes.

---

## 3. Basic Instructions on How to Use the Website

### a. Access the Website

- Open your browser and go to:  
  [http://localhost/HPR_3/](http://localhost/HPR_3/)

### b. Main Features

- **Add Employee:**  
  Fill out the form to add a new employee to the database.

- **View Employees:**  
  See a list of all employees. Click on a row to view details.

- **Update Employee:**  
  Select an employee to update their information.

- **Remove Employee:**  
  Select an employee to remove them from the database.

- **Statistics:**  
  View charts and tables summarizing employee data.  
  You can also export statistics as a PDF.

### c. Sidebar Navigation

- Use the sidebar (☰ button) to navigate between pages.

### d. Exporting Data

- On the **View Employees** or **Statistics** page, use the "Convert to PDF" or "Export to PDF" button to download or preview a PDF of the data.

---

## 4. Troubleshooting

- If you see a blank page or errors, check that:
  - Apache and MySQL are running in XAMPP.
  - The database is imported and configured correctly.
  - PHP errors are enabled for debugging (optional: add `ini_set('display_errors', 1);` at the top of PHP files).

---

**Enjoy using your Employee Management System!**
