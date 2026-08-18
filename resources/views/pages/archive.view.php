<h1>Imagine here list of blog posts</h1>
<ul>
    <?php foreach ($archiveData as $product): ?>
        <li>
            <h3><?= e($product['name']) ?></h3>
            <?php if (!empty($product['description'])): ?>
                <p><?= e($product['description']) ?></p>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>