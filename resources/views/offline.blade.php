<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi Terputus - MineCart</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-family: 'Press Start 2P', cursive;
            color: #3dcec4;
            font-size: 1.5rem;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        p {
            font-size: 1.1rem;
            color: #94a3b8;
            max-width: 400px;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn:hover {
            background-color: #2563eb;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Anda Sedang Offline!</h1>
    <p>Sepertinya Anda kehilangan koneksi internet. Beberapa fitur MineCart mungkin tidak tersedia saat offline.</p>
    <button class="btn" onclick="window.location.reload()">Coba Lagi</button>
</body>
</html>
