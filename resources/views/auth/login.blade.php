
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Login | Academics</title>

    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">

    <style>
        :root {
            --green: #51be78;
            --green-dark: #3da862;
            --navy: #1b3a63;
            --text: #2d3748;
            --muted: #718096;
            --border: #e2e8f0;
            --bg: #f5f7fa;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Muli', sans-serif;
            color: var(--text);
            background: var(--bg);
            min-height: 100vh;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ---------- Left side (image) ---------- */
        .hero {
            flex: 1.1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: #fff;
            background:
                linear-gradient(160deg, rgba(27, 58, 99, .88), rgba(27, 58, 99, .72)),
                url('{{ asset('font/images/bg_1.jpg') }}') center/cover no-repeat;
        }

        .hero h1 {
            font-size: 40px;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .hero h1 span { color: var(--green); }

        .hero p {
            font-size: 17px;
            font-weight: 300;
            max-width: 440px;
            opacity: .92;
            line-height: 1.7;
        }

        .hero ul {
            list-style: none;
            margin-top: 32px;
        }

        .hero li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            font-size: 15px;
        }

        .hero li::before {
            content: "";
            width: 22px; height: 22px;
            border-radius: 50%;
            background: var(--green) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='3.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M5 12l5 5L20 7'/%3E%3C/svg%3E") center/12px no-repeat;
            flex-shrink: 0;
        }

        /* ---------- Right side (form) ---------- */
        .panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: #fff;
        }

        .box { width: 100%; max-width: 410px; }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 28px;
        }

        .logo img { height: 64px; width: auto; }

        .box h2 {
            font-size: 28px;
            font-weight: 900;
            text-align: center;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .box .sub {
            text-align: center;
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 30px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .alert-success { background: #e8f8ee; color: #1f7a42; border: 1px solid #c6ecd4; }
        .alert-notice { background: #fff8e1; color: #735c00; border: 1px solid #f4df9a; }

        .field { margin-bottom: 20px; }

        .field label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .input-wrap { position: relative; }

        .input-wrap svg.icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            width: 19px; height: 19px;
            stroke: var(--muted);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .input-wrap input {
            width: 100%;
            height: 50px;
            padding: 0 44px 0 44px;
            font-family: inherit;
            font-size: 15px;
            color: var(--text);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: #fafbfc;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }

        .input-wrap input:focus {
            border-color: var(--green);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(81, 190, 120, .15);
        }

        .input-wrap input.has-error { border-color: #e53e3e; }

        .toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: 0;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
            padding: 6px;
        }
        .toggle:hover { color: var(--green-dark); }

        .error-text {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 6px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
            font-size: 14px;
        }

        .check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--muted);
        }

        .check input { accent-color: var(--green); width: 16px; height: 16px; }

        .row a { color: var(--green-dark); text-decoration: none; font-weight: 700; }
        .row a:hover { text-decoration: underline; }

        .btn {
            width: 100%;
            height: 52px;
            border: 0;
            border-radius: 10px;
            background: var(--green);
            color: #fff;
            font-family: inherit;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s, transform .1s;
            box-shadow: 0 6px 16px rgba(81, 190, 120, .35);
        }
        .btn:hover { background: var(--green-dark); }
        .btn:active { transform: translateY(1px); }
        .btn:disabled { opacity: .7; cursor: not-allowed; }

        .foot {
            text-align: center;
            margin-top: 26px;
            font-size: 14px;
            color: var(--muted);
        }
        .foot a { color: var(--green-dark); font-weight: 700; text-decoration: none; }
        .foot a:hover { text-decoration: underline; }

        .back {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
        }
        .back:hover { color: var(--navy); }

        @media (max-width: 900px) {
            .hero { display: none; }
            .panel { background: var(--bg); }
            .box {
                background: #fff;
                padding: 32px 24px;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
            }
        }
    </style>
</head>

<body>
<div class="wrapper">

    <!-- Left: welcome section -->
    <section class="hero">
        <h1>Learn without <span>limits</span>,<br>manage your studies with ease.</h1>
        <p>Access your courses, grades, schedules and registration from one simple student portal.</p>
        <ul>
            <li>Register for courses online</li>
            <li>Track your grades and attendance</li>
            <li>Stay updated with announcements</li>
        </ul>
    </section>

    <!-- Right: login form -->
    <section class="panel">
        <div class="box">

            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('font/images/logo.png') }}" alt="Academics">
            </a>

            <h2>Welcome Back</h2>
            <p class="sub">Sign in to continue to your student account</p>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('notice'))
                <div class="alert alert-notice" role="status">{{ session('notice') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <svg class="icon" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 7l9 6 9-6"/>
                        </svg>
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}"
                               class="@error('email') has-error @enderror"
                               placeholder="name@university.edu"
                               required autofocus autocomplete="username">
                    </div>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <svg class="icon" viewBox="0 0 24 24">
                            <rect x="4" y="11" width="16" height="10" rx="2"/>
                            <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                        </svg>
                        <input type="password" id="password" name="password"
                               class="@error('password') has-error @enderror"
                               placeholder="Enter your password"
                               required autocomplete="current-password">
                        <button type="button" class="toggle" id="togglePassword">Show</button>
                    </div>
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <label class="check">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn" id="loginBtn">Log In</button>
            </form>

            @if (Route::has('register'))
                <p class="foot">
                    New student? <a href="{{ route('register') }}">Create an account</a>
                </p>
            @endif

            <a href="{{ route('index') }}" class="back">&larr; Back to website</a>

        </div>
    </section>

</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var input = document.getElementById('password');
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        this.textContent = show ? 'Hide' : 'Show';
    });

    document.getElementById('loginForm').addEventListener('submit', function () {
        var btn = document.getElementById('loginBtn');
        btn.disabled = true;
        btn.textContent = 'Signing in...';
    });
</script>
</body>
</html>
