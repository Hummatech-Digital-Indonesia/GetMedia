<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>GeetMedia | Verify</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style type="text/css">
        #outlook a {
            padding: 0;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .ExternalClass * {
            line-height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            background: #f9f9f9;
        }

        table,
        td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        p {
            display: block;
            margin: 13px 0;
        }

        @media only screen and (max-width: 480px) {
            @-ms-viewport {
                width: 320px;
            }

            @viewport {
                width: 320px;
            }
        }

        @import url('https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700');

        @media only screen and (min-width: 480px) {
            .mj-column-per-100,
            *[aria-labelledby="mj-column-per-100"] {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <div style="background-color: #f9f9f9; margin: 0 auto; max-width: 640px; box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1); border-radius: 4px; overflow: hidden;">
        <div style="background: transparent">
            <!-- Header Section -->
            <div style="text-align: center;">
                <div style="cursor: auto; color: #1B3061; font-family: Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;">
                    <img src="{{asset('Kop-Email.jpg')}}" style="width:638px" class="w-100 h-100"/>
                </div>
            </div>
            <!-- Content Section -->
            <div style="text-align: center; background: #ffffff; padding: 40px 70px;">
                <div style="vertical-align: top; display: inline-block; direction: ltr; font-size: 13px; text-align: left; width: 100%;">
                    <div style="word-break: break-word; font-size: 0px; padding: 0px 0px 20px;" align="left">
                        <div style="cursor: auto; font-family: Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif; font-size: 16px; line-height: 24px; text-align: left;">
                            <p></p>
                            <h2 style="font-family: Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif; font-weight: 500; font-size: 20px; color: #4f545c; letter-spacing: 0.27px;">
                                Tautan ini aktif selama 4 jam
                            </h2>
                            <h4 style="font-weight: 700; color: #000000;">
                                Aktivasi Akun Anda
                            </h4>
                            <p>
                                Terimakasih {{ $data['user'] }} telah mendaftar di <span style="color: #000000;">Website GetMedia.id,</span> verifikasi Untuk melanjutkan mengakses GetMedia.Klik tombol di bawah ini untuk memulai proses verifikasi:
                            </p>
                        </div>
                    </div>
                    <div style="word-break: break-word; font-size: 0px; padding: 10px 25px;" align="center">
                        <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse: separate" align="center" border="0">
                            <tbody>
                                <tr>
                                    <td style="background-color:red;border: none; border-radius: 3px; color: white; cursor: auto; padding: 15px 19px;" align="center; background-color: #175A95;" valign="middle" bgcolor="#1">
                                        <a href="{{ route('verisikasi.account', ['id' => $data['id']]) }}" target="_blank" rel="noopener noreferrer" style="text-decoration: none; line-height: 100%; color: white; font-family: Ubuntu, Helvetica, Arial, sans-serif; font-size: 15px; font-weight: normal; text-transform: none; margin: 0px;background-color:red">
                                            Verifikasi Email
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p>
                         Mulailah menjelajahi dunia berita untuk perluas pengetahuan dengan membaca di GetMedia, dan dapatkan pengalaman membaca berita yang kebih nyaman dan menarik!
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
