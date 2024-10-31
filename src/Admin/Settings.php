<?php namespace ResponsiveSidebar\Admin;

use Premmerce\SDK\V2\FileManager\FileManager;

class Settings
{

    const OPTIONS = 'responsive_sidebar';

    const SETTINGS_PAGE = 'responsive_sidebar_page';

    private $fileManager;

    private $options;

//plugin default options

    const CSS_CLASSES = 'secondary';
    const MAX_WIDTH = 768;
    const SIDEBAR_SWIPE = 1;



    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
        $this->options = get_option(self::OPTIONS);

    }


    public function registerSettings()
    {
        register_setting(self::OPTIONS, self::OPTIONS, array(
            'sanitize_callback' => array($this, 'updateSettings'),
        ));

        add_settings_section('main_settings', __('', 'responsive-sidebar'), array(
            $this,
            'mainSection',
        ), self::SETTINGS_PAGE);

    }

    public function mainSection()
    {
        $this->fileManager->includeTemplate('admin/section/main-settings.php', array(
            'cssClasses' => $this->getOption('cssClasses'),
            'maxWidth' => $this->getOption('maxWidth'),
            'sidebarSwipe' => $this->getOption('sidebarSwipe'),
            'sidebars' => $this->getOption('sidebars')
        ));
    }

    public function showSettings()
    {
        print('<form action="' . admin_url('options.php') . '" method="post">');

        //settings_errors();

        settings_fields(self::OPTIONS);

        do_settings_sections(self::SETTINGS_PAGE);

        submit_button();
        print('</form>');
    }


    public function updateSettings($settings)
    {
        //dump($settings); die;
        if(!isset($settings['sidebarSwipe']))
            $settings['sidebarSwipe'] = 0;

        if(!isset($settings['sidebars']))
            $settings['sidebars'] = array();


        return $settings;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getOption($key, $default = null)
    {
        return isset($this->options[ $key ])? $this->options[ $key ] : $default;
    }
}
