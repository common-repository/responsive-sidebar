<?php namespace ResponsiveSidebar;

use Premmerce\SDK\V2\FileManager\FileManager;
use ResponsiveSidebar\Admin\Admin;
use ResponsiveSidebar\Admin\Settings;
use ResponsiveSidebar\Admin\Customizer;
use ResponsiveSidebar\Frontend\Frontend;

/**
 * Class ResponsiveSidebarPlugin
 *
 * @package ResponsiveSidebar
 */
class ResponsiveSidebarPlugin {

    const VERSION = '1.2.2';

	/**
	 * @var FileManager
	 */
	private $fileManager;

	/**
	 * ResponsiveSidebarPlugin constructor.
	 *
     * @param string $mainFile
	 */
    public function __construct($mainFile) {
        $this->fileManager = new FileManager($mainFile);

        add_action('plugins_loaded', [ $this, 'loadTextDomain' ]);

	}

	/**
	 * Run plugin part
	 */
	public function run() {
		if ( is_admin() ) {
			new Admin( $this->fileManager );
		} else {
			new Frontend( $this->fileManager );
		}
        new Customizer($this->fileManager);

	}

    /**
     * Load plugin translations
     */
    public function loadTextDomain()
    {
        $name = $this->fileManager->getPluginName();
        load_plugin_textdomain('responsive-sidebar', false, $name . '/languages/');
    }

	/**
	 * Fired when the plugin is activated
	 */
	public function activate() {
		// TODO: Implement activate() method.
        $options = get_option( Settings::OPTIONS );
        $options['cssClasses'] = Settings::CSS_CLASSES;
        $options['maxWidth'] = Settings::MAX_WIDTH;
        $options['sidebarSwipe'] = Settings::SIDEBAR_SWIPE;
        $options['sidebars'] = array();
        update_option(Settings::OPTIONS, $options);
	}

	/**
	 * Fired when the plugin is deactivated
	 */
	public function deactivate() {
		// TODO: Implement deactivate() method.
	}

	/**
	 * Fired during plugin uninstall
	 */
	public static function uninstall() {
		// TODO: Implement uninstall() method.
        delete_option(Settings::OPTIONS);
	}
}