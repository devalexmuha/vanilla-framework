<?php switch ( $statusCode ):
    case 404: ?>
        <h2>Just a 404 page</h2>
        <p>Do not worry, nothing broke</p>
        <p>Page you're looking does not exist anymore</p>
    <?php break; ?>

    <?php case 500: ?>
        <h2>Ops, here is error 500</h2>
        <p>Do not worry, our technicians already working on fixing it</p>
        <p>Just, please come back a bit latter</p>
    <?php break; ?>
<?php endswitch; ?>

