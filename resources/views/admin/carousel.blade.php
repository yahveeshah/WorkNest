<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Carousel Slides | WorkNest Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;background:#4A1F50;color:#F2E5D5;font-family:'DM Sans',sans-serif}
        .layout{display:grid;grid-template-columns:280px 1fr;min-height:100vh}
        .sidebar{background:#341539;border-right:1px solid rgba(209,176,193,.1);padding:2.5rem 1.8rem;display:flex;flex-direction:column}
        .nav{margin:3rem 0;padding:0;list-style:none}
        .nav a{display:block;padding:.75rem 1rem;color:#D1B0C1;text-decoration:none;font-size:.9rem;border-left:3px solid transparent}
        .nav a.active,.nav a:hover{color:#F6EB61;border-left-color:#F6EB61;background:rgba(246,235,97,.04)}
        .logout{width:100%;margin-top:auto;border:0;border-radius:50px;background:#F6EB61;color:#000;padding:.65rem;font:600 .9rem 'DM Sans',sans-serif;cursor:pointer}
        .main{padding:3rem 4rem;max-width:900px}
        .header{padding-bottom:1.5rem;margin-bottom:2rem;border-bottom:1px solid rgba(209,176,193,.08)}
        .badge{display:inline-block;padding:.25rem .75rem;border-radius:4px;background:rgba(246,235,97,.1);color:#F6EB61;font-size:.8rem;letter-spacing:1px}
        .header h1{margin:.7rem 0 .3rem;font:700 2.4rem 'Cormorant Garamond',serif}
        .header p{margin:0;color:#D1B0C1}
        .status{padding:1rem;margin-bottom:1.5rem;background:rgba(246,235,97,.08);border-left:3px solid #F6EB61;border-radius:4px;font-size:.9rem}
        .slide-card{padding:1.75rem;margin-bottom:1.5rem;border:1px solid rgba(209,176,193,.12);border-radius:14px;background:#341539}
        .slide-card h2{margin:0 0 1.25rem;color:#F6EB61;font:600 1.3rem 'Cormorant Garamond',serif}
        .field{margin-bottom:1rem}label{display:block;margin-bottom:.4rem;color:#D1B0C1;font-size:.88rem}
        input,textarea{width:100%;padding:.75rem 1rem;background:#4A1F50;color:#F2E5D5;border:1px solid #D1B0C1;border-radius:10px;font:400 .92rem 'DM Sans',sans-serif}
        textarea{min-height:90px;resize:vertical}input:focus,textarea:focus{outline:0;border-color:#F6EB61}
        .error{color:#C0616A;font-size:.85rem;margin-top:.35rem}
        .button{border:0;border-radius:50px;background:#F6EB61;color:#1a1a1a;padding:.8rem 2rem;font:700 .92rem 'DM Sans',sans-serif;cursor:pointer}
        @media(max-width:850px){.layout{grid-template-columns:1fr}.main{padding:2rem 1.5rem}}
    </style>
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        @include('partials.logo', ['height' => 40])
        <ul class="nav">
            <li><a href="{{ route('admin.dashboard') }}">Overview</a></li>
            <li><a href="{{ route('admin.carousel.edit') }}" class="active">Carousel Slides</a></li>
        </ul>
        <form action="{{ route('logout') }}" method="POST">@csrf<button class="logout" type="submit">Logout</button></form>
    </aside>
    <main class="main">
        <header class="header">
            <span class="badge">{{ $organization->name }}</span>
            <h1>Homepage Carousel</h1>
            <p>Edit the three slides shown on your organization's homepage carousel.</p>
        </header>

        @if(session('status'))
            <div class="status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.carousel.update') }}">
            @csrf
            @method('PUT')

            @foreach($slides as $index => $slide)
                <section class="slide-card">
                    <h2>Slide {{ $index + 1 }}</h2>
                    <div class="field">
                        <label for="slides_{{ $index }}_title">Title</label>
                        <input id="slides_{{ $index }}_title" name="slides[{{ $index }}][title]" value="{{ old('slides.'.$index.'.title', $slide->title) }}" required>
                        @error('slides.'.$index.'.title')<div class="error">{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label for="slides_{{ $index }}_subtitle">Subtitle <span style="opacity:.6">(optional)</span></label>
                        <input id="slides_{{ $index }}_subtitle" name="slides[{{ $index }}][subtitle]" value="{{ old('slides.'.$index.'.subtitle', $slide->subtitle) }}">
                        @error('slides.'.$index.'.subtitle')<div class="error">{{ $message }}</div>@enderror
                    </div>
                    <div class="field">
                        <label for="slides_{{ $index }}_description">Description</label>
                        <textarea id="slides_{{ $index }}_description" name="slides[{{ $index }}][description]" required>{{ old('slides.'.$index.'.description', $slide->description) }}</textarea>
                        @error('slides.'.$index.'.description')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </section>
            @endforeach

            <button class="button" type="submit">Save carousel slides</button>
        </form>
    </main>
</div>
</body>
</html>
