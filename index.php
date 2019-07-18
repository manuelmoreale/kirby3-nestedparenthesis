<?php

# Add a bit of customizations to the already awesome K3
Kirby::plugin('manu/nestedparenthesis', [

    # Include the hooks
    'hooks' => include __DIR__ . '/inc/hooks.php'

]);