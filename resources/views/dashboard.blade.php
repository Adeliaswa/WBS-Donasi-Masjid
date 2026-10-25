<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengurus - Masjid Sabilillah</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f5f7fa;
        }

        h1 {
            color: #245c46;
        }

        .menu {
            display: inline-block;
            margin-top: 15px;
            padding: 15px 20px;
            background-color: #245c46;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout {
            margin-top: 25px;
        }

        button {
            padding: 9px 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Dashboard Pengurus</h1>

    <p>Selamat datang, Pengurus Masjid Sabilillah!</p>
    <p>Anda berhasil login ke Sistem Pengelolaan Donasi Masjid Sabilillah.</p>

    <h2>Menu Pengelolaan</h2>

    <a href="{{ route('donations.index') }}" class="menu">
        Data Donasi
    </a>

    <div class="logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>