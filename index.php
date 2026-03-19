<?php
// Include database configuration
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silent Prints - Professional Advertising Solutions</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#home">
                <i class="fas fa-print me-2"></i>Silent Prints
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-3 fw-bold mb-4 animate-fade-in">Welcome to Silent Prints</h1>
                    <p class="lead mb-5 animate-fade-in-delay">Your Partner in Professional Advertising Solutions</p>
                    <p class="fs-5 mb-5 animate-fade-in-delay-2">We create impactful advertising campaigns that elevate your brand and drive results</p>
                    <div class="animate-fade-in-delay-3">
                        <a href="#services" class="btn btn-primary btn-lg me-3 px-5 py-3">Our Services</a>
                        <a href="#contact" class="btn btn-outline-light btn-lg px-5 py-3">Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.unsplash.com/photo-1556761175-4b46a572b786?w=800" alt="About Us" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-4">About Silent Prints</h2>
                    <p class="lead text-muted mb-4">Creating Exceptional Advertising Experiences Since Day One</p>
                    <p class="mb-4">Silent Prints is a full-service advertising agency dedicated to helping businesses grow through creative and strategic marketing solutions. We combine innovative design with data-driven strategies to deliver campaigns that resonate with your audience.</p>
                    <p class="mb-4">Our team of experienced professionals brings together expertise in print advertising, digital marketing, brand design, and social media management to provide comprehensive solutions tailored to your unique needs.</p>
                    <div class="row mt-5">
                        <div class="col-md-4 text-center mb-3">
                            <div class="h1 text-primary fw-bold">500+</div>
                            <p class="text-muted">Projects Completed</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="h1 text-primary fw-bold">300+</div>
                            <p class="text-muted">Happy Clients</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="h1 text-primary fw-bold">10+</div>
                            <p class="text-muted">Years Experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Our Services</h2>
                <p class="lead text-muted">Comprehensive advertising solutions to help your business thrive</p>
            </div>
            <div class="row g-4">
                <?php
                $services_query = "SELECT * FROM services WHERE is_active = 1 ORDER BY display_order";
                $services_result = $conn->query($services_query);
                
                if ($services_result && $services_result->num_rows > 0) {
                    while($service = $services_result->fetch_assoc()) {
                        echo '<div class="col-lg-3 col-md-6">';
                        echo '    <div class="service-card card h-100 border-0 shadow-sm">';
                        echo '        <div class="card-body text-center p-4">';
                        echo '            <div class="service-icon mb-4">';
                        echo '                <i class="' . htmlspecialchars($service['icon']) . ' fa-3x text-primary"></i>';
                        echo '            </div>';
                        echo '            <h4 class="card-title mb-3">' . htmlspecialchars($service['title']) . '</h4>';
                        echo '            <p class="card-text text-muted">' . htmlspecialchars($service['description']) . '</p>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    // Fallback if no services in database
                    $fallback_services = [
                        ['icon' => 'fas fa-print', 'title' => 'Print Advertising', 'desc' => 'Professional print advertising solutions including brochures, flyers, and posters'],
                        ['icon' => 'fas fa-bullhorn', 'title' => 'Digital Marketing', 'desc' => 'Comprehensive digital marketing strategies to grow your brand online'],
                        ['icon' => 'fas fa-palette', 'title' => 'Brand Design', 'desc' => 'Creative brand identity design and logo creation services'],
                        ['icon' => 'fas fa-share-alt', 'title' => 'Social Media', 'desc' => 'Social media management and content creation for all platforms']
                    ];
                    
                    foreach($fallback_services as $service) {
                        echo '<div class="col-lg-3 col-md-6">';
                        echo '    <div class="service-card card h-100 border-0 shadow-sm">';
                        echo '        <div class="card-body text-center p-4">';
                        echo '            <div class="service-icon mb-4">';
                        echo '                <i class="' . $service['icon'] . ' fa-3x text-primary"></i>';
                        echo '            </div>';
                        echo '            <h4 class="card-title mb-3">' . $service['title'] . '</h4>';
                        echo '            <p class="card-text text-muted">' . $service['desc'] . '</p>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Our Portfolio</h2>
                <p class="lead text-muted">A showcase of our recent advertising projects</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-item card border-0 shadow">
                        <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?w=600" class="card-img-top" alt="Project 1">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Branding</span>
                            <h5 class="card-title">Corporate Identity Design</h5>
                            <p class="card-text text-muted">Complete brand identity package for tech startup</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-item card border-0 shadow">
                        <img src="https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=600" class="card-img-top" alt="Project 2">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Print</span>
                            <h5 class="card-title">Marketing Campaign</h5>
                            <p class="card-text text-muted">Multi-channel print advertising campaign</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-item card border-0 shadow">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600" class="card-img-top" alt="Project 3">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Digital</span>
                            <h5 class="card-title">Social Media Strategy</h5>
                            <p class="card-text text-muted">Comprehensive social media marketing strategy</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-item card border-0 shadow">
                        <img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=600" class="card-img-top" alt="Project 4">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Design</span>
                            <h5 class="card-title">Product Packaging</h5>
                            <p class="card-text text-muted">Creative packaging design for consumer product</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-item card border-0 shadow">
                        <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600" class="card-img-top" alt="Project 5">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Marketing</span>
                            <h5 class="card-title">Billboard Campaign</h5>
                            <p class="card-text text-muted">Eye-catching outdoor advertising campaign</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-item card border-0 shadow">
                        <img src="https://images.unsplash.com/photo-1557426272-fc759fdf7a8d?w=600" class="card-img-top" alt="Project 6">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Web</span>
                            <h5 class="card-title">Website Development</h5>
                            <p class="card-text text-muted">Modern responsive website with e-commerce</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Get In Touch</h2>
                <p class="lead text-muted">Let's discuss how we can help grow your business</p>
            </div>
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                        <h5>Address</h5>
                        <p class="text-muted mb-0">123 Business Street<br>City, State 12345</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                        <h5>Phone</h5>
                        <p class="text-muted mb-0">+1 (555) 123-4567<br>Mon - Fri, 9AM - 6PM</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                        <h5>Email</h5>
                        <p class="text-muted mb-0">info@silentprints.com<br>support@silentprints.com</p>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow">
                        <div class="card-body p-5">
                            <h3 class="mb-4">Send Us a Message</h3>
                            <div id="contactAlert"></div>
                            <form id="contactForm">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Your Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="company" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="company" name="company">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Your Message *</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg px-5">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h4 class="mb-3"><i class="fas fa-print me-2"></i>Silent Prints</h4>
                    <p class="text-muted">Professional advertising solutions to elevate your brand and drive results.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-2x"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home" class="text-muted text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="#about" class="text-muted text-decoration-none">About</a></li>
                        <li class="mb-2"><a href="#services" class="text-muted text-decoration-none">Services</a></li>
                        <li class="mb-2"><a href="#portfolio" class="text-muted text-decoration-none">Portfolio</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">Services</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Print Advertising</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Digital Marketing</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Brand Design</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Social Media</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5 class="mb-3">Newsletter</h5>
                    <p class="text-muted">Subscribe to get latest updates</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="text-center text-muted">
                <p class="mb-0">&copy; 2026 Silent Prints. All rights reserved. | Designed with <i class="fas fa-heart text-danger"></i></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>
