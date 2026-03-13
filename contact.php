<?php include_once "./include/header.php"; ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .contact-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
        margin-bottom: 50px;
    }

    .contact-header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .contact-header p {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Contact Info Section */
    .contact-info-section {
        margin-bottom: 60px;
    }

    .contact-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .contact-info-box {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
    }

    .contact-info-box .icon {
        font-size: 2.5rem;
        color: #667eea;
        margin-bottom: 15px;
    }

    .contact-info-box h4 {
        margin-bottom: 10px;
        color: #333;
        font-weight: 600;
        font-size: 1.3rem;
    }

    .contact-info-box p {
        color: #666;
        margin: 8px 0;
        font-size: 1rem;
    }

    .contact-info-box a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .contact-info-box a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    /* Feedback Section */
    .feedback-section {
        margin-bottom: 60px;
    }

    .section-title {
        color: #333;
        font-weight: bold;
        font-size: 2rem;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 3px solid #667eea;
        text-align: center;
    }

    .feedback-card {
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .feedback-card h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.5rem;
    }

    .feedback-card p {
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-control::placeholder {
        color: #999;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 14px 40px;
        font-size: 1.05rem;
        font-weight: 600;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        width: 100%;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Messages */
    .success-message {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        padding: 15px 20px;
        border-radius: 5px;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 15px 20px;
        border-radius: 5px;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .error-list {
        margin: 10px 0 0 0;
        padding-left: 20px;
    }

    .error-list li {
        margin: 5px 0;
    }

    /* Footer spacer */
    .footer-spacer {
        margin-bottom: 80px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .contact-header {
            padding: 40px 15px;
        }

        .contact-header h1 {
            font-size: 2rem;
        }

        .contact-header p {
            font-size: 1rem;
        }

        .contact-info-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .contact-info-box {
            padding: 20px;
        }

        .contact-info-box .icon {
            font-size: 2rem;
        }

        .feedback-card {
            padding: 25px;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .btn-submit {
            padding: 12px 30px;
            font-size: 1rem;
        }
    }
</style>

<!-- Contact Header -->
<div class="contact-header">
    <h1>Contact Us</h1>
    <p>We'd love to hear from you. Get in touch with us today!</p>
</div>

<div class="container footer-spacer">
    <!-- Contact Information Section -->
    <div class="contact-info-section">
        <h2 class="section-title">Get In Touch</h2>
        
        <div class="contact-info-grid">
            <!-- Phone -->
            <div class="contact-info-box">
                <div class="icon">☎</div>
                <h4>Phone</h4>
                <p><a href="tel:+919876543210">+91 8530 44 8522</a></p>
                <p style="color: #999; font-size: 0.9rem;">Mon - Fri, 9:00 AM - 6:00 PM</p>
            </div>

            <!-- Email -->
            <div class="contact-info-box">
                <div class="icon">✉</div>
                <h4>Email</h4>
                <p><a href="mailto:support@homeservices.com">support@homeservices.com</a></p>
                <p style="color: #999; font-size: 0.9rem;">We'll respond within 24 hours</p>
            </div>

            <!-- Location -->
            <div class="contact-info-box">
                <div class="icon">📍</div>
                <h4>Location</h4>
                <p>Padhampura <br>Chh Sambhajinagar,Maharashtra 431005</p>
            </div>
        </div>
    </div>
<!--  
<div class="feedback-section">
        <h2 class="section-title">Send Us Your Feedback</h2>
        
        <div class="feedback-card">
            <h3>We Value Your Feedback</h3>
            <p>Have a question or suggestion? Please fill out the form below and we'll get back to you as soon as possible.</p>

            <?php
            // Display success message if form was submitted
            if (isset($_SESSION['feedback_success'])): ?>
                <div class="success-message">
                    ✓ Thank you! Your feedback has been submitted successfully. We'll review it shortly.
                </div>
                <?php unset($_SESSION['feedback_success']);
            endif;

            // Display error messages if validation failed
            if (isset($_SESSION['feedback_errors'])): ?>
                <div class="error-message">
                    ✗ Please correct the following errors:
                    <ul class="error-list">
                        <?php foreach ($_SESSION['feedback_errors'] as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php unset($_SESSION['feedback_errors']);
            endif;
            ?>

            <form method="POST" action="./scripts/addfeedback.php">
                 Name Field
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control" 
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                <!-- Email Field
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="Enter your email"
                        required
                    >
                </div>

                <!-- Subject Field 
                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input 
                        type="text" 
                        id="subject" 
                        name="subject" 
                        class="form-control" 
                        placeholder="What is this regarding?"
                        required
                    >
                </div>

                <!-- Message Field 
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea 
                        id="message" 
                        name="message" 
                        class="form-control" 
                        placeholder="Tell us your feedback, suggestions, or concerns..."
                        required
                    ></textarea>
                </div>

                <!-- Submit Button 
                <button type="submit" class="btn-submit">Send Feedback</button>
            </form>
        </div>  --> 
    
    
    </div>
</div>

<?php include_once "./include/footer.php"; ?>
