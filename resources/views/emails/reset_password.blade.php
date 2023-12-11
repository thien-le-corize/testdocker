<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
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
            background-color: #007bff;
            color: #fff;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 30px;
            transition: background-color 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        .footer {
            color: #777;
            font-size: 14px;
            text-align: center;
        }

        .background-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <table class="container" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <h2>Password Reset</h2>
                <p>
                    Hi {{ $name }},
                </p>
                <p>
                    We received a request to reset your account password. If you made this request, click the button below to reset your password.
                </p>
                <p>
                    <a href="{{ $urlResetPassword }}" class="cta-button">
                        Reset Password
                    </a>
                </p>
                <p>
                    If you did not initiate this request, please ignore this email. Your account is secure.
                </p>
                <p class="footer">
                    Best regards,<br>
                    Your Company Name
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
