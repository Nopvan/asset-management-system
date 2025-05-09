<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            flex: 1 0 auto;
            padding: 30px 15px;
        }

        .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .card-header {
            background-color: #28a745;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .contact-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 10px;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 10px;
            font-weight: bold;
            padding: 12px 20px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .faq-section {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }

        .faq-section h3 {
            margin-top: 30px;
            font-size: 1.75rem;
            font-weight: bold;
            color: #333;
        }

        .faq-section ul {
            list-style-type: none;
            padding: 0;
        }

        .faq-section li {
            margin: 10px 0;
            font-size: 1.1rem;
            color: #555;
        }

        .faq-section li strong {
            color: #28a745;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .faq-section h3 {
                font-size: 1.5rem;
            }

            .card-header {
                font-size: 1.25rem;
            }
        }

        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    @include('layouts.header')

    <div class="container content-wrapper">
        <div class="row justify-content-center">
            <!-- Form to Contact Customer Service -->
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">
                        <i class="fas fa-headset"></i> Contact Customer Service
                    </div>
                    <div class="card-body">
                        <form class="contact-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter your name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Your Message</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Describe your issue or question" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section with a Decorative Background -->
        <div class="faq-section">
            <h3>Frequently Asked Questions</h3>
            <ul>
                <li><strong>Q1:</strong> How can I reset my password?</li>
                <li>A1: Click on "Forgot Password" at the login page and follow the instructions.</li>
                <li><strong>Q2:</strong> How do I track my order?</li>
                <li>A2: After placing your order, you will receive an email with the tracking link.</li>
                <li><strong>Q3:</strong> Can I change my order after it's been placed?</li>
                <li>A3: You can change your order within 24 hours of placing it. Contact support for assistance.</li>
            </ul>
        </div>
    </div>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
