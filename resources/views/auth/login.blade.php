<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | WorkNest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box }
        body { margin: 0; color: #F7EFE5; font-family: 'DM Sans', sans-serif; background: #27142E }
        .layout { min-height: 100vh; display: grid; grid-template-columns: 1fr 1.2fr }
        .side { background: #27142E; padding: 2.5rem 3.5rem; display: flex; flex-direction: column; justify-content: space-between; min-height: 100vh; border-right: 1px solid rgba(170,148,177,.15) }
        .side-top { display: flex; flex-direction: column; gap: 3.5rem }
        .tagline { font: 600 1.65rem/1.25 'Cormorant Garamond', serif; max-width: 340px; color: #F7EFE5; margin: 0 }
        .side small { color: #AA94B1; font-size: .8rem; letter-spacing: .5px }
        .main { background: #4A1F50; padding: 2.5rem 4rem; display: flex; align-items: center }
        .card { max-width: 440px; width: 100%; margin: auto }
        h1 { font: 700 1.85rem 'Cormorant Garamond', serif; margin: 0 0 .25rem; color: #F7EFE5 }
        .intro { font-size: .88rem; margin: 0 0 1.1rem; color: #AA94B1 }
        .field { margin-bottom: .6rem }
        label { display: block; margin-bottom: .25rem; color: #AA94B1; font-size: .85rem }
        input { width: 100%; height: 38px; padding: .5rem .85rem; background: #4A1F50; color: #F7EFE5; border: 1px solid #AA94B1; border-radius: 8px; font: 400 .9rem 'DM Sans', sans-serif }
        input:focus { outline: 0; border-color: #F6EB61; box-shadow: 0 0 0 3px rgba(246, 235, 97, .12) }
        .password { position: relative }
        .password input { padding-right: 2.75rem }
        .toggle { position: absolute; right: .6rem; top: 50%; transform: translateY(-50%); border: 0; background: none; color: #AA94B1; cursor: pointer; padding: 0 }
        .error { padding: .75rem; margin-bottom: .85rem; background: rgba(192, 97, 106, .12); border-left: 3px solid #C0616A; border-radius: 4px; font-size: .85rem }
        .button { width: 100%; padding: .75rem; border: 0; border-radius: 50px; background: #F6EB61; color: #1A1A1A; font: 700 .92rem 'DM Sans', sans-serif; cursor: pointer; transition: background .2s ease }
        .button:hover { background: #FFF0C4 }
        .submit-wrap { margin-top: .9rem }
        .remember { display: flex; gap: .5rem; align-items: center; color: #AA94B1; font-size: .84rem; margin-top: .4rem }
        .remember input { width: auto; height: auto; accent-color: #F6EB61 }
        .other { text-align: center; margin-top: .9rem; color: #AA94B1; font-size: .85rem }
        .other a { color: #F6EB61 }
        @media (max-width: 760px) {
            .layout { grid-template-columns: 1fr }
            .side { display: none }
            .main { padding: 2rem 1.25rem }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside class="side">
        <div class="side-top">
            @include('partials.logo', ['height' => 40])
            <p class="tagline">A considered workspace for every part of your organization.</p>
        </div>
        <small>Secure. Scalable. Organized.</small>
    </aside>
    <main class="main">
        <div class="card">
            <h1>Welcome back</h1>
            <p class="intro">Sign in to access your organization workspace.</p>
            @if($errors->any())
                <div class="error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label for="organization_name">Organization name</label>
                    <input id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required>
                </div>
                <div class="field">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="password">
                        <input id="password" type="password" name="password" required>
                        <button class="toggle" type="button" data-password="password" aria-label="Show password">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <label class="remember"><input type="checkbox" name="remember" value="1"> Remember me</label>
                <div class="submit-wrap">
                    <button class="button" type="submit">Sign in</button>
                </div>
            </form>
            <p class="other">Need an account? <a href="{{ route('register') }}">Register</a></p>
        </div>
    </main>
</div>
<script>
    document.querySelectorAll('[data-password]').forEach(button => button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.password);
        input.type = input.type === 'password' ? 'text' : 'password';
        button.setAttribute('aria-label', input.type === 'password' ? 'Show password' : 'Hide password')
    }));
</script>
</body>
</html>
