# Silent Prints - Professional Advertising Website

A modern, responsive advertising website built with Bootstrap 5, PHP, and MySQL.

## Features

- ✨ Modern, responsive design with Bootstrap 5
- 🎨 Beautiful animations and transitions
- 📱 Mobile-friendly navigation
- 💼 Services showcase section
- 🖼️ Portfolio gallery
- 📧 Contact form with database storage
- 🎯 Smooth scrolling and parallax effects
- 🔝 Scroll-to-top button
- 📊 Database-driven content

## Technologies Used

- **Frontend:**
  - HTML5
  - CSS3 (Custom styles with animations)
  - Bootstrap 5.3.0
  - JavaScript (ES6+)
  - Font Awesome 6.4.0
  - Google Fonts (Poppins)

- **Backend:**
  - PHP 7.4+
  - MySQL 5.7+

## Installation Instructions

### Prerequisites

- XAMPP (or similar stack with Apache, PHP, and MySQL)
- Web browser
- Text editor (optional, for customization)

### Setup Steps

1. **Start XAMPP Services:**
   - Open XAMPP Control Panel
   - Start Apache server
   - Start MySQL database

2. **Import Database:**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click on "Import" tab
   - Select the `database.sql` file
   - Click "Go" to import

   Alternatively, you can run the SQL commands directly:
   - Click on "SQL" tab in phpMyAdmin
   - Copy and paste the contents of `database.sql`
   - Click "Go"

3. **Configure Database Connection:**
   - Open `config.php`
   - Verify the database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'silent_prints');
     ```
   - Adjust if your setup is different

4. **Access the Website:**
   - Open your web browser
   - Navigate to: `http://localhost/silent-prints`
   - The website should now be fully functional!

## File Structure

```
silent-prints/
│
├── css/
│   └── style.css           # Custom styles and animations
│
├── js/
│   └── script.js           # Custom JavaScript functionality
│
├── config.php              # Database configuration
├── database.sql            # Database schema and sample data
├── index.php               # Main homepage
├── submit_contact.php      # Contact form handler
├── template-design-a.png   # Design reference
└── README.md               # This file
```

## Features Breakdown

### Homepage Sections

1. **Navigation Bar**
   - Fixed top navigation
   - Smooth scroll to sections
   - Mobile responsive menu
   - Active link highlighting

2. **Hero Section**
   - Full-screen hero with gradient overlay
   - Animated text elements
   - Call-to-action buttons
   - Parallax background effect

3. **About Section**
   - Company information
   - Statistics counters
   - Professional imagery

4. **Services Section**
   - Database-driven service cards
   - Hover animations
   - Icon integration
   - Responsive grid layout

5. **Portfolio Section**
   - Project showcase gallery
   - Category badges
   - Hover effects
   - Image optimization

6. **Contact Section**
   - Contact information cards
   - Interactive contact form
   - Form validation
   - AJAX submission
   - Database storage

7. **Footer**
   - Company information
   - Quick links
   - Social media links
   - Newsletter subscription form
   - Copyright information

## Customization

### Changing Colors

Edit `css/style.css` and modify the CSS variables:

```css
:root {
    --primary-color: #0d6efd;
    --secondary-color: #6c757d;
    --dark-color: #212529;
    --light-color: #f8f9fa;
}
```

### Adding Services

You can add services through phpMyAdmin or by modifying the `database.sql` file:

```sql
INSERT INTO services (title, description, icon, display_order) VALUES
('Your Service', 'Service description', 'fas fa-icon', 5);
```

### Changing Background Images

Replace the image URLs in `index.php` and `css/style.css` with your own images.

## Database Tables

### inquiries
Stores contact form submissions
- id (Primary Key)
- name
- email
- phone
- company
- message
- created_at

### services
Stores service information
- id (Primary Key)
- title
- description
- icon
- is_active
- display_order

### portfolio
Stores portfolio projects
- id (Primary Key)
- title
- description
- image_url
- category
- is_featured
- created_at

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Opera (latest)

## Future Enhancements

- Admin panel for content management
- Blog section
- Testimonials slider
- Team members section
- Dynamic portfolio filtering
- Multi-language support
- Email notifications
- Newsletter system

## Troubleshooting

**Issue: Database connection failed**
- Verify XAMPP MySQL is running
- Check database credentials in `config.php`
- Ensure database is imported correctly

**Issue: Styles not loading**
- Clear browser cache
- Verify file paths are correct
- Check browser console for errors

**Issue: Contact form not working**
- Check database connection
- Verify `submit_contact.php` exists
- Check browser console for JavaScript errors

## License

This project is open source and available for personal and commercial use.

## Support

For questions or support, please contact:
- Email: info@silentprints.com
- Phone: +1 (555) 123-4567

---

**Developed with ❤️ for Silent Prints**
