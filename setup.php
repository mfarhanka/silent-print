<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silent Prints - Setup Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 50px 0;
        }
        .setup-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .setup-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .setup-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .setup-body {
            padding: 40px;
        }
        .step-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        .step-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            font-weight: bold;
            margin-right: 15px;
        }
        .btn-test {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-test:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .status-success {
            background: #d4edda;
            color: #155724;
        }
        .status-error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <div class="setup-card">
            <div class="setup-header">
                <h1><i class="fas fa-print me-3"></i>Silent Prints</h1>
                <p class="mb-0">Website Setup Guide</p>
            </div>
            
            <div class="setup-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Welcome!</strong> Follow these simple steps to complete your installation.
                </div>

                <div class="step-card">
                    <h4><span class="step-number">1</span> Check Database Connection</h4>
                    <p class="mb-3">First, let's verify your database connection is working properly.</p>
                    <div id="dbStatus">
                        <?php
                        // Test database connection
                        $configFile = 'config.php';
                        if (file_exists($configFile)) {
                            require_once $configFile;
                            
                            if (isset($conn) && $conn->connect_error) {
                                echo '<span class="status-badge status-error"><i class="fas fa-times me-2"></i>Connection Failed: ' . $conn->connect_error . '</span>';
                            } else if (isset($conn)) {
                                echo '<span class="status-badge status-success"><i class="fas fa-check me-2"></i>Database Connected Successfully!</span>';
                            } else {
                                echo '<span class="status-badge status-error"><i class="fas fa-times me-2"></i>Configuration Error</span>';
                            }
                        } else {
                            echo '<span class="status-badge status-error"><i class="fas fa-times me-2"></i>Config file not found</span>';
                        }
                        ?>
                    </div>
                </div>

                <div class="step-card">
                    <h4><span class="step-number">2</span> Import Database</h4>
                    <p class="mb-2"><strong>Option A - Using phpMyAdmin:</strong></p>
                    <ol>
                        <li>Open <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a></li>
                        <li>Click on "Import" tab</li>
                        <li>Choose the <code>database.sql</code> file</li>
                        <li>Click "Go" to import</li>
                    </ol>
                    
                    <p class="mb-2 mt-3"><strong>Option B - Using SQL tab:</strong></p>
                    <ol>
                        <li>Open <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a></li>
                        <li>Click on "SQL" tab</li>
                        <li>Copy and paste content from <code>database.sql</code></li>
                        <li>Click "Go"</li>
                    </ol>
                    
                    <?php
                    // Check if tables exist
                    if (isset($conn) && !$conn->connect_error) {
                        $tables = ['inquiries', 'services', 'portfolio'];
                        $tablesExist = true;
                        
                        foreach ($tables as $table) {
                            $result = $conn->query("SHOW TABLES LIKE '$table'");
                            if ($result->num_rows == 0) {
                                $tablesExist = false;
                                break;
                            }
                        }
                        
                        if ($tablesExist) {
                            echo '<div class="mt-3"><span class="status-badge status-success"><i class="fas fa-check me-2"></i>Database Tables Exist</span></div>';
                        } else {
                            echo '<div class="mt-3"><span class="status-badge status-error"><i class="fas fa-exclamation-triangle me-2"></i>Please import database.sql</span></div>';
                        }
                    }
                    ?>
                </div>

                <div class="step-card">
                    <h4><span class="step-number">3</span> Verify File Structure</h4>
                    <p class="mb-2">Ensure all required files are present:</p>
                    <ul class="mb-0">
                        <?php
                        $requiredFiles = [
                            'index.php' => 'Main homepage',
                            'config.php' => 'Database configuration',
                            'submit_contact.php' => 'Contact form handler',
                            'css/style.css' => 'Custom styles',
                            'js/script.js' => 'JavaScript functionality',
                            'database.sql' => 'Database schema'
                        ];
                        
                        foreach ($requiredFiles as $file => $description) {
                            $exists = file_exists($file);
                            $icon = $exists ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>';
                            echo "<li>$icon <strong>$file</strong> - $description</li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="step-card">
                    <h4><span class="step-number">4</span> Launch Your Website</h4>
                    <p>Once all steps above show success, you're ready to go!</p>
                    <div class="text-center mt-4">
                        <a href="index.php" class="btn btn-test">
                            <i class="fas fa-rocket me-2"></i>Launch Silent Prints Website
                        </a>
                    </div>
                </div>

                <div class="alert alert-warning mt-4">
                    <i class="fas fa-shield-alt me-2"></i>
                    <strong>Security Note:</strong> For production deployment, remember to:
                    <ul class="mb-0 mt-2">
                        <li>Delete this setup.php file</li>
                        <li>Update database credentials</li>
                        <li>Enable HTTPS</li>
                        <li>Set proper file permissions</li>
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted">Need help? Check the <a href="README.md">README.md</a> file for detailed instructions.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
