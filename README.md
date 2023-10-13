# Pickup

Finally, the project is public on GitHub. For six months, this project remained private due to the internal rules of the institute in which I was studying, but now I am happy to publish it to everyone.

## Table of Contents

1. [About Pickup](#about-pickup)
2. [Features](#features)
3. [Technologies](#technologies)
4. [Installation](#installation)
5. [Defects](#defects)
6. [Coming Updates](#coming-updates)

## About Pickup

'Pickup' is the result of my capstone project, which was developed as a requirement for obtaining the 'BTEC Higher National Diploma' in English which is the equivalent of 'Brevet de technicien supérieur (BTS)' in French. It is a versatile multi-vendor e-commerce platform designed to cater to small groceries and local businesses, enabling them to showcase their products and seamlessly manage orders from the residents of the same city.

### How It Works

The workflow of 'Pickup' is designed to provide an efficient and user-friendly experience for both customers and store owners:

-   **Client Search and Selection:** Customers initiate their interaction with 'Pickup' by searching for a specific store in their vicinity. Upon finding the store that suits their needs, they proceed to the next steps.

-   **Product Browsing and Cart Management:** Customers have the liberty to explore the range of products made available by the store owner. They can easily add desired items to their cart, creating a personalized shopping list.

-   **Order Placement:** When customers are content with their selection, they have the option to place an order. At this point, the order amount is deducted from the client's balance. However, it's important to note that the order remains pending, subject to acceptance or rejection by the store owner.

-   **Store Owner Confirmation:** Store owners hold the authority to accept or reject incoming orders. If the order is rejected, the money is promptly refunded to the client's balance.

-   **Order Preparation:** If the store owner accepts the order, they proceed to prepare it for pickup. Once the order is ready for collection, the store owner updates its status to "Ready."

-   **Client Notification:** To ensure transparency and timeliness, a notification is sent to the client, alerting them that their order is now "Ready To Pick."

-   **In-Store Pickup Process:** Upon receiving the notification, the client physically visits the store to claim their order. They approach the seller and request to pick up their items.

-   **Order Confirmation and Payment:** To conclude the process, the seller initiates a "Pick Request." The client confirms the pickup, and at this point, the funds are transferred from the client's balance to the store's balance, finalizing the transaction seamlessly.

'Pickup' is aimed at streamlining the purchasing experience for local businesses and residents, offering an intuitive way to connect sellers and buyers within the same city.

## Features

It's essential to understand that the project caters to three distinct user roles: Admin, Seller, and Client. The following features represent the primary functionalities and capabilities allocated to each of these user roles.

**Admin:**

-   Voucher Categories Management
-   Vouchers Management
-   Brands Management
-   Sectors Management
-   Fees Management
-   Verification Requests Management
-   Payment Requests Management
-   Received Notifications Viewing
-   Subscriptions Viewing
-   Support Tickets Management
-   Orders Viewing
-   Sales Viewing
-   Customers Management
-   Sellers Management
-   Money Transfers Viewing
-   Stores Management
-   Earnings, Expenses, and Income Statistics Viewing
-   Profile Management

**Seller:**

-   Balance Management
-   Verification Requests Management
-   Payment Requests Management
-   Stores Management
-   Store Subscriptions Management
-   Categories Management
-   Products Management
-   Orders Management
-   Sales Management
-   Received Notifications Viewing
-   Support Tickets Management
-   Money Transfers Management
-   Earnings, Spending, and Income Statistics Viewing
-   Profile Management

**Client:**

-   Balance Management
-   Product Searching
-   Store Searching
-   Store Access
-   Orders Management
-   Received Notifications Viewing
-   Support Tickets Management
-   Profile Management

## Technologies

### Frontend:

-   **HTML:** The project's user interface is primarily built using HTML. Initially, the HTML pages were created and styled separately from the backend.

-   **CSS:** CSS is used for styling and formatting, ensuring an appealing and consistent visual design throughout the project.

-   **Sass:** Sass, a CSS preprocessor, is employed to enhance the maintainability and modularity of stylesheets.

-   **JavaScript (JS):** JavaScript is utilized to implement interactive and dynamic features on the client side, enhancing user experience and functionality.

### Backend:

-   **Laravel:** The backend of the project is developed using Laravel, a PHP web application framework. Laravel provides a robust and efficient foundation for handling various server-side functionalities.

### Backend Templating:

-   **Blade:** Blade is Laravel's templating engine. It was used to seamlessly integrate the previously created HTML, CSS, and JavaScript components into the Laravel project, facilitating dynamic content generation and template reuse.

### Database:

-   **MySQL:** MySQL serves as the project's relational database management system (RDBMS), storing and managing data efficiently and securely.

### Email Server:

-   **Mailtrap:** [Mailtrap](https://mailtrap.io) is used as the project's email server to facilitate email testing and debugging during development.

### Real-Time Notifications:

-   **Pusher:** [Pusher](https://pusher.com) is implemented to enable real-time notifications, enhancing user engagement and interaction within the application.

## Installation

### Required Programs on Your Machine

Before you begin, ensure you have the following programs and software installed on your machine:

-   [Node.js](https://nodejs.org/): Make sure you have Node.js installed. You can download it from the official website.
-   [PHP 8.1](https://www.php.net/): You'll need PHP 8.1. Ensure that you have PHP installed on your system.

-   [Composer](https://getcomposer.org/): Composer is essential for managing PHP dependencies. If you don't have it installed, follow the installation instructions on the Composer website.

-   [MySQL](https://dev.mysql.com/downloads/mysql/): Install MySQL to manage the project's database.

### Required PHP Extensions

1. **pdo_mysql:**
    - Open your `php.ini` file.
    - Search for the `extension=pdo_mysql` line and ensure it's not commented out (i.e., there is no semicolon before it).
2. **openssl:**

    - In your `php.ini` file, locate the `extension=openssl` line, and ensure it's not commented out.

3. **curl:**

    - In your `php.ini` file, make sure the `extension=curl` line is uncommented.

4. **intl:**

    - Uncomment the `extension=intl` line in your `php.ini` file.

5. **fileinfo:**

    - Check if the `extension=fileinfo` line is uncommented in your `php.ini` file.

6. **mbstring:**
    - In the `php.ini` file, ensure that the `extension=mbstring` line is uncommented.

### Required Accounts

1. **Pusher:**

    - Create an account on [Pusher](https://pusher.com/).
    - After signing in, create a new app within Pusher and obtain the credentials from your Pusher dashboard.

2. **Mailtrap:**
    - Sign up for an account on [Mailtrap](https://mailtrap.io/).
    - Mailtrap will be used for handling emails sent to users.

### Cloning and Running the Project

Now that you have the required software and accounts, follow these steps to get the project up and running on your local machine:

1. Clone the project from GitHub:

    ```
    git clone https://github.com/Mohamed-Mkadem/Pickup.git
    ```

2. Navigate to the project directory:

    ```
    cd pickup
    ```

3. Install PHP dependencies using Composer:

    ```
    composer install
    ```

4. Copy the `.env.example` file to `.env`:

    ```
    cp .env.example .env
    ```

    \*"Copying the .env.example file to .env is a common practice in Laravel web development. The .env file serves as a configuration file where you set environment-specific details for your application, such as database connections and API keys. By creating this file, you can securely store sensitive information separate from your codebase".

5. Generate a new application key:

    ```
    php artisan key:generate
    ```

6. Configure your `.env` file with the necessary credentials for MySQL, Pusher, and Mailtrap:  
   here's a list of important configuration settings that you should consider updating in your `.env` file, along with their purpose:

```plaintext
# App Configuration
APP_NAME=Pickup
APP_ENV=local
APP_KEY=          # Laravel application key (it will be generated for you on the previous step)
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

# Broadcast Driver (Important)
BROADCAST_DRIVER=pusher

# Mail Configuration (for Mailtrap, you get this info from the mailtrap account)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls

# Pusher Configuration (You get this info from pusher after creating an app )
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=mt1
```

7. Run database migrations:

    ```
    php artisan migrate
    ```

Certainly, to provide more detailed instructions and make it clear where users can find these seeder files to customize the values, you can add the following information:

8. Seed the Database Tables:

**Admin and Fees Seeding:**

-   First, navigate to the project's root directory.
-   In the `database/seeders` directory, you'll find the seeder files you need:
    -   `AdminSeeder.php` for seeding admin User.
    -   `FeeSeeder.php` for seeding the subscription fee.
-   Open these seeder files with a code editor of your choice to customize the initial data as needed (change the email and the password of the admin as you like).
-   Once you've made any necessary changes, run the following commands to seed the tables:

    ```bash
    php artisan db:seed
    ```

This command will populate the `users` and `fees` tables with your customized data.

8. Install JavaScript dependencies:

    ```
    npm install
    ```

9. Build the frontend assets:

    ```
    npm run dev
    ```

10. Start the development server:

    ```
    php artisan serve
    ```

11. Access the project in your web browser at [http://127.0.0.1:8000](http://127.0.0.1:8000).

These steps will help you set up the project on your local machine, ensuring that you have all the required programs, extensions, and accounts in place to run it successfully.

## Defects

Within the development process, various factors, including limited knowledge, the 'Getting Things Done' (GTD) approach, and time constraints, have led to certain mistakes and imperfections in the project. It's important to acknowledge these issues, and I am committed to addressing and rectifying them promptly

**Database Architecture:**

1. The database architecture is not suitable for medium to large projects, as all store data is stored in a single database. This could lead to performance issues as the number of stores and data grows.

**JavaScript Structure:**

1. Inconsistent JavaScript structure: Some pages require specific JavaScript implementations, leading to code repetition and a lack of code modularity.

**Blade Templates:**

1. Repeated code in Blade templates: Not using Blade template components leads to code repetition and makes it harder to maintain and update.

**Routing:**

1. Poor routing implementation: Manual implementation of routes results in a large number of routes, making it challenging to manage.

**Backend Implementation:**

1. Implementation of functionalities in the backend: Some functionalities are not implemented optimally, and the code could be cleaner and more efficient.

**Dark Mode:**

1. Dark mode issues on Mozilla Firefox: The dark mode doesn't work correctly on Mozilla Firefox, potentially due to specificity issues. A solution is needed to address this problem.

**Asynchronous Programming:**

1. Lack of asynchronous programming: Synchronous programming leads to excessive page refreshes and a suboptimal user experience when interacting with the server.

## Coming Updates

1. **Defect Fixes:** I recognize the imperfections within the current project, and I'm committed to addressing and rectifying them. This includes optimizing the database architecture, enhancing JavaScript structure, and improving the code quality and performance throughout the project.

2. **Server Deployment:** Pickup will soon be deployed to a server, providing greater accessibility and stability for users.

3. **Statistics Functionality:** I'll be implementing comprehensive statistics functionality for both administrators and sellers. This feature will offer valuable insights into sales, orders, earnings, and more.

4. **Affiliate Program:** Pickup will introduce an affiliate program, allowing users to earn rewards by referring new clients and sellers to the platform.

5. **Reporting System:** I understand the importance of maintaining a safe and respectful environment for all users. A reporting system will be added to report abuse, inappropriate content, and false information, ensuring a secure and trustworthy community.

These are just a few of the upcoming updates and features planned for Pickup. I am continually working to enhance the platform and provide an even better experience for users. Stay tuned for more exciting updates in the near future
