<?php /** @var array $pageData */ ?>

<article class="mx-auto max-w-2xl">

    <a href="/pages"
       class="font-mono text-xs uppercase tracking-wider text-ink-soft transition-colors hover:text-accent">
        &larr; All pages
    </a>

    <h1 class="mt-6 font-display font-semibold leading-tight tracking-tight text-ink text-2xl md:text-3xl">
        <?= e( $pageData['name'] ) ?>
    </h1>

    <!-- vanilla-core stamp, echoing the home hero -->
    <div class="mt-4 flex items-center gap-4">
        <span class="h-px w-10 bg-line"></span>
        <span class="font-mono text-sm text-accent-deep">Vanilla Core</span>
    </div>

    <div class="mt-8 leading-relaxed text-ink/85 text-content-text">
        <p><?= e( $pageData['description'] ) ?></p>
    </div>

    <!-- admin actions -->
    <?php if ( ! empty( $_SESSION['logged_in'] ) ): ?>
        <div class="mt-10 flex items-center gap-4 border-t border-line pt-6 font-mono text-sm">

            <a href="/page/<?= e( $pageData['id'] ) ?>/edit/"
               class="border border-accent bg-accent px-4 py-1.5 uppercase tracking-wider text-on-accent transition-colors hover:bg-transparent hover:text-accent">
                Edit
            </a>

            <form action="/page/<?= e( $pageData['id'] ) ?>/delete/" method="post"
                  onsubmit="return confirm('Delete this page? This cannot be undone.');">
                <input type="hidden" name="csrf_token">
                <button type="submit"
                        class="border border-accent-deep px-4 py-1.5 uppercase tracking-wider text-accent-deep transition-colors hover:cursor-pointer hover:bg-accent-deep hover:text-on-accent">
                    Delete
                </button>
            </form>

        </div>
    <?php endif; ?>

</article>