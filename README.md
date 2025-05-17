# HPR-4-CCS-Health-Profile-Record-System

## Features

- **Employee CRUD**: Add, view, update, and remove employee records.
- **Statistics Dashboard**: View employee statistics and analytics.
- **PDF Generation**: Generate PDF reports for employee data.
- **Sidebar Navigation**: Easy navigation with a collapsible sidebar.
- **Image Uploads**: Upload and manage employee profile pictures.
- **Responsive UI**: Clean and responsive design using custom CSS.
- **Database Integration**: Uses MySQL for persistent employee data storage.

## Project Structure

- `add_employee.php`, `update_employee.php`, `remove_employee.php`, `view_employee.php`: Core PHP scripts for employee management.
- `statistics.php`: Employee statistics and analytics.
- `generate_pdf.php`: Generates PDF reports using FPDF.
- `libs/`: Third-party libraries (FPDF, etc.).
- `scripts/`: JavaScript files for UI interactivity.
- `styles/`: CSS files for styling.
- `Uploads/`: Uploaded images.
- `emloyeemanagement.sql`: Database schema.

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

**Extract Libraries**

   The `libs` folder is provided as a zip file (`libs.zip`) to reduce repository size.  
   **Extract `libs.zip` into the project root so that you have a `libs/` directory:**

   - On Windows:  
     Right-click `libs.zip` → "Extract All..." → Extract to the current directory.
   - On Linux/macOS:  
     ```sh
     unzip libs.zip
     ```

   After extraction, you should have:
   ```
   libs/
     FPDF/
       fpdf.php
       ...
   ```

## 3. Basic Instructions on How to Use the Website

### a. Access the Website

- Open your browser and go to:  
  [http://localhost/HPR_4/](http://localhost/HPR_4/)

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

## Notes

- The FPDF library is required for PDF generation. Make sure `libs/FPDF/` is present after extraction.
- Only the fonts used in your PDFs need to be present in `libs/FPDF/font/`.

**Enjoy using your Employee Management System!**
