<!DOCTYPE html>
<html>

<head>
    <style>
        /* Default light mode styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            padding: 50px;
        }

        .container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .header {
            padding: 10px 0;
            text-align: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .header img {
            max-width: 120px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }

        .content {
            padding: 20px;
            line-height: 1.5;
        }

        .otp {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
            margin: 20px 0;
            color: #333;
            background-color: #f1f1f1;
            padding: 10px 0;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 20px 0;
            color: #888888;
            font-size: 12px;
        }

        /* Dark mode styles */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #333;
            }

            .container {
                background-color: #444;
            }

            .header,
            .content,
            .footer {
                color: #eee;
            }

            .otp {
                color: #444;
                background-color: #eee;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://adrenaline-edu.com/images/1.png" alt="https://adrenaline-edu.com/images/1.png">
        </div>
        <div class="content">
            <p>Hello, {{ $username }}</p>
            <p>{{ $massge }}:</p>
            <div class="otp">{{ $code }}</div>
            <p>This OTP is valid for 60 minutes. If you didn't request this code, please ignore this email.</p>
        </div>
    </div>
</body>

</html>
