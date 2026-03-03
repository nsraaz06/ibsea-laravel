# XAMPP 8.2 Upgrade Guide (No Data Loss)

This guide will help you move your IBSEA projects from XAMPP (PHP 8.0) to XAMPP (PHP 8.2).

## Phase 1: Preparation (The "Safe" Way)

### 1. Export your Databases
Before doing anything, you **must** export your SQL data:
1.  Open XAMPP Control Panel and ensure MySQL is **Running**.
2.  Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3.  Click on the **Export** tab at the top.
4.  Select **"Quick"** and click **Go**. This will download a `.sql` file containing all your databases (including `ibsea_db`).
5.  **Save this file somewhere safe (like your Desktop).**

### 2. Stop Services
1.  In the XAMPP Control Panel, click **Stop** for Apache and MySQL.
2.  Close the XAMPP Control Panel completely.

---

## Phase 2: Protecting your Files

### 3. Rename the Old Folder
Instead of uninstalling (which can be risky), we will just move the old version out of the way.
1.  Open File Explorer and go to `C:\`.
2.  Find the `xampp` folder.
3.  Right-click it and **Rename** it to `xampp_old`.
    > [!IMPORTANT]
    > Your projects are now safely stored in `C:\xampp_old\htdocs\`.

---

## Phase 3: Installation

### 4. Install XAMPP 8.2
1.  Run the XAMPP 8.2 installer you downloaded.
2.  When it asks for the installation folder, ensure it says `C:\xampp` (the default).
3.  Complete the installation.

---

## Phase 4: Restoring Data

### 5. Restore Project Files
1.  Open `C:\xampp_old\htdocs\`.
2.  **Copy** the folders `ibsea` and `ibsea-laravel`.
3.  **Paste** them into the new `C:\xampp\htdocs\`.

### 6. Restore Databases
1.  Start the **new** XAMPP Control Panel and start **Apache** and **MySQL**.
2.  Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3.  Click **Import** at the top.
4.  Choose the `.sql` file you saved to your Desktop in Step 1.
5.  Click **Go** at the bottom.

---

## Phase 5: Verification

### 7. Confirm PHP Version
Visit your diagnostic script:
[http://localhost/ibsea-laravel/public/version_check.php](http://localhost/ibsea-laravel/public/version_check.php)
It should now show **PHP 8.2.x** and a **Green** success message!

### 8. Cleanup
Once you verify everything works, you no longer need the `vendor_patch.php` script, and you can eventually delete the `C:\xampp_old` folder to save space.
