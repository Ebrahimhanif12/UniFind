# UniFind - Campus Lost & Found System

**UniFind** is a web-based Lost and Found management system designed specifically for universities. It helps students report lost items, return found items, and keeps everything organized securely.

The goal is to replace messy Facebook groups and email chains with a dedicated, secure platform where items are tracked from "Lost" to "Found" to "Returned."

---

##  Key Features

###  For Students
* **Smart Feed:** View all lost and found items in one place. Items currently at the Admin Office show a special **"IN CUSTODY"** badge.
* **Post Items:** Easily report a lost item or post something you found.
* **Secure Claims:** If you find an item, you can set a **Security Question**. The owner must answer it correctly to get your contact info.
* **Karma Points:** Earn points for being a good samaritan! You get points when you return an item successfully.
* **Missing Posters:** One-click generation of a **PDF Missing Poster** with a photo and QR code to print and stick around campus.
* **Keyword Alerts:** Subscribe to words like "Blue Wallet." If someone posts it later, you get an email alert automatically.
* **Profile:** Customize your profile with a nickname, phone number, and profile picture.

###  For Staff (Admin Office)
* **Custody Log:** Manage items that are physically handed over to the office. Track who dropped it off and who picked it up.
* **Fraud Control:** The system automatically detects suspicious users (e.g., users who fail security questions 3 times) so you can **Ban** them.
* **Insights:** View charts showing "High Risk Locations" and "Common Lost Categories" on campus.
* **QR System:** Generate QR tags for items stored in the secure safe.

###  For System Owner (Admin)
* **System Control:** Toggle features ON/OFF (like disabling new posts during holidays).
* **Announcements:** Post colorful banners (Info, Warning, Urgent) that appear on every student's dashboard (e.g., "Library Closed Tomorrow").
* **Backups:** Download a full database backup with one click.

---

##  Tech Stack

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP (Native)
* **Database:** MySQL
* **Charts:** Chart.js (for analytics)
* **Server:** Apache (via XAMPP)

---

##  How to Install

1.  **Download XAMPP:** Make sure you have XAMPP installed to run PHP and MySQL.
2.  **Clone the Project:**
    * Copy the `UniFind` folder into your XAMPP `htdocs` directory (usually `C:\xampp\htdocs\`).
3.  **Setup Database:**
    * Open your browser and go to `http://localhost/phpmyadmin`.
    * Create a new database named `unifind_db`.
    * Click **Import** and select the `unifind_db.sql` file provided in the `database` folder.
4.  **Configure Connection:**
    * Open `Student/MVC/db/db_conn.php`.
    * Check that the username is `root` and password is empty (default for XAMPP).
5.  **Run:**
    * Open your browser and go to: `http://localhost/UniFind/Student/MVC/html/login.php`

---

##  Project Structure

* **Admin/** - Files for the System Owner (Settings, User Management).
* **Staff/** - Files for Office Staff (Custody, Fraud, Insights).
* **Student/** - Main interface for students.
    * `MVC/html/` - All the view files (Dashboard, Feed, Posters).
    * `MVC/php/` - The logic files (Login, Claims, Alerts).
    * `MVC/css/` - Styling files.
    * `MVC/uploads/` - Where user images are stored.

---

##  Usage Highlights

**1. Claiming an Item:**
When a student sees a "Found" item, they click **Claim**. They must answer a security question set by the finder (e.g., "What is the color of the keychain?").
* **Correct Answer:** They get the finder's phone number.
* **Wrong Answer:** The attempt is recorded. 3 wrong answers = User flagged for fraud.

**2. The Custody Chain:**
If a student finds a wallet but doesn't want to hold it, they drop it at the Admin Office.
* Staff marks it as **"In Custody"**.
* The status on the feed changes to a Blue Badge: **"IN CUSTODY (Office)"**.
* The owner visits the office to pick it up.

---

##  Author

**Ebrahim Hanif**
* **Student ID:** 23-50034-1
* **Course:** Web Technologies
* **Section:** K
* **University:** American International University-Bangladesh (AIUB)

**Sirazum Munira Munni**
* **Student ID:** 22-48379-3
* **Course:** Web Technologies
* **Section:** K
* **University:** American International University-Bangladesh (AIUB)

**Supervised by:**
**SULTANUL ARIFEEN HAMIM**
Faculty, Dept of Computer Science
American International University-Bangladesh (AIUB)

---

*Project created for the Final Term Project Spring 2026.*