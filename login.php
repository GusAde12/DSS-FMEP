<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            max-width: 900px;
            border: 1px solid #ccc;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
        }

        .content {
            display: flex;
            justify-content: space-between;
        }

        .content .text-box {
            width: 60%;
            border: 1px solid #ccc;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f9f9f9;
            padding: 15px;
            overflow-y: auto;
        }

        .content .login-box {
            width: 35%;
            border: 1px solid #ccc;
            padding: 15px;
            background: #f9f9f9;
        }

        .login-box h2 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box .form-group {
            margin-bottom: 15px;
        }

        .login-box .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .login-box .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-box .form-group button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: #fff;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-box .form-group button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="img/logo.png" alt="Logo">
            <h1>Sistem Pendukung Keputusan Kantor Desa Waringin Jaya</h1>
        </div>

        <div class="content">
            <div class="text-box">
                <p>Kantor Desa Waringin Jaya terletak di Kecamatan Bojonggede, Kabupaten Bogor. Sebagai pusat administrasi pemerintahan desa, Kantor Desa Waringin Jaya berperan penting dalam melayani kebutuhan masyarakat setempat, mulai dari pengurusan dokumen kependudukan, sertifikat tanah, hingga pelayanan sosial lainnya. <br>
                Desa Waringin Jaya memiliki visi untuk meningkatkan kesejahteraan warganya melalui program pembangunan yang berkelanjutan, partisipatif, dan berbasis potensi lokal. Dengan dukungan dari perangkat desa yang kompeten, kantor desa ini juga berfungsi sebagai penghubung antara masyarakat dan pemerintah daerah dalam mewujudkan kemajuan desa.</p>
            </div>

            <div class="login-box">
                <h2>Login Account</h2>
                <form action="proses-login.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" value="" placeholder="Email...">

                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" value="" placeholder="Password..">

                    </div>
                    <div class="form-group">
                        <button type="submit">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
