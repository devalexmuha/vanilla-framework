<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css"/>
    <title><?= $statusCode ?> &middot; Vanilla Core</title>
</head>
<body>
<main class="min-h-screen w-full max-w-full overflow-hidden bg-paper text-ink font-sans flex items-center justify-center">
    <section class="container flex flex-col items-center text-center">

        <!-- status code — the anchor -->
        <span class="font-display font-semibold leading-none tracking-tight text-accent text-hero">
            <?= $statusCode ?>
        </span>

        <!-- flanking-rule stamp, echoing the home hero -->
        <div class="mt-6 flex items-center gap-4">
            <span class="h-px w-12 bg-line"></span>
            <span class="font-mono text-sm uppercase tracking-wider text-accent-deep">Vanilla Core</span>
            <span class="h-px w-12 bg-line"></span>
        </div>

        <!-- message -->
        <div class="mt-8 flex flex-col gap-2">
            <?php switch ( $statusCode ):
                case 404: ?>
                    <h2 class="font-display text-2xl font-semibold text-ink">Just a 404 page</h2>
                    <p class="text-tag text-ink-soft">Do not worry, nothing broke.</p>
                    <p class="text-tag text-ink-soft">The page you're looking for does not exist anymore.</p>
                    <?php break; ?>

                <?php case 500: ?>
                    <h2 class="font-display text-2xl font-semibold text-ink">Oops, here is error 500</h2>
                    <p class="text-tag text-ink-soft">Do not worry, our technicians are already working on it.</p>
                    <p class="text-tag text-ink-soft">Please come back a little later.</p>
                    <?php break; ?>

                <?php default: ?>
                    <h2 class="font-display text-2xl font-semibold text-ink">Something went sideways</h2>
                    <p class="text-tag text-ink-soft">An unexpected error occurred.</p>
                <?php endswitch; ?>
        </div>

        <!-- back link -->
        <a href="/"
           class="group mt-10 inline-flex items-center gap-1.5 font-mono text-sm uppercase tracking-wider text-accent transition-colors hover:text-accent-deep">
            <span class="transition-transform group-hover:-translate-x-0.5">&larr;</span>
            Back home
        </a>

    </section>
</main>
</body>
</html>