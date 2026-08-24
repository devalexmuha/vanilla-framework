<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css"/>
    <title>{{ $pageData['name'] ?? 'Vanilla Core' }}</title>
</head>
<body>
<div class="min-h-screen w-full max-w-full bg-paper text-ink font-sans flex flex-col">

    <!-- ── NAV ── -->
    <vc-nav.header/>

    <!-- ── CONTENT ── -->
    <main class="w-full flex-1">
        <div class="container py-12">{{ view }}</div>
    </main>

    <!-- ── FOOTER ── -->
    <vc-nav.footer/>

</div>
</body>
</html>