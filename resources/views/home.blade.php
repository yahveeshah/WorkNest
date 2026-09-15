<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>WorkNest | Employee Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}
        body{margin:0;background:#27142E;color:#F7EFE5;font-family:'DM Sans',sans-serif}
        .navbar{position:sticky;top:0;z-index:10;width:100%;padding:1.25rem 5rem;background:#27142E;border-bottom:1px solid rgba(170,148,177,.15);display:flex;justify-content:space-between;align-items:center}
        .nav-actions{display:flex;gap:.85rem;align-items:center}
        .button{display:inline-block;background:#F6EB61;color:#1A1A1A;padding:.6rem 1.75rem;border:0;border-radius:8px;font:700 .88rem 'DM Sans',sans-serif;text-decoration:none;cursor:pointer;box-shadow:none;transition:background .2s ease,transform .2s ease}
        .button:hover{background:#FFF0C4;transform:translateY(-1px)}
        .cta{padding:.9rem 2.6rem;border-radius:50px;font-size:.95rem;font-weight:700}
        .hero{padding:5rem 5rem 4rem;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center}
        .label{margin:0 0 1rem;color:#AA94B1;font-size:.75rem;letter-spacing:2.5px;font-weight:600;text-transform:uppercase}
        .hero h1{margin:0 0 1.25rem;color:#F7EFE5;font:700 2.8rem/1.18 'Cormorant Garamond',serif}
        .hero-copy{max-width:460px;margin:0 0 2.25rem;color:#AA94B1;font-size:.95rem;line-height:1.8}
        .carousel-wrap{position:relative;padding:0 3rem;width:100%}
        .carousel{position:relative;overflow:hidden;border-radius:20px}
        .carousel-viewport{position:relative;min-height:390px}
        .carousel-card{position:relative;width:100%;min-height:390px;padding:3rem 2.5rem;background:#CBB3C4;border-radius:20px;display:flex;flex-direction:column;justify-content:center;box-sizing:border-box}
        .carousel-track{position:relative;width:100%;min-height:260px;flex:1}
        .carousel-slide{position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center;opacity:0;pointer-events:none;visibility:hidden}
        .carousel-slide.active{opacity:1;pointer-events:auto;visibility:visible}
        .carousel-eyebrow,.carousel-title,.carousel-description{opacity:0;transform:translateY(8px);transition:opacity .35s ease-out,transform .35s ease-out}
        .carousel-slide.active:not(.is-entering):not(.is-leaving) .carousel-eyebrow,.carousel-slide.active:not(.is-entering):not(.is-leaving) .carousel-title,.carousel-slide.active:not(.is-entering):not(.is-leaving) .carousel-description{opacity:1;transform:translateY(0);transition:none}
        .carousel-slide.is-leaving .carousel-eyebrow,.carousel-slide.is-leaving .carousel-title,.carousel-slide.is-leaving .carousel-description{opacity:0;transform:translateY(0);transition:opacity .18s ease-out,transform .18s ease-out}
        .carousel-slide.is-entering .carousel-eyebrow{opacity:1;transform:translateY(0);transition-delay:0ms}
        .carousel-slide.is-entering .carousel-title{opacity:1;transform:translateY(0);transition-delay:80ms}
        .carousel-slide.is-entering .carousel-description{opacity:1;transform:translateY(0);transition-delay:160ms}
        .carousel-eyebrow{margin:0 0 .5rem;color:#4A1F50;font-size:.75rem;letter-spacing:2px;font-weight:600;text-transform:uppercase}
        .carousel-title{margin:0 0 .85rem;color:#27142E;font:700 1.8rem 'Cormorant Garamond',serif}
        .carousel-description{margin:0;color:#27142E;font-size:.95rem;line-height:1.75;opacity:.9}
        .carousel-dots{display:flex;justify-content:center;gap:.55rem;margin-top:1.5rem}
        .carousel-dot{width:8px;height:8px;border:none;border-radius:50%;padding:0;background:rgba(247,239,229,.35);cursor:pointer;transition:background .2s ease,transform .2s ease}
        .carousel-dot.active{background:#F7EFE5;transform:scale(1.1)}
        .carousel-dot:hover:not(.active){background:rgba(247,239,229,.65)}
        .arrow{position:absolute;top:50%;z-index:2;transform:translateY(-50%);border:0;background:none;box-shadow:none;border-radius:0;color:#F7EFE5;display:grid;place-items:center;cursor:pointer;padding:0;transition:color .2s ease;appearance:none;-webkit-appearance:none}
        .arrow:hover{color:#F6EB61}
        .arrow.left{left:-2.25rem}
        .arrow.right{right:-2.25rem}
        .arrow svg{width:28px;height:28px;display:block}

        .section{padding:5.5rem 5rem;background:#27142E}
        .section-header{margin-bottom:3.5rem;text-align:center}
        .section-header h2{margin:0 0 .6rem;font:700 2.5rem 'Cormorant Garamond',serif;color:#F7EFE5}
        .section-header p{margin:0 auto;max-width:500px;color:#AA94B1;font-size:.95rem;line-height:1.7}
        .advantages-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem}
        .advantage-card{padding:2.25rem 1.75rem;border-radius:20px;color:#27142E;box-sizing:border-box}
        .advantage-card.mauve{background:#CBB3C4}
        .advantage-card.cream{background:#F5EBE1}
        .advantage-icon{width:36px;height:36px;margin-bottom:1.5rem;color:#27142E}
        .advantage-card h3{margin:0 0 .6rem;font:700 1.25rem 'Cormorant Garamond',serif;color:#27142E}
        .advantage-card p{margin:0;font-size:.9rem;line-height:1.65;color:#27142E;opacity:.88}
        .footer{margin:0 5rem;padding:2.25rem 0;border-top:1px solid rgba(170,148,177,.15);display:flex;justify-content:space-between;align-items:center;color:#AA94B1;font-size:.82rem}
        @media(max-width:1100px){.advantages-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:900px){
            .navbar{padding:1rem 1.5rem}
            .hero{padding:3.5rem 1.5rem;grid-template-columns:1fr;gap:2.5rem}
            .hero h1{font-size:2.2rem}
            .section{padding:3.5rem 1.5rem}
            .footer{margin:0 1.5rem}
            .carousel-wrap{padding:0 2rem}
        }
        @media(max-width:580px){
            .navbar{align-items:flex-start;gap:1rem;flex-direction:column}
            .hero h1{font-size:1.9rem}
            .advantages-grid{grid-template-columns:1fr}
            .footer{flex-direction:column;align-items:flex-start;gap:1rem}
        }
    </style>
</head>
<body>
<header class="navbar">
    @include('partials.logo', ['height' => 40])
    <div class="nav-actions">
        @auth
            <form action="{{ route('logout') }}" method="POST">@csrf<button class="button" type="submit">Logout</button></form>
        @else
            <a class="button" href="{{ route('login') }}">Login</a>
            <a class="button" href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</header>

<main class="hero">
    <section>
        <p class="label">EMPLOYEE MANAGEMENT SYSTEM</p>
        <h1>Manage Your People.<br>Grow Your Organization.</h1>
        <p class="hero-copy">WorkNest unifies every department, employee, and workflow in one centralized platform — giving your organization the visibility and control it needs to operate at its best.</p>
        @auth
            <a class="button cta" href="/{{ strtolower(auth()->user()->department) }}/dashboard">Go to Dashboard</a>
        @else
            <a class="button cta" href="{{ route('register') }}">Get Started</a>
        @endauth
    </section>

    <section class="carousel-wrap" aria-label="WorkNest benefits">
        <div class="carousel">
            <div class="carousel-viewport" id="carousel-viewport">
                <article class="carousel-card">
                    <div class="carousel-track" id="carousel-track">
                        <div class="carousel-slide active" data-slide="0" role="group" aria-roledescription="slide" aria-label="Slide 1 of 3">
                            <p class="carousel-eyebrow">01 / ORGANIZATION</p>
                            <h2 class="carousel-title">Organization clarity</h2>
                            <p class="carousel-description">Bring employee information and department membership into one dependable organization workspace.</p>
                        </div>
                        <div class="carousel-slide" data-slide="1" role="group" aria-roledescription="slide" aria-label="Slide 2 of 3">
                            <p class="carousel-eyebrow">02 / TEAMS</p>
                            <h2 class="carousel-title">Focused access</h2>
                            <p class="carousel-description">Give each department a focused portal that respects its responsibilities and priorities.</p>
                        </div>
                        <div class="carousel-slide" data-slide="2" role="group" aria-roledescription="slide" aria-label="Slide 3 of 3">
                            <p class="carousel-eyebrow">03 / GROWTH</p>
                            <h2 class="carousel-title">Built for the future</h2>
                            <p class="carousel-description">Keep your organization structured as teams grow, responsibilities evolve, and work moves forward.</p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <div class="carousel-dots" id="carousel-dots" aria-label="Carousel pagination">
            <button class="carousel-dot active" type="button" data-slide="0" aria-label="Go to slide 1"></button>
            <button class="carousel-dot" type="button" data-slide="1" aria-label="Go to slide 2"></button>
            <button class="carousel-dot" type="button" data-slide="2" aria-label="Go to slide 3"></button>
        </div>
        <button class="arrow left" type="button" data-move="-1" aria-label="Previous slide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <button class="arrow right" type="button" data-move="1" aria-label="Next slide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m9 18 6-6-6-6"/></svg>
        </button>
    </section>
</main>

<section class="section">
    <div class="section-header">
        <h2>WorkNest Provides</h2>
        <p>Everything your team needs to stay aligned, informed, and productive — in one place.</p>
    </div>
    <div class="advantages-grid">
        <article class="advantage-card mauve">
            <svg class="advantage-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            <h3>Centralized Management</h3>
            <p>One hub for employees, departments, and workflows — no more scattered tools.</p>
        </article>
        <article class="advantage-card cream">
            <svg class="advantage-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="m7 14 4-4 4 4 5-6"/></svg>
            <h3>Real-Time Insights</h3>
            <p>Track attendance, performance, and team activity as it happens.</p>
        </article>
        <article class="advantage-card mauve">
            <svg class="advantage-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <h3>Secure Access</h3>
            <p>Role-based permissions ensure every user sees only what they need.</p>
        </article>
        <article class="advantage-card cream">
            <svg class="advantage-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            <h3>Time Saved</h3>
            <p>Automate routine HR tasks so your team can focus on what matters.</p>
        </article>
    </div>
</section>

<footer class="footer">
    @include('partials.logo', ['height' => 40])
    <span>&copy; {{ date('Y') }} WorkNest</span>
</footer>

<script>
(function () {
    const slides = Array.from(document.querySelectorAll('.carousel-slide'));
    const dots = Array.from(document.querySelectorAll('.carousel-dot'));
    const total = slides.length;
    if (total === 0) return;

    const FADE_OUT = 180;
    const STAGGER_END = 180;
    const ENTER_DURATION = 400;
    const ENTER_TOTAL = STAGGER_END + ENTER_DURATION;

    let current = 0;
    let isAnimating = false;
    let autoTimer = null;
    let resumeTimer = null;

    function updateDots() {
        dots.forEach((dot, i) => {
            const isActive = i === current;
            dot.classList.toggle('active', isActive);
            dot.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    }

    function resetSlideState(slide) {
        slide.classList.remove('is-leaving', 'is-entering');
    }

    function goTo(index) {
        const next = ((index % total) + total) % total;
        if (isAnimating || next === current) return;

        isAnimating = true;
        const outgoing = slides[current];
        const incoming = slides[next];

        resetSlideState(incoming);
        outgoing.classList.add('is-leaving');

        setTimeout(() => {
            outgoing.classList.remove('active', 'is-leaving');
            resetSlideState(outgoing);

            incoming.classList.add('active', 'is-entering');
            current = next;
            updateDots();

            setTimeout(() => {
                incoming.classList.remove('is-entering');
                isAnimating = false;
            }, ENTER_TOTAL);
        }, FADE_OUT);
    }

    function nextSlide() {
        goTo(current + 1);
    }

    function startAutoAdvance() {
        clearInterval(autoTimer);
        autoTimer = setInterval(nextSlide, 3500);
    }

    function pauseAutoAdvance() {
        clearInterval(autoTimer);
        clearTimeout(resumeTimer);
        resumeTimer = setTimeout(startAutoAdvance, 5000);
    }

    document.querySelectorAll('[data-move]').forEach(button => {
        button.addEventListener('click', () => {
            goTo(current + Number(button.dataset.move));
            pauseAutoAdvance();
        });
    });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            goTo(Number(dot.dataset.slide));
            pauseAutoAdvance();
        });
    });

    updateDots();
    startAutoAdvance();
})();
</script>
</body>
</html>
