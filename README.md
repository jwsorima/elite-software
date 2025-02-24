# **Technical Exam Submission**

## **Project Overview**  
This repository contains my submission for the Technical Exam, including PHP scripts, a Laravel backend, a Vue.js frontend, and MySQL scripts.

## **Folder & File Structure**  

### **Folders**  
- **laravel/album_sales/** – Laravel backend for managing album sales data.  
- **vue-frontend/** – Vue.js frontend for interacting with the Laravel backend.  
- **mysql/** – Contains MySQL-related scripts, including a PHP script for importing CSV data.  

### **Files**  
- **count_islands.php** – PHP script for counting islands in a matrix.  
- **shortest_word.php** – PHP script for finding the shortest word in a string.  
- **word_search.php** – PHP script for searching a target word in a sorted list.  

---

## **1. Running PHP Scripts**  
1. Clone the repository:  
   ```bash
   git clone https://github.com/jwsorima/elite-software
   ```
2. Navigate to the project directory:  
   ```bash
   cd elite-software
   ```
3. Run any of the PHP scripts using:  
   ```bash
   php filename.php
   ```
   *(Replace `filename.php` with the script you want to execute, e.g., `php count_islands.php`.)*  

---

## **2. Running MySQL Import Script**  
1. Make sure MySQL is running and create the required database:  
   ```sql
   CREATE DATABASE music_db;
   ```
2. Run the provided PHP import script to import the CSV data into `music_db`:  
   ```bash
   php mysql/import.php
   ```

---

## **3. Running Laravel Backend (`album_sales/`)**  
1. Navigate to the Laravel project directory:  
   ```bash
   cd laravel/album_sales
   ```
2. Install dependencies:  
   ```bash
   composer install
   ```
3. Copy the environment file and configure database credentials:  
   ```bash
   cp .env.example .env
   ```
   - Update `.env` file to use the `music_db_laravel` database.
4. Generate an application key:  
   ```bash
   php artisan key:generate
   ```
5. Run database migrations and seed data:  
   ```bash
   php artisan migrate --seed
   ```
6. Start the Laravel development server:  
   ```bash
   php artisan serve
   ```

---

## **4. Running Vue.js Frontend (`vue-frontend/`)**  
1. Navigate to the Vue frontend directory:  
   ```bash
   cd vue-frontend
   ```
2. Install dependencies:  
   ```bash
   npm install
   ```
3. Start the development server:  
   ```bash
   npm run dev
   ```

---

## **Contact**  
For any questions or clarifications, feel free to reach out.  
