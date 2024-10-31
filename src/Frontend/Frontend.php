<?php namespace ResponsiveSidebar\Frontend;

use Premmerce\SDK\V2\FileManager\FileManager;
use ResponsiveSidebar\Admin\Settings;

/**
 * Class Frontend
 *
 * @package ResponsiveSidebar\Frontend
 */
class Frontend
{


    /**
     * @var FileManager
     */
    private $fileManager;

    private $options;

    private $settings;


    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
        $this->options = get_option(Settings::OPTIONS);
        $this->registerActions();

    }

    private function GetSettings(){

        return array(
            'sidebarBackground' => get_theme_mod('sidebar_background_color', '#ffffff'),
            'sidebarWidth' => get_theme_mod('sidebar_width', 280),
            'sidebarPosition' => get_theme_mod('sidebar_position', 'left'),
            'sidebarShadows' => get_theme_mod('sidebar_shadows', 1),
            'sidebarBlackout' => get_theme_mod('sidebar_blackout', 1),
            'enableButton' => get_theme_mod('enable_button', 1),
            'buttonBackground' => get_theme_mod('button_background_color', '#ffffff'),
            'borderRadius' => get_theme_mod('border_radius', 100),
            'button_width' => get_theme_mod('button_width', 50),
            'button_height' => get_theme_mod('button_height', 50),
            'buttonPosition' => get_theme_mod('button_position', 'bottom_right'),
            'marginX' => get_theme_mod('margin_x', 20),
            'marginY' => get_theme_mod('margin_y', 20),
            'buttonShadows' => get_theme_mod('button_shadows', 1),
            'button_image' => get_theme_mod('button_image', $this->fileManager->locateAsset('frontend/img/sidebar-icon.png')),
            'button_image_width' => get_theme_mod('button_image_width', 30),
            'button_text' => get_theme_mod('button_text', ''),
            'button_bold_text' => get_theme_mod('button_bold_text', 0),

        );
    }

    private function registerActions()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
        add_action('wp_head', array($this, 'addInlineStyles'));
        add_action('wp_footer', array($this, 'addButtonHtml'));
        add_action('wp_footer', array($this, 'addInlineScript'));
        add_action( 'dynamic_sidebar_before', array($this, 'SidebarWrapBefore'), 10, 2 );
        add_action( 'dynamic_sidebar_after', array($this, 'SidebarWrapAfter'), 10, 2 );

    }

    public function SidebarWrapBefore($index, $has_widgets)
    {

        foreach ($this->options['sidebars'] as  $sidebarId){
            if( is_active_sidebar( $sidebarId ) &&  $index == $sidebarId){
                echo '<div class="resp-sidebar-wrapper">';
            }
        }


    }

    public function SidebarWrapAfter($index, $has_widgets)
    {

        foreach ($this->options['sidebars'] as  $sidebarId){
            if( is_active_sidebar( $sidebarId ) &&  $index == $sidebarId){
                echo '</div>';
            }
        }


    }


    public function enqueueScripts()
    {

    }

    public function addInlineStyles()
    {

        $this->settings = $this->GetSettings();

        $sidebarShadows = '';
        if ($this->settings['sidebarShadows']) {
            $sidebarShadows = "box-shadow: 2px 0 10px 0 #b4b4b4;";
        }
        $buttonShadows = '';
        if ($this->settings['buttonShadows']) {
            $buttonShadows = "box-shadow: 1px 1px 10px 0 #b4b4b4;";
        }
        switch ($this->settings['buttonPosition']){
            case 'bottom_right':
                $buttonMargin = "
                bottom: {$this->settings['marginY']}px;
                right: {$this->settings['marginX']}px;";
                break;
            case 'bottom_left':
                $buttonMargin = "
                bottom: {$this->settings['marginY']}px;
                left: {$this->settings['marginX']}px;";
                break;
            case 'top_right':
                $buttonMargin = "
                top: {$this->settings['marginY']}px;
                right: {$this->settings['marginX']}px;";
                break;
            case 'top_left':
                $buttonMargin = "
                top: {$this->settings['marginY']}px;
                left: {$this->settings['marginX']}px;";
                break;
        }

        $hiddenWidth = -$this->settings['sidebarWidth']-10;

        switch ($this->settings['sidebarPosition']){
            case 'right':

                $sidebar = "
                right: {$hiddenWidth}px;
                transition-property: right;
                ";
                $sidebarPosition = "
                right: 0;
                ";
                break;
            case 'left':

                $sidebar = "
                left: {$hiddenWidth}px;
                transition-property: left;
                ";
                $sidebarPosition = "
                left: 0;
                ";
                break;
        }

        $styles = "<style> @media screen and (max-width: {$this->options['maxWidth']}px){";


        if(!empty($this->options['sidebars'])){
            $styles .= ".resp-sidebar-wrapper{
            display: block;
            position: fixed;
            top: 0;
            bottom: -100px;
            $sidebar
            width: {$this->settings['sidebarWidth']}px;
            overflow: auto;
            z-index: 9999;
            background: {$this->settings['sidebarBackground']};
            $sidebarShadows;
            padding-bottom: 100px;
            transition-duration: 0.5s;
            }";
        } elseif(!empty($this->options['cssClasses'])){
            $styles .=  "#{$this->options['cssClasses']}{
            display: block;
            position: fixed;
            top: 0;
            bottom: -100px;
            $sidebar
            width: {$this->settings['sidebarWidth']}px;
            overflow: auto;
            z-index: 9999;
            background: {$this->settings['sidebarBackground']};
            $sidebarShadows;
            padding-bottom: 100px;
            transition-duration: 0.5s;
            }";
        }


        $styles .= "
        }
        .resp-sidebar-wrapper.opened {
            $sidebarPosition
        }
        body{
         position: relative;
         }
         
        #responsive-sidebar-close {
            display:none;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }
         #responsive-sidebar-close.opened {
            display: block;
            cursor: pointer;
        }
        ";

        if($this->settings['sidebarBlackout']){
            $styles .= "#responsive-sidebar-close.opened {
           background-color: rgba(0,0,0,.49);
            }";
        }

        if(!empty($this->options['cssClasses'])){
            $styles .= "#{$this->options['cssClasses']}.opened {
            $sidebarPosition
            }";
        }


        if ($this->settings['enableButton']) {
            $styles .= "
            #responsive-sidebar-btn {
                display: none;
                position: fixed;
                $buttonMargin
                width: {$this->settings['button_width']}px;
                height: {$this->settings['button_height']}px;
                z-index: 10000;
                text-align: center;
                border-radius: {$this->settings['borderRadius']}%;
                cursor: pointer;
                border: none;
                $buttonShadows;
                background-color: {$this->settings['buttonBackground']};              
            }
            @media screen and (max-width: {$this->options['maxWidth']}px){
                #responsive-sidebar-btn {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }
                .responsive-sidebar-btn-img{
                    width: {$this->settings['button_image_width']}px;
                }
            
            }";
        }
        $styles .= "</style>";

        echo apply_filters('responsive_sidebar_styles', $styles);
    }


    public function addButtonHtml()
    {
        $img = '';
        if($this->settings['button_image'] != ''){
            $img = "<img class='responsive-sidebar-btn-img' src=\"{$this->settings['button_image']}\">";
        }


        $text = '';
        if($this->settings['button_text'] != ''){
            if($this->settings['button_bold_text']){
                $text = "<span class='responsive-sidebar-btn-text'><b>{$this->settings['button_text']}</b></span>";
            }else{
                $text = "<span class='responsive-sidebar-btn-text'>{$this->settings['button_text']}</span>";
            }

        }

        $buttonHtml = "<div id=\"responsive-sidebar-btn\" class=\"responsive-sidebar-btn\" style=\"display: none;\">
         $img $text
        </div>";

        echo apply_filters('responsive_sidebar_button', $buttonHtml);

    }

    public function addInlineScript()
    {
        if(!empty($this->options['sidebars'])){

        }
        $ResponsiveSidebarScript = "<script type='text/javascript'>

        var wrId = document.getElementById('{$this->options['cssClasses']}');  
        var wr = document.getElementsByClassName('resp-sidebar-wrapper');
        ";


        $ResponsiveSidebarScript .= "var btn = document.getElementsByClassName('responsive-sidebar-btn');
        var openedClass = 'opened';
        
        var close = document.createElement('div');
        close.id = 'responsive-sidebar-close';  
        document.body.prepend(close);

        if(wrId != null || wr.length != 0){
        
        for (var i = 0; i < btn.length; i++) {
           btn[i].style.cssText = '';
        }
        
             
        } 
        
        for (var i = 0; i < btn.length; i++) {
            btn[i].addEventListener('click', function() {
              if(!this.classList.contains(openedClass)){
                    openMobileSidebar();
              }else{
                  closeMobileSidebar();
              }            
            });
        }
       
        close.addEventListener('click', function() {
              closeMobileSidebar();              
        });
        
        function openMobileSidebar() {
        
            close.classList.add(openedClass);
        
            if(wrId != null){
                 wrId.classList.add(openedClass);
            }
            if(wr.length != 0){
                  wr[0].classList.add(openedClass);
            }   
            
                  for (var i = 0; i < btn.length; i++) {
                    btn[i].classList.add(openedClass);
                }
                
        }
        
        function closeMobileSidebar() {
        
            close.classList.remove(openedClass);
            
            if(wrId != null){
                 wrId.classList.remove(openedClass);
            }
            if(wr.length != 0){
                  wr[0].classList.remove(openedClass);
            }
            
            for (var i = 0; i < btn.length; i++) {
               btn[i].classList.remove(openedClass);
            }     
        }
        
        function findAncestor (el, cls) {
            while ((el = el.parentElement) && !el.classList.contains(cls));
            return el;
        }      
        ";



        if ($this->options['sidebarSwipe']) {


            switch ($this->settings['sidebarPosition']){
                case 'right':

                    $ResponsiveSidebarScript .= "
            var touchstartX = 0;
            var touchstartY = 0;
            var touchendX = 0;
            var touchendY = 0;
            var deltaY = 60;
            var deltaX = 10;
            var isSwiped;
        
            document.body.addEventListener('touchstart', function(event) {
                isSwiped  = true;
                touchstartX = event.changedTouches[0].screenX;
                touchstartY = event.changedTouches[0].screenY;
                
               if(findAncestor (event.target, 'widget_price_filter') != null){
               isSwiped = false;
               };
               
             
            }, false);
        
            document.body.addEventListener('touchend', function(event) {
                touchendX = event.changedTouches[0].screenX;
                touchendY = event.changedTouches[0].screenY;      
                handleGesure();
            }, false); 
        
             
            function handleGesure() {
                    var distanceY = Math.abs(touchendY - touchstartY);
                    var distanceX = Math.abs(touchendX - touchstartX);
          
                    if (touchendX > touchstartX && distanceY <= deltaY && distanceX >= deltaX) {   
                        if(isSwiped){
                             closeMobileSidebar();
                        } 
                    }
                    if (touchendX < touchstartX && distanceY <= deltaY && distanceX >= deltaX) { 
                      
                         if(isSwiped && touchstartX > screen.width - 40){
                            openMobileSidebar();
                         }
                    }     
                }";

                    break;
                case 'left':

                    $ResponsiveSidebarScript .= "
            var touchstartX = 0;
            var touchstartY = 0;
            var touchendX = 0;
            var touchendY = 0;
            var deltaY = 60;
            var deltaX = 10;
            var isSwiped;
        
            document.body.addEventListener('touchstart', function(event) {
                isSwiped  = true;
                touchstartX = event.changedTouches[0].screenX;
                touchstartY = event.changedTouches[0].screenY;
                
               if(findAncestor (event.target, 'widget_price_filter') != null){
               isSwiped = false;
               };
               
             
            }, false);
        
            document.body.addEventListener('touchend', function(event) {
                touchendX = event.changedTouches[0].screenX;
                touchendY = event.changedTouches[0].screenY;      
                handleGesure();
            }, false); 
        
             
            function handleGesure() {
                    var distanceY = Math.abs(touchendY - touchstartY);
                    var distanceX = Math.abs(touchendX - touchstartX);
          
                    if (touchendX < touchstartX && distanceY <= deltaY && distanceX >= deltaX) {   
                        if(isSwiped){
                             closeMobileSidebar();
                        } 
                    }
                    if (touchendX > touchstartX && distanceY <= deltaY && distanceX >= deltaX) { 
                      
                         if(isSwiped && touchstartX < 40){
                            openMobileSidebar();
                         }
                    }     
                }";

                    break;
            }


        }

        $ResponsiveSidebarScript .= "</script>";

    echo apply_filters('responsive_sidebar_script', $ResponsiveSidebarScript);


    }


}