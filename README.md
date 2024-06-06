# Computer Store Website

This project is a complete website for a computer store, built with a MySQL database. It includes files for the website and a database schema. To run the website, you need to host it on a local server or web hosting service and import the database.

## Features

- Browse various computer products
- Search for products
- View product details
- Add products to the shopping cart
- User registration and login
- Admin panel for managing products and orders

## Requirements

- A web server (e.g., Apache, Nginx)
- PHP 7.0 or higher
- MySQL 5.7 or higher

## Setup Instructions

### 1. Clone the Repository

Clone this repository to your local machine or web server:

```bash
git clone https://github.com/ArtemyAnOff/computer_store.git
cd computer_store
```

### 2. Set Up the Database

1. Create a new MySQL database named `computer_store`.
2. Import the provided SQL file into your new database:

```bash
mysql -u yourusername -p computer_store < path/to/computer_store.sql
```

### 3. Configure the Website

1. Open the `config.php` file in the project directory.
2. Update the database connection settings:

```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'yourusername');
define('DB_PASSWORD', 'yourpassword');
define('DB_DATABASE', 'computer_store');
```

### 4. Deploy the Website

1. If you are using a local server (e.g., XAMPP, WAMP), place the project files in the `htdocs` or `www` directory.
2. If you are using a web hosting service, upload the project files to your hosting account's public HTML directory.

### 5. Access the Website

Open your web browser and go to `http://localhost/computer_store` or your hosting URL to access the website.

## Test Accounts

Use the following test accounts to log in and explore different user roles:

- **Admin**: `admin` / `admin`
- **Employee**: `employee` / `employee`
- **Anime**: `anime` / `anime`
- **User1**: `user1` / `12345678`
- **User2**: `user2` / `0000`

## Usage

- Register as a new user to start shopping.
- Use the admin panel to manage products and orders (accessible only by admin users).

## Contributing

If you want to contribute to this project, please fork the repository and submit a pull request.

## License

This project is licensed under the MIT License.

---

For any questions or issues, please contact [artemy.an.off@gmail.com].

---

Thank you for using the Computer Store Website!
