<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Email Confirmation</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        table.container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
            margin: 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        p {
            margin-bottom: 20px;
        }

        .cta-button {
            display: inline-block;
            background-color: #0056b3;
            color: #fff;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 30px;
            transition: background-color 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .footer {
            color: #777;
            font-size: 14px;
            text-align: center;
        }

    </style>
</head>
<body>
    <table class="container" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <h2>Verify Your Email Address</h2>
                <p>
                    Hi {{ $name }},
                </p>
                <p>
                    Thank you for joining our verification demo app! We're excited to have you on board.
                </p>
                <p>
                    To start using your account, please verify your email address by clicking the button below:
                </p>
                <p>
                    <a href="{{ $urlVerify}}" class="cta-button">
                        Verify Email Address
                    </a>
                </p>
                <p>
                    If you didn't create an account with us, no action is required, and you can disregard this email.
                </p>
                <p class="footer">
                    Best regards,<br>
                    The Verification Demo Team
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
