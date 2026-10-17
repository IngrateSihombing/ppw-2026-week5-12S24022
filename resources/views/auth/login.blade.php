
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pustakawan | SIPUS-Del</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eaf3ff, #f8fafc);
            color: #1e293b;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .brand {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            border-radius: 18px;
            background: #dbeafe;
            color: #2563eb;
            font-size: 32px;
        }

        .brand h1 {
            margin: 0;
            font-size: 28px;
            color: #1e3a5f;
        }

        .brand p {
            margin-top: 8px;
            color: #64748b;
            font-size: 14px;
        }

        .login-card {
            padding: 32px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 16px 40px rgba(30, 58, 95, 0.10);
        }

        .login-card h2 {
            margin: 0 0 8px;
            font-size: 23px;
        }

        .description {
            margin: 0 0 26px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.14);
        }

        .login-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .login-button:hover {
            background: #1d4ed8;
        }

        .message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
        }

        .success {
            color: #166534;
            background: #f0fdf4;
        }

        .error {
            color: #b91c1c;
            background: #fef2f2;
        }

        .footer {
            margin-top: 24px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <main class="login-container">
        <header class="brand">
            <div class="brand-icon" aria-hidden="true">📚</div>
            <h1>SIPUS-Del</h1>
            <p>Sistem Informasi Perpustakaan Del</p>
        </header>

        <section class="login-card">
            <h2>Selamat Datang!</h2>
            <p class="description">
                Silakan masuk menggunakan akun pustakawan Anda.
            </p>

            @if (session('success'))
                <div class="message success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="message error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@del.ac.id"
                        autocomplete="username"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    Masuk ke Sistem
                </button>
            </form>
        </section>

        <footer class="footer">
            SIPUS-Del &copy; {{ date('Y') }} · Khusus pustakawan
        </footer>
    </main>
</body>
</html>
