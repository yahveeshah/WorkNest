<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register | WorkNest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box }
        body { margin: 0; color: #F7EFE5; font-family: 'DM Sans', sans-serif; background: #27142E }
        .layout { display: grid; grid-template-columns: 1fr 1.2fr; min-height: 100vh }
        .side { background: #27142E; padding: 2.5rem 3.5rem; display: flex; flex-direction: column; justify-content: space-between; min-height: 100vh; border-right: 1px solid rgba(170,148,177,.15) }
        .side-top { display: flex; flex-direction: column; gap: 3.5rem }
        .tagline { font: 600 1.65rem/1.25 'Cormorant Garamond', serif; max-width: 340px; color: #F7EFE5; margin: 0 }
        .side small { color: #AA94B1; font-size: .8rem; letter-spacing: .5px }
        .main { background: #4A1F50; padding: 2.5rem 4rem; display: flex; align-items: center }
        .card { width: 100%; max-width: 440px; margin: auto }
        h1 { font: 700 1.85rem 'Cormorant Garamond', serif; margin: 0 0 .25rem; color: #F7EFE5 }
        .intro { font-size: .88rem; margin: 0 0 1.1rem; color: #AA94B1 }
        .field { margin-bottom: .5rem; transition: opacity 0.3s ease, transform 0.3s ease; }
        .field.hidden-field { display: none !important; opacity: 0; transform: translateY(-8px); }
        label { display: block; margin-bottom: .22rem; color: #AA94B1; font-size: .84rem }
        input, select { width: 100%; height: 38px; padding: .5rem .85rem; background: #4A1F50; color: #F7EFE5; border: 1px solid #AA94B1; border-radius: 8px; font: 400 .9rem 'DM Sans', sans-serif }
        input:focus, select:focus { outline: 0; border-color: #F6EB61; box-shadow: 0 0 0 3px rgba(246, 235, 97, .12) }
        .password { position: relative }
        .password input { padding-right: 2.75rem }
        .toggle { position: absolute; right: .6rem; top: 50%; transform: translateY(-50%); border: 0; background: none; color: #AA94B1; cursor: pointer; padding: 0 }
        .error { margin-bottom: .8rem; padding: .75rem; background: rgba(192, 97, 106, .12); border-left: 3px solid #C0616A; border-radius: 4px; font-size: .85rem }
        .error div + div { margin-top: .2rem }
        .button { width: 100%; border: 0; border-radius: 50px; background: #F6EB61; color: #1A1A1A; padding: .75rem; font: 700 .92rem 'DM Sans', sans-serif; cursor: pointer; transition: background .2s ease }
        .button:hover { background: #FFF0C4 }
        .submit-wrap { margin-top: .85rem }
        .other { color: #AA94B1; text-align: center; font-size: .85rem; margin: .85rem 0 0 }
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
            <p class="tagline">A clear foundation for every organization and every team.</p>
        </div>
        <small>Secure. Scalable. Organized.</small>
    </aside>
    <main class="main">
        <div class="card">
            <h1>Create your account</h1>
            <p class="intro">Register to join or establish your organization workspace.</p>
            @if($errors->any())
                <div class="error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf
                <div class="field">
                    <label for="organization_name">Organization name</label>
                    <input id="organization_name" name="organization_name" value="{{ old('organization_name') }}" required autocomplete="off">
                </div>
                <div class="field">
                    <label for="name">Full name</label>
                    <input id="name" name="name" value="{{ old('name') }}" required>
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
                <div class="field">
                    <label for="password_confirmation">Confirm password</label>
                    <div class="password">
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                        <button class="toggle" type="button" data-password="password_confirmation" aria-label="Show password">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7S2 12 2 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="field hidden-field" id="departmentFieldBlock" style="display: none;">
                    <label for="department">Department</label>
                    <select id="department" name="department">
                        <option value="" disabled selected>Select Department</option>
                        @foreach(['Engineering', 'Finance', 'HR', 'Marketing', 'Operations', 'Sales'] as $dept)
                            <option value="{{ $dept }}" {{ old('department')===$dept?'selected':'' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field hidden-field" id="roleFieldBlock" style="display: none;">
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="" disabled selected>Select Role</option>
                        @foreach(['CEO', 'HR', 'Manager', 'Employee', 'Support'] as $role)
                            <option value="{{ $role }}" {{ old('role')===$role?'selected':'' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="submit-wrap">
                    <button class="button" type="submit">Create account</button>
                </div>
            </form>
            <p class="other">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </main>
</div>
<script>
    document.querySelectorAll('[data-password]').forEach(button => button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.password);
        input.type = input.type === 'password' ? 'text' : 'password';
        button.setAttribute('aria-label', input.type === 'password' ? 'Show password' : 'Hide password')
    }));

    const orgInput = document.getElementById('organization_name');
    const deptBlock = document.getElementById('departmentFieldBlock');
    const roleBlock = document.getElementById('roleFieldBlock');
    const deptSelect = document.getElementById('department');
    const roleSelect = document.getElementById('role');

    let debounceTimeout = null;

    function checkOrgName(name) {
        if (!name.trim()) {
            toggleExtraFields(false);
            return;
        }

        fetch(`/api/check-organization?name=${encodeURIComponent(name.trim())}`)
            .then(res => res.json())
            .then(data => {
                toggleExtraFields(data.exists);
            })
            .catch(err => console.error('Error checking organization:', err));
    }

    function toggleExtraFields(show) {
        if (show) {
            deptBlock.style.display = 'block';
            roleBlock.style.display = 'block';
            deptBlock.classList.remove('hidden-field');
            roleBlock.classList.remove('hidden-field');
            deptSelect.setAttribute('required', 'required');
            roleSelect.setAttribute('required', 'required');
        } else {
            deptBlock.style.display = 'none';
            roleBlock.style.display = 'none';
            deptBlock.classList.add('hidden-field');
            roleBlock.classList.add('hidden-field');
            deptSelect.removeAttribute('required');
            roleSelect.removeAttribute('required');
            deptSelect.value = '';
            roleSelect.value = '';
        }
    }

    orgInput.addEventListener('input', (e) => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            checkOrgName(e.target.value);
        }, 300);
    });

    orgInput.addEventListener('blur', (e) => {
        checkOrgName(e.target.value);
    });

    if (orgInput.value) {
        checkOrgName(orgInput.value);
    }
</script>
</body>
</html>
