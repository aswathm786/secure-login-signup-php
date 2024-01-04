
### Security Measures

- **`config.php` Location:** The `config.php` file is placed outside the web root directory to prevent direct access via the web server.
- **Database Information:** Database credentials are stored securely in the `config.php` file using constants or variables and accessed securely within the application.
- **Gmail Information:** If using Gmail for SMTP authentication, credentials or tokens are stored securely in the `config.php` file and accessed securely within the application.

### Usage

1. Clone the repository.
2. Set up your database and import the necessary tables (if any).
3. Modify the `config.php` file in the `includes/` directory with your database and Gmail credentials.
4. Ensure proper security measures are implemented based on best practices.
5. Run the application and explore the signup and login functionalities.

### Disclaimer

This project serves as an example and educational resource. Always follow best practices and consider additional security measures based on your specific project needs.
