<?php namespace ResponsiveSidebar\Admin;

use Premmerce\SDK\V2\FileManager\FileManager;
use ResponsiveSidebar\ResponsiveSidebarPlugin;
/**
 * Class Admin
 *
 * @package ResponsiveSidebar\Admin
 */
class Admin {

	/**
	 * @var FileManager
	 */
	private $fileManager;

    /**
     * @var Settings
     */
    private $settings;


    /**
	 * Admin constructor.
	 *
	 * Register menu items and handlers
	 *
	 * @param FileManager $fileManager
	 */
	public function __construct( FileManager $fileManager ) {
		$this->fileManager = $fileManager;
        $this->settings = new Settings($fileManager);
		$this->registerActions();
	}

    public function registerActions(){
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
        add_filter('plugin_action_links_responsive-sidebar/responsive-sidebar.php', array($this, 'PluginActionLinks'));
        add_action('admin_init', array($this->settings, 'registerSettings'));
        add_action('admin_menu', array($this, 'addMenuPage'));


    }

    public function enqueueScripts()
    {

        wp_enqueue_style(
            'rs-admin-styles',
            $this->fileManager->locateAsset('admin/css/rs-admin.css'),
            array(),
            ResponsiveSidebarPlugin::VERSION
        );

    }

    public function PluginActionLinks($links)
    {
        $action_links = array(
            'settings' => '<a href="' . admin_url('admin.php?page=responsive-sidebar-admin') .
                '" aria-label="' . esc_attr__('Responsive Sidebar', 'responsive-sidebar') .
                '">' . esc_html__('Settings', 'responsive-sidebar') .
                '</a>');

        return array_merge($action_links, $links);
    }

    public function addMenuPage()
    {

        add_options_page(
            __('Responsive Sidebar', 'responsive-sidebar'),
            __('Responsive Sidebar', 'responsive-sidebar'),
            'edit_theme_options',
            'responsive-sidebar-admin',
            array($this, 'optionsPage')
        );
    }

    /**
     * Options page
     */
    public function optionsPage()
    {

        $current = isset($_GET['tab']) ? $_GET['tab'] : 'settings';

        $tabs['settings'] = __('Settings', 'responsive-sidebar');
        $tabs['instructions'] = __('Instructions', 'responsive-sidebar');

        $tabs = false;

        $this->fileManager->includeTemplate('admin/main.php', array(
            'settings' => $this->settings,
            'tabs' => $tabs,
            'current' => $current,
        ));
    }

}