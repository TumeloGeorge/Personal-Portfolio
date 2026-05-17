<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0a0c10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #0f1520;
            border: 1px solid #1a2035;
            border-radius: 16px;
            padding: 48px;
            width: 100%;
            max-width: 420px;
        }
        .logo {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo-mark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px; height: 56px;
            background: rgba(56,189,248,0.1);
            border: 1px solid rgba(56,189,248,0.3);
            border-radius: 14px;
            font-size: 22px;
            font-weight: 600;
            color: #38bdf8;
            margin-bottom: 16px;
        }
        .logo h1 { font-size: 20px; color: #f1f5f9; font-weight: 600; }
        .logo p  { font-size: 13px; color: #475569; margin-top: 4px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 12px; color: #94a3b8; margin-bottom: 6px; font-weight: 500; }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: #131825;
            border: 1px solid #1e2a3a;
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 13px;
            color: #e2e8f0;
            font-family: inherit;
            transition: border-color 0.2s;
            outline: none;
        }
        input:focus { border-color: #38bdf8; }
        .input-error { border-color: #ef4444 !important; }
        .error-msg { font-size: 11px; color: #ef4444; margin-top: 5px; }
        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 24px;
        }
        .remember input { width: auto; }
        .btn {
            width: 100%;
            background: #38bdf8;
            color: #0a0c10;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn:hover { background: #0ea5e9; }
        .alert {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #fca5a5;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            margin-bottom: 20px;
        }
        .back-link {
            text-align: center;
            margin-top: 24px;
        }
        .back-link a {
            font-size: 12px;
            color: #475569;
            text-decoration: none;
        }
        .back-link a:hover { color: #38bdf8; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <div class="logo-mark">TT</div>
            <h1>Admin Panel</h1>
            <p>Sign in to manage your portfolio</p>
        </div>

        @if(session('error'))
            <div class="alert">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                    autocomplete="email"
                    autofocus
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="{{ $errors->has('password') ? 'input-error' : '' }}"
                    autocomplete="current-password"
                    required
                >
            </div>

            <label class="remember">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            <button type="submit" class="btn">Sign In</button>
        </form>

        <div class="back-link">
            <a href="{{ route('portfolio') }}">← Back to portfolio</a>
        </div>
    </div>
</body>
</html>