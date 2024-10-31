<?php
namespace ResponsiveSidebar\Admin;

use Premmerce\SDK\V2\FileManager\FileManager;
use ResponsiveSidebar\Admin\Customizer\CustomizeRange;

/**
 * Class Customizer
 *
 * @package ResponsiveTable\Admin
 */



class Customizer
{

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
        $this->registerHooks();
    }

    public function registerHooks(){
        add_action('customize_register', array($this, 'addSection'));
        add_action('customize_register', array($this, 'addSettings'));
    }

    public function addSection($wp_customize){


        $wp_customize->add_panel( 'responsive_sidebar', array(
            'title'      => __('Responsive Sidebar Settings', 'responsive-sidebar'),
            'priority'   => 200,
        ) );
        $wp_customize->add_section( 'sidebar_settings' , array(
            'title'      => __('Sidebar styles', 'responsive-sidebar'),
            'panel' => 'responsive_sidebar',
        ) );
        $wp_customize->add_section( 'button_settings' , array(
            'title'      => __('Button styles', 'responsive-sidebar'),
            'panel' => 'responsive_sidebar',
        ) );

    }

    public function addSettings($wp_customize){


        //sidebar section

        $colorOptions = array(
            'label' => __('Background color', 'responsive-sidebar'),
            'default' => '#ffffff'
        );
        $this->addSetting('sidebar_background_color', 'color', $wp_customize, $colorOptions);

        $rangeOptions = array(
            'label' => __('Sidebar width (px)', 'responsive-sidebar'),
            'min' => 0,
            'max' => 500,
            'step' => 1,
            'default' => 280

        );
        $this->addSetting('sidebar_width', 'range', $wp_customize, $rangeOptions);


        $selectOptions = array('choices' => array(
            'left' => __('Left', 'responsive-sidebar'),
            'right' => __('Right', 'responsive-sidebar'),
        ),
            'default' => 'left',
            'label' => __('Sidebar position', 'responsive-sidebar'),
        );

        $this->addSetting('sidebar_position', 'select', $wp_customize, $selectOptions);



        $checkboxOptions = array(
            'label' => __('Enable shadows', 'responsive-sidebar'),
            'default' => 1
        );
        $this->addSetting('sidebar_shadows', 'checkbox', $wp_customize, $checkboxOptions);


        $checkboxOptions = array(
            'label' => __('Blackout', 'responsive-sidebar'),
            'default' => 1
        );
        $this->addSetting('sidebar_blackout', 'checkbox', $wp_customize, $checkboxOptions);


       //button section


        $checkboxOptions = array(
            'label' => __('Enable button', 'responsive-sidebar'),
            'default' => 1,
            'section' => 'button_settings'
        );
        $this->addSetting('enable_button', 'checkbox', $wp_customize, $checkboxOptions);

        $colorOptions = array(
            'label' => __('Background color', 'responsive-sidebar'),
            'default' => '#ffffff',
            'section' => 'button_settings'
        );
        $this->addSetting('button_background_color', 'color', $wp_customize, $colorOptions);

        $imageOptions = array(
            'label' => __('Image', 'responsive-sidebar'),
            'default' => $this->fileManager->locateAsset('frontend/img/sidebar-icon.png'),
            'section' => 'button_settings'
        );
        $this->addSetting('button_image', 'image', $wp_customize,  $imageOptions);

        $rangeOptions = array(
            'label' => __('Image width (px)', 'responsive-sidebar'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 30,
            'section' => 'button_settings'

        );
        $this->addSetting('button_image_width', 'range', $wp_customize, $rangeOptions);

        $checkboxOptions = array(
            'label' => __('Button text', 'responsive-sidebar'),
            'default' => '',
            'section' => 'button_settings'
        );
        $this->addSetting('button_text', 'text', $wp_customize, $checkboxOptions);

        $checkboxOptions = array(
            'label' => __('Bold text', 'responsive-sidebar'),
            'default' => 0,
            'section' => 'button_settings'
        );
        $this->addSetting('button_bold_text', 'checkbox', $wp_customize, $checkboxOptions);



        $rangeOptions = array(
            'label' => __('Border radius (%)', 'responsive-sidebar'),
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'default' => 100,
            'section' => 'button_settings'

        );
        $this->addSetting('border_radius', 'range', $wp_customize, $rangeOptions);

        $rangeOptions = array(
            'label' => __('Button width (px)', 'responsive-sidebar'),
            'min' => 0,
            'max' => 500,
            'step' => 1,
            'default' => 50,
            'section' => 'button_settings'

        );
        $this->addSetting('button_width', 'range', $wp_customize, $rangeOptions);

        $rangeOptions = array(
            'label' => __('Button height (px)', 'responsive-sidebar'),
            'min' => 0,
            'max' => 500,
            'step' => 1,
            'default' => 50,
            'section' => 'button_settings'

        );
        $this->addSetting('button_height', 'range', $wp_customize, $rangeOptions);


        $selectOptions = array('choices' => array(
            'bottom_right' => __('Bottom right', 'responsive-sidebar'),
            'bottom_left' => __('Bottom left', 'responsive-sidebar'),
            'top_right' => __('Top right', 'responsive-sidebar'),
            'top_left' => __('Top left', 'responsive-sidebar'),

        ),
            'default' => 'bottom_right',
            'label' => __('Button position', 'responsive-sidebar'),
            'section' => 'button_settings'
        );

        $this->addSetting('button_position', 'select', $wp_customize, $selectOptions);


        $rangeOptions = array(
            'label' => __('Horizontal margin (px)', 'responsive-sidebar'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 20,
            'section' => 'button_settings'

        );
        $this->addSetting('margin_x', 'range', $wp_customize, $rangeOptions);

        $rangeOptions = array(
            'label' => __('Vertical margin (px)', 'responsive-sidebar'),
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'default' => 20,
            'section' => 'button_settings'

        );
        $this->addSetting('margin_y', 'range', $wp_customize, $rangeOptions);

        $checkboxOptions = array(
            'label' => __('Enable shadows', 'responsive-sidebar'),
            'default' => 1,
            'section' => 'button_settings'
        );
        $this->addSetting('button_shadows', 'checkbox', $wp_customize, $checkboxOptions);


    }


    private function addSetting($name, $type, $wp_customize, $args = array())
    {

        $default = array(
            'default' => '',
            'description' => '',
            'active_callback' => '',
            'label' => '',
            'section' => 'sidebar_settings'
        );
        $args = array_merge($default, $args);

        switch ($type) {
            case 'text':
            case 'checkbox':
                $wp_customize->add_setting($name, array(
                    'default' => $args['default']
                ));
                $wp_customize->selective_refresh->add_partial($name, array(
                    'selector' => '.' . $name
                ));
                $wp_customize->add_control($name, array(
                        'label' => $args['label'],
                        'section' => $args['section'],
                        'type' => $type
                    )
                );
                break;

            case 'select':
                $wp_customize->add_setting($name, array(
                    'capability' => 'edit_theme_options',
                    'default' => $args['default'],
                ));
                $wp_customize->selective_refresh->add_partial($name, array(
                    'selector' => '.' . $name
                ));

                $wp_customize->add_control($name, array(
                    'type' => 'select',
                    'section' => $args['section'],
                    'label' => $args['label'],
                    'description' => __($args['description'], 'responsive-sidebar'),
                    'choices' => $args['choices'],
                ));
                break;

            case 'radio':
                $wp_customize->add_setting($name, array(
                    'capability' => 'edit_theme_options',
                    'default' => $args['default'],
                ));
                $wp_customize->selective_refresh->add_partial($name, array(
                    'selector' => '.'.$name
                ));

                $wp_customize->add_control($name, array(
                    'type' => 'radio',
                    'section' => $args['section'],
                    'label' => $args['label'],
                    'description' => __($args['description'], 'responsive-sidebar'),
                    'choices' => $args['choices'],
                ));
                break;

            case 'range':
                $wp_customize->add_setting($name, array(
                    'default' => $args['default']
                ));
                $wp_customize->selective_refresh->add_partial($name, array(
                    'selector' => '.'.$name
                ));

                $wp_customize->add_control(new CustomizeRange($wp_customize, $name, array(
                    'label' => $args['label'],
                    'min' => $args['min'],
                    'max' => $args['max'],
                    'step' => $args['step'],
                    'section' => $args['section'],
                    'active_callback'	=> $args['active_callback']
                )));

                break;

            case 'color':
                $wp_customize->add_setting($name, array(
                    'default' => $args['default'],
                ));
                $wp_customize->selective_refresh->add_partial($name, array(
                    'selector' => '.'.$name
                ));

                $wp_customize->add_control(new \WP_Customize_Color_Control($wp_customize, $name, array(
                    'label' => $args['label'],
                    'section' => $args['section'],
                    'settings' => $name,
                    'active_callback'	=> $args['active_callback'],
                )));


                break;

            case 'image':
                $wp_customize->add_setting($name, array(
                    'capability' => 'edit_theme_options',
                    'default' => $args['default'],
                ));


                $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, $name, array(
                    'label' => $args['label'],
                    'section' => $args['section'],
                    'settings' => $name,
                    'type' => 'image',
                    'active_callback'	=> $args['active_callback'],
                )));

                break;
        }



    }


}