<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Reset Your Password | FOODKING</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial,Helvetica,sans-serif; color:#263445;">

    {{-- Hidden email preview text --}}
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">
        Reset your FOODKING account password securely.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
           style="width:100%; background-color:#f4f6f8;">
        <tr>
            <td align="center" style="padding:35px 12px;">

                {{-- Main email container --}}
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"
                       style="width:100%; max-width:600px; background-color:#ffffff; border-radius:14px; overflow:hidden;">

                    {{-- Brand header --}}
                    <tr>
                        <td align="center" style="background-color:#071b2c; padding:35px 20px 30px;">

                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center"
                                        style="width:54px; height:54px; background-color:#ff8c1a; border-radius:14px; color:#071b2c; font-size:27px; font-weight:bold;">
                                        F
                                    </td>
                                </tr>
                            </table>

                            <h1 style="margin:14px 0 7px; color:#ffffff; font-size:29px; line-height:1.3; font-weight:700; letter-spacing:0.5px;">
                                FOODKING
                            </h1>

                            <p style="margin:0; color:#ffbd75; font-size:11px; line-height:1.6; font-weight:bold; letter-spacing:2px;">
                                GOOD FOOD. GREAT MOMENTS.
                            </p>

                        </td>
                    </tr>

                    {{-- Orange accent --}}
                    <tr>
                        <td style="height:5px; background-color:#ff8c1a; font-size:0; line-height:0;">
                            &nbsp;
                        </td>
                    </tr>

                    {{-- Email content --}}
                    <tr>
                        <td style="padding:38px 35px 20px;">

                            {{-- Lock icon --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center"
                                                    style="width:66px; height:66px; background-color:#fff0e3; border-radius:50%; color:#e53935; font-size:30px; font-weight:bold;">
                                                    &#128274;
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <h2 style="margin:23px 0 10px; text-align:center; color:#071b2c; font-size:27px; line-height:1.35; font-weight:700;">
                                Reset Your Password
                            </h2>

                            <p style="margin:0 0 25px; text-align:center; color:#78818c; font-size:14px; line-height:1.8;">
                                Let's get you back to enjoying your favourites.
                            </p>

                            <p style="margin:0 0 15px; color:#263445; font-size:15px; line-height:1.8;">
                                Hello{{ !empty($user->name) ? ' '. $user->name : '' }},
                            </p>

                            <p style="margin:0 0 18px; color:#596575; font-size:14px; line-height:1.9;">
                                We received a request to reset the password for your FOODKING account.
                                Click the button below to securely create a new password.
                            </p>

                            {{-- Reset password button --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="margin:25px 0;">
                                <tr>
                                    <td align="center">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" bgcolor="#e85b35"
                                                    style="border-radius:8px;">
                                                    <a href="{{ $resetUrl }}"
                                                       target="_blank"
                                                       style="display:inline-block; padding:16px 32px; border:1px solid #e85b35; border-radius:8px; background-color:#e85b35; color:#ffffff; font-size:14px; line-height:1.4; font-weight:bold; text-decoration:none;">
                                                        Reset My Password &nbsp; &#8594;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 20px; text-align:center; color:#7b8490; font-size:12px; line-height:1.8;">
                                This password reset link expires in
                                <strong style="color:#263445;">{{ $expiryMinutes }} minutes</strong>.
                            </p>

                            {{-- Fallback URL --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="background-color:#fffaf5; border:1px solid #f3e4d7; border-radius:8px;">
                                <tr>
                                    <td style="padding:15px;">
                                        <p style="margin:0 0 8px; color:#596575; font-size:12px; line-height:1.7;">
                                            If the button doesn't work, copy and paste this link into your browser:
                                        </p>

                                        <a href="{{ $resetUrl }}"
                                           target="_blank"
                                           style="color:#d94d2b; font-size:12px; line-height:1.8; word-break:break-all; text-decoration:underline;">
                                            {{ $resetUrl }}
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Security notice --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="margin-top:25px;">
                                <tr>
                                    <td style="padding:15px; background-color:#f4f8fb; border-left:4px solid #ff8c1a; border-radius:4px;">
                                        <p style="margin:0; color:#596575; font-size:12px; line-height:1.9;">
                                            <strong style="color:#071b2c;">Security notice</strong><br>
                                            If you didn't request a password reset, you can safely ignore this email.
                                            Your password will remain unchanged unless you complete the reset process.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" style="padding:25px 20px 30px; background-color:#fffaf5; border-top:1px solid #f0e8e0;">

                            <p style="margin:0 0 8px; color:#071b2c; font-size:14px; font-weight:bold;">
                                Made with love by FOODKING
                            </p>

                            <p style="margin:0 0 12px; color:#8b929b; font-size:11px; line-height:1.8;">
                                Good food. Great moments.
                            </p>

                            <p style="margin:0; color:#a0a6ad; font-size:10px; line-height:1.8;">
                                This is an automated email. Please do not reply.
                            </p>

                        </td>
                    </tr>

                </table>

                {{-- Outside footer --}}
                <p style="margin:20px 0 0; color:#9aa1aa; text-align:center; font-size:11px; line-height:1.7;">
                    © {{ date('Y') }} FOODKING. All rights reserved.
                </p>

            </td>
        </tr>
    </table>

</body>
</html>