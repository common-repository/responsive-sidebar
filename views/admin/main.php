<?php

if ( ! defined('WPINC')) {
    die;
}

?>
<div class="wrap">
    <h1><?php _e('Responsive Sidebar settings', 'responsive-sidebar') ?></h1>
    <?php if($tabs): ?>
    <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab => $name): ?>
            <?php $class = ($tab == $current) ? ' nav-tab-active' : ''; ?>
            <a class='nav-tab<?php echo $class ?>'
               href='?page=responsive-sidebar-admin&tab=<?php echo $tab ?>'><?php echo $name ?></a>
        <?php endforeach; ?>
    </h2>
    <?php endif; ?>

    <?php
        $file = __DIR__ . "/tabs/{$current}.php";
        if (file_exists($file)){
            include $file;
        }
    ?>

    <?php _e('If you like <strong>Responsive Sidebar</strong> please leave us a <a href="https://wordpress.org/support/plugin/responsive-sidebar/reviews?rate=5#new-post" target="_blank">★★★★★</a> rating.','responsive-sidebar') ?><br>
    <?php _e('Or', 'responsive-sidebar'); ?> support on <strong><a href="https://www.patreon.com/processby" ><?php _e('Patreon', 'responsive-sidebar'); ?></a></strong>, <strong><a href="https://www.paypal.com/donate/?hosted_button_id=C28JNE5JS75X4">PayPal</a></strong>. <?php _e('Thanks!', 'responsive-sidebar'); ?>

</div>