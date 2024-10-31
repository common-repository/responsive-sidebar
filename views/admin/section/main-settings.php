<?php

if ( ! defined('WPINC')) {
    die;
}

use  ResponsiveSidebar\Admin\Settings;


$sidebarsWidgets = wp_get_sidebars_widgets();
global $wp_registered_sidebars;


echo '<h3>'.__('Appearance settings', 'responsive-sidebar').' <a href="' .
    wp_kses(esc_url(add_query_arg(array(
        'autofocus' => array(
            'panel' => 'responsive_sidebar',
        ),
        'url' => home_url(),
    ), admin_url('customize.php'))), array(
        'a' => array(
            'href' => array(),
            'title' => array(),
        ),
    ))

    . '" aria-label="' . esc_attr__('View Responsive Sidebar settings', 'responsive-sidebar') . '">' . esc_html__('in the Customizer', 'responsive-sidebar') . '</a></h3>';
?>
<table class="form-table">
    <tbody>

    <tr>
        <th scope="row"><?php _e('Select a sidebar','responsive-sidebar') ?></th>
        <td>
            <?php

            foreach ($sidebarsWidgets as $key => $sidebar) {
                if(!empty($sidebar) && $key != 'wp_inactive_widgets'){ ?>
                    <label>
                        <input type="checkbox" name="<?php echo Settings::OPTIONS; ?>[sidebars][]" value="<?= $key; ?>" <?= array_search($key, $sidebars) !== false?'checked':''; ?>>
                        <?= $wp_registered_sidebars[$key]['name']; ?>
                    </label><br>
                    <p><?= $wp_registered_sidebars[$key]['description']; ?></p><br>
               <?php }

            }
            ?>
        </td>
    </tr>

    <tr>
        <th scope="row"><?php _e('Or enter the ID of the sidebar','responsive-sidebar') ?></th>
        <td>
            <input type="text"  name="<?=Settings::OPTIONS?>[cssClasses]" size="26" value="<?php echo esc_attr( $cssClasses ) ?>" />
        </td>
    </tr>

    <tr>
        <th scope="row"><?php _e('Maximum screen width (px)','responsive-sidebar') ?></th>
        <td>
            <input type="text"  name="<?=Settings::OPTIONS?>[maxWidth]" size="26" value="<?php echo esc_attr( $maxWidth ) ?>" />
            <p class="description">
                <?php _e('Show Responsive Sidebar on devices with lesser or equal width','responsive-sidebar') ?>
            </p>
        </td>

    </tr>


    <tr>
        <th scope="row"><?php _e('Sidebar swipe','responsive-sidebar') ?></th>

        <td>
            <label>
                <input type="checkbox" name="<?php echo Settings::OPTIONS; ?>[sidebarSwipe]" value="1" <?php checked(true, $sidebarSwipe); ?>>
                <?php
                _e('enable', 'responsive-sidebar');
                ?>
            </label>
        </td>
    </tr>

    </tbody>
</table>
