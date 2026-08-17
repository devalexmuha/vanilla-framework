<?php switch ( $code ):
    case 404: ?>
        <h2>Just a 404 page</h2>
        <p>Do not worry, nothing broke</p>
        <p>Page you're looking does not exist anymore</p>
    <?php break; ?>

    <?php case 403: ?>
        <h2>403 — Access Forbidden</h2>
        <p>You don't have permission to view this page</p>
    <?php break; ?>
<?php endswitch; ?>