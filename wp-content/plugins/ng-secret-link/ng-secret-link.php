<?php
    
    /**
     * Plugin Name: NG Secret link
     * Plugin URI: https://nikita.global
     * Description: Limit access to your website with secret link
     * Author: Nikita Menshutin
     * Version: 1.0
     * Text Domain: NGSecretLink
     * Domain Path: languages
     *
     * PHP version 7.2
     *
     * @category NikitaGlobal
     * @package  NikitaGlobal
     * @author   Nikita Menshutin <nikita@nikita.global>
     * @license  https://nikita.global commercial
     * @link     https://nikita.global
     * */
    defined('ABSPATH') or die("No script kiddies please!");
if (! class_exists("NGSecretLink")) {
    /**
         * Our main class goes here
         *
         * @category NikitaGlobal
         * @package  NikitaGlobal
         * @author   Nikita Menshutin <wpplugins@nikita.global>
         * @license  http://opensource.org/licenses/gpl-license.php GNU
         * @link     https://nikita.global
         */
    Class NGSecretLink
    {
            
        /**
             * Construct
             *
             * @return void
             **/
        public function __construct()
        {
            $this->prefix     = self::prefix();
            $this->version    = self::version();
            $this->pluginName = __('NG Secret link');
            $this->options    = get_option($this->prefix);
            load_plugin_textdomain(
                $this->prefix,
                false,
                $this->prefix . '/languages'
            );
                
            $this->settings = array(
                'enabled'   => array(
                    'key'     => 'enabled',
                    'title'   => __('Site is closed'),
                    'group'   => __('Settings'),
                    'type'    => 'checkbox',
                    'default' => false
                ),
                'secretkey' => array(
                    'key'         => 'secretkey',
                    'title'       => __('Secret key'),
                    'placeholder' => __('placeholder'),
                    'group'       => __('Settings'),
                    'type'        => 'text',
                    'required'    => true,
                    'default'     => 'default'
                ),
                'redirect'  => array(
                    'key'     => 'redirect',
                    'title'   => __('If site is closed redirect to'),
                    'group'   => __('Settings'),
                    'type'    => 'select',
                    'default' => false,
                    'args'    => $this->_getPages()
                )
            );
            foreach ($this->settings as $k => $setting) {
                if (isset($this->options[$setting['key']])) {
                    $this->settings[$k]['value'] = $this->options[$setting['key']];
                }
            }
            add_action('admin_enqueue_scripts', array($this, 'scripts'));
            add_action('admin_menu', array($this, 'menuItemAdd'));
            add_action('admin_init', array($this, 'settingsRegister'));
            add_action('template_redirect', array($this, 'templateRedirect'));
            add_filter(
                'plugin_action_links',
                array(
                    $this,
                    'pluginActionLinks'
                ), 10, 2
            );
            if (! isset($this->options['enabled'])
                || ($this->options['enabled']) != 1
            ) {
                return;
            }
            $this->_initProtect();
        }
            
        /**
             * Register settings
             *
             * @return void
             **/
        public function settingsRegister()
        {
            register_setting($this->prefix, $this->prefix);
            $groups = array();
            foreach ($this->settings as $settingname => $array) {
                if (! in_array($array['group'], $groups)) {
                    add_settings_section(
                        $this->prefix . $array['group'],
                        __($array['group'], $this->prefix),
                        array($this, 'sectionCallBack'),
                        $this->prefix
                    );
                    $this->groups[] = $array['group'];
                }
                add_settings_field(
                    $array['key'],
                    __($array['title'], $this->prefix),
                    array($this, 'makeField'),
                    $this->prefix,
                    $this->prefix . $array['group'],
                    $array
                );
            }
        }
            
        /**
             * Options page in settings
             *
             * @return void
             **/
        public function menuItemAdd()
        {
            add_options_page(
                $this->pluginName,
                $this->pluginName,
                'manage_options',
                $this->prefix,
                array($this, 'optionsPage')
            );
        }
            
        /**
             * Backend options options page
             *
             * @return void
             **/
        public function optionsPage()
        {
            ?>
            <form action='options.php' method='post'>
            <h2><?php echo $this->pluginName; ?></h2>
                <?php
                settings_fields($this->prefix);
                do_settings_sections($this->prefix);
                submit_button();
                ?></form><?php
            $this->_optionsPageSecretLink();
        }
            
        /**
         * Generate secret link
         *
         * @return void
         */
        private function _optionsPageSecretLink()
        {
            if (isset($this->options['secretkey'])) {
                $url=add_query_arg(
                    array($this->prefix => $this->options['secretkey']),
                    home_url()
                );
                echo '<label><h2>' . __('Secret link', $this->prefix) . '</h2>';
                echo '<input ';
                echo 'data-val="'.$url.'" ';
                echo 'id="'.$this->prefix.'copy" value="';
                echo $url;
                echo '" class="regular-text">';
                echo '<button onclick="ngcopytext()">'
                     .__('Copy link', $this->prefix).'</button>';
                echo '</label>';
                echo '<span id="nghidden" style="display:none;"><br>'
                     .__('Copied', $this->prefix);
                echo '</span>';
            }
        }
            
        /**
             * Settings field - default
             *
             * @param array $args arguments
             *
             * @return void
             **/
        public function makeField($args)
        {
            $methodName = 'makeField' . $args['type'];
            if (method_exists($this, $methodName)) {
                return $this->{$methodName}($args);
            }
            echo '<input ';
            echo ' class="regular-text"';
            echo ' type="';
            echo $args['type'];
            echo '"';
            echo $this->_makeFieldAttr($args);
            echo ' value="';
            if (isset($args['value'])) {
                echo $args['value'];
            } else {
                if (isset($args['default'])) {
                    echo $args['default'];
                }
            }
            echo '"';
            echo '>';
        }
            
        /**
             * Settings field - checkbox
             *
             * @param array $args arguments
             *
             * @return void
             **/
        public function makeFieldCheckBox($args)
        {
            echo '<input type="checkbox" value="1"';
            echo $this->_makeFieldAttr($args);
            if (isset($this->options[$args['key']])
                && $this->options[$args['key']]
            ) {
                echo 'checked';
            }
                
            echo '>';
        }
            
        /**
             * Settings field select
             *
             * @param array $args settings arguments
             *
             * @return void
             */
        public function makeFieldSelect($args)
        {
            echo '<select ';
            echo $this->_makeFieldAttr($args);
            echo '>';
            echo $this->_makeFieldSelectOptions($args);
            echo '</select>';
        }
            
        /**
             * Settings field select - options tags
             *
             * @param array $args settings arguments
             *
             * @return void
             */
        private function _makeFieldSelectOptions($args)
        {
            foreach ($args['args'] as $k => $v) {
                echo '<option ';
                echo 'value="' . $k . '" ';
                if (isset($args['value']) && ($args['value'] == $k)) {
                    echo 'selected ';
                }
                echo ">";
                _e($v, $this->prefix);
                echo '</option>';
                    
            }
        }
            
        /**
             * Name and Required attribute for field
             *
             * @param array $args arguments
             *
             * @return void
             **/
        private function _makeFieldAttr($args)
        {
            echo " name=\"";
            echo $this->prefix . '[';
            echo $args['key'] . ']" ';
            if (isset($args['placeholder'])) {
                echo ' placeholder="';
                echo __($args['placeholder'], $this->prefix) . '"';
            }
            if (isset($args['required']) && $args['required']) {
                echo ' required="required"';
            }
        }
            
        /**
             * Enqueue scripts
             *
             * @return void
             **/
        public function scripts()
        {
            if (!isset($_GET['page']) || $_GET['page']!='NGSecretLink') {
                return;
            }
            wp_register_script(
                $this->prefix,
                plugin_dir_url(__FILE__) . '/plugin.js',
                array('jquery'),
                $this->version,
                true
            );
            wp_enqueue_script($this->prefix);
        }
            
        /**
             * Output under sectionCallBack
             *
             * @return void
             **/
        public function sectionCallBack()
        {
            echo '<hr>';
        }
            
        /**
             * Link to settings page from plugins list page
             *
             * @param array  $links links
             * @param string $file  plugin file
             *
             * @return array links
             */
        public function pluginActionLinks($links, $file)
        {
            if ($file == plugin_basename(__FILE__)) {
                $settings_link = '<a href="' . admin_url(
                    'options-general.php?page=' . $this->prefix
                ) . '">' . __('Settings') . '</a>';
                array_unshift($links, $settings_link);
            }
                
            return $links;
        }
    
        /**
         * Get pages, make array for options
         * recurseivly
         *
         * @param int    $parent page parent
         * @param string $offset prefix for children
         *
         * @return array
         */
        private function _getPages($parent = 0, $offset = '')
        {
            $out   = array();
            if ($parent==0) {
                $out=array(
                        0=>__('Blank page', $this->prefix)
                );
            }
            $pages = get_pages(
                array(
                    'parent' => $parent
                )
            );
            if (! $pages || empty($pages)) {
                return array();
            }
                
            foreach ($pages as $page) {
                $out[$page->ID] = $offset . get_the_title($page);
                $out            = array_merge(
                    $out,
                    $this->_getPages($page->ID, '&nbsp;&nbsp;&nbsp;')
                );
            }
            //  $out=array_merge(array(0=>__('Blank page', $this->prefix)), $pages);
            return $out;
        }
            
            
        /**
             * Method returns prefix
             *
             * @return string prefix
             **/
        public static function prefix()
        {
            return 'NGSecretLink';
        }
            
        /**
             * Method returns plugin version
             *
             * @return string version
             **/
        public static function version()
        {
            return '1.0';
        }
    
        /**
         * Save cookie, check cookie
         *
         * @return void
         */
        private function _initProtect()
        {
            $this->_cookieChecked = false;
            $checkGetQuery=isset($_GET[$this->prefix])
                           && $_GET[$this->prefix] == $this->options['secretkey'];
                
            if ($checkGetQuery) {
                setcookie(
                    $this->prefix,
                    (string)sanitize_text_field($_GET[$this->prefix]),
                    time()
                    + 31556926
                );
                $this->_cookieChecked=true;
                $this->redirectHome=true;
                return;
            }
            if (isset($_COOKIE[$this->prefix])
                && $_COOKIE[$this->prefix] == $this->options['secretkey']
            ) {
                $this->_cookieChecked = true;
            }
        }
    
        /**
         * Template redirect
         * if not authorized
         *
         * @return void
         */
        public function templateRedirect()
        {
            if (isset($this->redirectHome)) {
                wp_redirect(home_url());
            }
            if (! isset($this->options['enabled'])) {
                return;
            }
            if ((int)$this->options['enabled'] != 1) {
                return;
            }
            if ($this->_cookieChecked) {
                return;
            }
            if ($this->options['redirect']==0) {
                wp_die(__('Access denied'), $this->prefix);
            }
            global $wp_query;
            if ($wp_query->post->ID == $this->options['redirect']) {
                return;
            }
            wp_redirect(get_the_permalink($this->options['redirect']));
            exit();
        }
    }
}
    new NGSecretLink();
