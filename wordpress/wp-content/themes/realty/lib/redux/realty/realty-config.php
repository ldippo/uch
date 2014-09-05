<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS


            /* General
						============================== */
            $this->sections[] = array(
	            'title'     => __('General', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-cog',
	            'fields'    => array(
	            	array(
                  'id'        							=> 'color-body-background',
                  'type'      							=> 'background',
                  'output'    							=> array('body'),
                  'title'     							=> __('Body Background Color', 'redux-framework-demo'),
                  'subtitle'  							=> __('Site Background Color (default: #f8f8f8)', 'redux-framework-demo'),
                  'default'   							=> array( 'background-color' => '#f8f8f8' ),
                  'background-repeat'  			=> false,
                  'background-attachment'  	=> false,
                  'background-position'			=> false,
                  'background-image'  			=> false,
                  'transparent'			  			=> false,
                  'background-size'	  			=> false,
                ),
                array(
	                'id'       								=> 'color-accent',
							    'type'     								=> 'color',
							    'title'    								=> __('Accent Color', 'redux-framework-demo'), 
							    'subtitle' 								=> __('Site Background Color (default: #70b9a0)', 'redux-framework-demo'),
							    'default'  								=> '#70b9a0',
							    'validate' 								=> 'color',
							    'transparent'		  				=> false,
								),
	            	array(
                  'id'        => 'favicon',
                  'type'      => 'media',
                  'title'     => __('Favicon', 'redux-framework-demo'),
                  'compiler'  => 'true',
                  'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                  'desc'      => __('Upload Square Graphic (Recommendation: 64x64 PNG file)', 'redux-framework-demo' ),
                  'subtitle'  => __('', 'redux-framework-demo'),
	              ),
	              array(
                  'id'        => 'logo-menu',
                  'type'      => 'media',
                  'title'     => __('Logo', 'redux-framework-demo'),
                  'compiler'  => 'true',
                  'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                  'desc'      => __('Image will be displayed at 50% width & height for Retina-Ready purpose. For example: 300x60 image shows at 150x30. Upload your logo accordingly.', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
	              ),
	              array(
                  'id'        => 'logo-login',
                  'type'      => 'media',
                  'title'     => __('WordPress Login Page Logo', 'redux-framework-demo'),
                  'compiler'  => 'true',
                  'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                  'desc'      => __('Max. dimension: 320x80', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
	              ),
	              array(
                  'id'        => '404-page',
                  'type'      => 'select',
                  'data'      => 'pages',
                  'title'     => __('Custom 404 Error Page', 'redux-framework-demo'),
                  'subtitle'  => __('Content of selected page will be shown to visitors who request a non-existing, so called "404 Error Page".', 'redux-framework-demo'),
                  'desc'      => __('If nothing selected, default 404 Content will be displayed.', 'redux-framework-demo'),
                ),
                array(
                  'id'        => 'custom-styles',
                  'type'      => 'ace_editor',
                  'mode' 			=> 	'javascript',
									'theme' 		=> 	'chrome',
                  'title'     => __('Custom Styles (CSS)', 'redux-framework-demo'),
                  'subtitle'  => __('Inline CSS right before closing <strong>&lt;/head&gt;</strong>', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => '',
                ),
                array(
                  'id'        => 'custom-scripts',
                  'type'      => 'ace_editor',
                  'mode' 			=> 	'javascript',
									'theme' 		=> 	'chrome',
                  'title'     => __('Custom Scripts (Google Analytics etc.)', 'redux-framework-demo'),
                  'subtitle'  => __('Inline scripts right before closing <strong>&lt;/body&gt;</strong>', 'redux-framework-demo'),
                  'desc'      => __('Use "jQuery" selector, instead of "$" shorthand.', 'redux-framework-demo'),
                  'default'   => '',
                ),
              )
            );
            
            
            /* HEADER
						============================== */
            $this->sections[] = array(
	            'title'     => __('Header', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-bars',
	            'fields'    => array(
	            	array(
                  'id'        							=> 'color-header-background',
                  'type'      							=> 'background',
                  'output'    							=> array('header.navbar, header.navbar .navbar-nav > ul > li ul.sub-menu, header.navbar nav > div > ul > li ul.sub-menu'),
                  'title'     							=> __('Site Header Background Color', 'redux-framework-demo'),
                  'subtitle'  							=> __('Site Background Color (default: #333333)', 'redux-framework-demo'),
                  'default'   							=> array( 'background-color' => '#333333' ),
                  'background-repeat'  			=> false,
                  'background-attachment'  	=> false,
                  'background-position'			=> false,
                  'background-image'  			=> false,
                  'transparent'			  			=> false,
                  'background-size'	  			=> false,
                ),
                array(
	                'id'       								=> 'color-header',
							    'type'     								=> 'color',
							    'title'    								=> __('Site Header Color', 'redux-framework-demo'), 
							    'subtitle' 								=> __('Site Header Color (default: #ffffff)', 'redux-framework-demo'),
							    'default'  								=> '#ffffff',
							    'validate' 								=> 'color',
							    'transparent'		  				=> false,
								),
								array(
                  'id'        => 'site-header-phone',
                  'type'      => 'text',
                  'title'     => __('Phone Number', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'numeric',
                  'default'   => '+1 555 22 66 8890',
                ),
                array(
                  'id'        => 'site-header-email',
                  'type'      => 'text',
                  'title'     => __('Email Address', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'numeric',
                  'default'   => 'info@yourcompany.com',
                ),
              )
            );
            
            
            /* Map
						============================== */
            $this->sections[] = array(
	            'title'     => __('Map', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-map-marker',
	            'fields'    => array(
	            	array(
	                'id'        => 'map-marker-property-default',
	                'type'      => 'image_select',
	                'title'     => __('Default Map Marker: Property', 'redux-framework-demo'),
	                'subtitle'  => __('Default: Green (Dimension: 100x138)', 'redux-framework-demo'),
	                'desc'      => __('', 'redux-framework-demo'),
	                
	                //Must provide key => value(array:title|img) pairs for radio options
	                'options'   => array(
	                  get_template_directory_uri().'/lib/images/map-marker/map-marker-red-fat.png' 	=> array('title' => 'Map Marker: Red', 'img' => get_template_directory_uri().'/lib/images/map-marker/map-marker-red-fat.png'),
	                  get_template_directory_uri().'/lib/images/map-marker/map-marker-blue-fat.png' 	=> array('title' => 'Map Marker: Blue', 'img' => get_template_directory_uri().'/lib/images/map-marker/map-marker-blue-fat.png'),
	                  get_template_directory_uri().'/lib/images/map-marker/map-marker-green-fat.png' 	=> array('title' => 'Map Marker: Green', 'img' => get_template_directory_uri().'/lib/images/map-marker/map-marker-green-fat.png'),
	                ), 
	                'default'   => get_template_directory_uri().'/lib/images/map-marker/map-marker-green-fat.png'
                ),
	            	array(
                  'id'        => 'map-marker-property',
                  'type'      => 'media',
                  'title'     => __('Custom Map Marker: Property', 'redux-framework-demo'),
                  'compiler'  => 'true',
                  'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                  'desc'      => __('', 'redux-framework-demo' ),
                  'subtitle'  => __('Transparent PNG file (Recommended Dimension: 100x138)', 'redux-framework-demo'),
	              ),
	              array(
	                'id'        => 'map-marker-cluster-default',
	                'type'      => 'image_select',
	                'title'     => __('Default Map Marker: Cluster', 'redux-framework-demo'),
	                'subtitle'  => __('Default: Red (Dimension: 100x100)', 'redux-framework-demo'),
	                'desc'      => __('', 'redux-framework-demo'),
	                
	                //Must provide key => value(array:title|img) pairs for radio options
	                'options'   => array(
	                  get_template_directory_uri().'/lib/images/map-marker/map-marker-red-round.png' 	=> array('title' => 'Map Marker: Red', 'img' => get_template_directory_uri().'/lib/images/map-marker/map-marker-red-round.png'),
	                  get_template_directory_uri().'/lib/images/map-marker/map-marker-blue-round.png' 	=> array('title' => 'Map Marker: Blue', 'img' => get_template_directory_uri().'/lib/images/map-marker/map-marker-blue-round.png'),
	                  get_template_directory_uri().'/lib/images/map-marker/map-marker-green-round.png' 	=> array('title' => 'Map Marker: Green', 'img' => get_template_directory_uri().'/lib/images/map-marker/map-marker-green-round.png'),
	                ), 
	                'default'   => get_template_directory_uri().'/lib/images/map-marker/map-marker-red-round.png'
                ),
	              array(
                  'id'        => 'map-marker-cluster',
                  'type'      => 'media',
                  'title'     => __('Custom Map Marker: Cluster', 'redux-framework-demo'),
                  'compiler'  => 'true',
                  'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                  'desc'      => __('For a non-square graphic, you have to add some Custom CSS to position the cluster number: #map .cluster > div { line-height: 1 !important; padding-top: ??px !important; }', 'redux-framework-demo' ),
                  'subtitle'  => __('Transparent Square PNG file (Recommended Dimension: 100x100)', 'redux-framework-demo'),
	              ),
								array(
	                'id'            => 'map-properties-quantity',
	                'type'          => 'spinner',
	                'title'         => __('Number of Properties on Map', 'redux-framework-demo'),
	                'subtitle'      => __('', 'redux-framework-demo'),
	                'desc'          => __('Select "-1" to display all properties on the map.', 'redux-framework-demo'),
	                'default'       => -1,
	                'min'           => -1,
	                'step'          => 1,
	                'max'           => 100,
	                'display_value' => 'label'
								),
								array(
                  'id'        => 'disable-google-maps-api',
                  'type'      => 'checkbox',
                  'title'     => __('Don\'t load Google Maps API', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('Check this box, if maps are not displaying, as another plugin might already load the API, and a duplicate API produces an error, not showing the map at all.', 'redux-framework-demo'),
                  'default'   => 0
                ),
							)
						);
                    
            
            /* Home Slideshow
						============================== */
            $this->sections[] = array(
	            'title'     => __('Home Slideshow', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-image',
	            'fields'    => array(
								array(
	                'id'        		=> 'home-slideshow-type',
	                'type'      		=> 'radio',
	                'title'     		=> __('Home Slideshow Type', 'redux-framework-demo'),
	                'subtitle'  		=> __('', 'redux-framework-demo'),
	                'desc'      		=> __('', 'redux-framework-demo'),	                
	                'options'   		=> array(
	                    'slideshow-properties' 	=> __('Property Slideshow', 'redux-framework-demo'),
	                    'slideshow-custom' 			=> __('Custom Content Slideshow', 'redux-framework-demo'),
	                ),
	                'default'   		=> 'slideshow-properties'
                ),
                array(
	                'id'        		=> 'home-slideshow-properties-mode',
	                'type'      		=> 'radio',
	                'title'     		=> __('Property Slideshow Type', 'redux-framework-demo'),
	                'subtitle'  		=> __('', 'redux-framework-demo'),
	                'desc'      		=> __('', 'redux-framework-demo'),	                
	                'options'   		=> array(
		                	'slideshow-properties-show-featured' 		=> __('Show Featured Properties', 'redux-framework-demo'),
	                    'slideshow-properties-show-latest' 		=> __('Show Latest 3 Properties', 'redux-framework-demo'),
	                    'slideshow-properties-show-selected'	=> __('Show Selected Properties', 'redux-framework-demo'),
	                ),
	                'default'   		=> 'slideshow-properties-show-latest',
	                'required' 	=> 	array('home-slideshow-type','=','slideshow-properties'),
                ),
								array(
                  'id'        => 'home-property-slides',
                  'type'      => 'select',
                  'data'      => 'posts',
                  'args' 			=> array('post_type' => 'property', 'posts_per_page' => -1),
                  'multi'			=> true,
                  'sortable'	=> true,
                  'title'     => __('Property Slides', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('Select Slideshow Properties. Order Via Drag & Drop.', 'redux-framework-demo'),
                  'required' 	=> 	array('home-slideshow-properties-mode','=','slideshow-properties-show-selected'),
                ),
								array(
                  'id'        => 'home-slides',
                  'type'      => 'slides',
                  'title'     => __('Custom Content Slides', 'redux-framework-demo'),
                  'subtitle'  => __('Create Your Custom Home Slideshow.', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'placeholder'   => array(
                      'title'         => __('This is a title', 'redux-framework-demo'),
                      'description'   => __('Description Here', 'redux-framework-demo'),
                      'url'           => __('Give us a link!', 'redux-framework-demo'),
                  ),
                  'required' 	=> 	array('home-slideshow-type','=','slideshow-custom'),	
                ),
              )
            );
            
            
            /* Property
						============================== */
            $this->sections[] = array(
	            'title'     => __('Property', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-home',
	            'fields'    => array(
	            	array(
                  'id'        => 'property-listing-columns',
                  'type'      => 'radio',
                  'title'     => __('Property Listing: Number Of Columns', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),                  
							    'options'  	=> array(
						        'col-md-6' => '2 Columns',
						        'col-lg-4 col-md-6' => '3 Columns',
						        'col-lg-3 col-md-6' => '4 Columns'
							    ),
							    'default'  => 'col-lg-4 col-md-6',
                ),
                array(
	                'id'            => 'search-results-per-page',
	                'type'          => 'spinner',
	                'title'         => __('Property Listing: Number of Properties Per Page', 'redux-framework-demo'),
	                'subtitle'      => __('', 'redux-framework-demo'),
	                'desc'          => __('Used For Property Search, Taxonomies etc.', 'redux-framework-demo'),
	                'default'       => 10,
	                'min'           => 2,
	                'step'          => 1,
	                'max'           => 50,
	                'display_value' => 'label'
								),
								array(
	                'id'        		=> 'property-layout',
	                'type'      		=> 'radio',
	                'title'     		=> __('Default Single Property Layout', 'redux-framework-demo'),
	                'subtitle'  		=> __('', 'redux-framework-demo'),
	                'desc'      		=> __('', 'redux-framework-demo'),	                
	                'options'   		=> array(
	                    'layout-full-width' 	=> 'Full Width Property Image / Slideshow', 
	                    'layout-boxed' 				=> 'Boxed Property Image / Slideshow', 
	                ),
	                'default'   		=> 'layout-full-width'
                ),
	            	array(
                  'id'        => 'property-title-details',
                  'type'      => 'text',
                  'title'     => __('Property Title: Details', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => '',
                ),
                array(
                  'id'        => 'property-title-features',
                  'type'      => 'text',
                  'title'     => __('Property Title: Features', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => 'Features',
                ),
                array(
                  'id'        => 'property-title-map',
                  'type'      => 'text',
                  'title'     => __('Property Title: Map', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => 'Location',
                ),
                array(
                  'id'        => 'property-title-agent',
                  'type'      => 'text',
                  'title'     => __('Property Title: Agent', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => 'Agent',
                ),
								array(
                  'id'        => 'property-social-sharing',
                  'type'      => 'checkbox',
                  'title'     => __('Display Social Sharing Buttons', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => 1
                ),
                array(
                  'id'        => 'property-agent-information',
                  'type'      => 'checkbox',
                  'title'     => __('Display Agent Information', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => 1
                ),
                array(
                  'id'        => 'property-contact-form',
                  'type'      => 'checkbox',
                  'title'     => __('Display Contact Form', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('Property contact form message will be send to agent, that is assign to the proeprty the message is sent from.', 'redux-framework-demo'),
                  'default'   => 1
                ),
                array(
                  'id'        => 'property-contact-form-default-email',
                  'type'      => 'text',
                  'title'     => __('Default Contact Email Adress', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('Will be used, if no agent with email address is assign to a property, and on the agent profile page, if agent has no email address.', 'redux-framework-demo'),
                  'validate' 	=> 'email',
                  'default'   => '',          
                ),
                array(
	                'id'            => 'property-new-badge',
	                'type'          => 'spinner',
	                'title'         => __('"New" Property Badge', 'redux-framework-demo'),
	                'subtitle'      => __('', 'redux-framework-demo'),
	                'desc'          => __('Add <i class="fa fa-fire"></i> Badge To Property, If It Has Been Published Within The Last .. Days. Set To "0" To Disable This Feature.', 'redux-framework-demo'),
	                'default'       => 7,
	                'min'           => 0,
	                'step'          => 1,
	                'max'           => 360,
	                'display_value' => 'label'
								),
              )
            );
            
            
            /* Property Search
						============================== */
            $this->sections[] = array(
	            'title'     => __('Property Search', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'el-icon-search',
	            'fields'    => array(
								array(
                  'id'        => 'property-search-form-fields',
                  'type'      => 'sorter',
                  'title'     => 'Property Search Form Fields',
                  'subtitle'  => 'Drag & Drop the fields you want to display in your property search form into column <strong>"enabled"</strong>.',
                  'compiler'  => 'true',
                  'options'   => array(
                    'enabled'   => array(
                      'id'    					=> 'Property ID',
                      'location'        => 'Location',
                      'type'    				=> 'Type',
                      'status'      		=> 'Status',
                      'maxprice'     		=> 'Max. Price',
                      'minrooms'      	=> 'Min. Rooms',
                      'availablefrom'		=> 'Available From'
                    ),
                    'disabled'  => array(
                    ),
                  ),
                ),
                array(
                  'id'        => 'datepicker-language',
                  'type'      => 'select',
                  'data'      => 'pages',
                  'title'     => __('Datepicker Language', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('Select the language of the property search datepicker.', 'redux-framework-demo'),                  
							    'options'  	=> array(
						        'en' => 'English (Default)',
						        'de' => 'German',
						        'es' => 'Spanish',
						        'fr' => 'French'
							    ),
							    'default'  => 'en',
                ),
              )
            );
            
            
             /* TYPOGRAPHY
						============================== */
            $this->sections[] = array(
	            'title'     => __('Typography', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-paragraph',
	            'fields'    => array(
		            array(
	                'id'            => 'typography-header',
	                'type'          => 'typography',
	                'title'         => __('Typography Header', 'redux-framework-demo'),
	                'google'        => true,
	                'font-backup'   => false,
	                'font-style'    => false,
	                'font-weight'   => false,
	                'text-align'		=> false,
	                //'subsets'       => false, // Only appears if google is true and subsets not set to false
	                'font-size'     => false,
	                'line-height'   => false,
	                //'word-spacing'  => true,  // Defaults to false
	                //'letter-spacing'=> true,  // Defaults to false
	                'color'         => false,
	                //'preview'       => false, // Disable the previewer
	                'all_styles'    => false,    // Enable all Google Font style/weight variations to be added to the page
	                'output'        => array('header.navbar'), // An array of CSS selectors to apply this font style to dynamically
	                'units'         => 'em', // Defaults to px
	                'subtitle'      => __('', 'redux-framework-demo'),
	                'default'       => array(
	                    'font-family'   => 'Lato',
	                    'google'        => true,
	                    ),
                ),
                array(
	                'id'            => 'typography-headings',
	                'type'          => 'typography',
	                'title'         => __('Typography Headings', 'redux-framework-demo'),
	                'google'        => true,
	                'font-backup'   => false,
	                'font-style'    => false,
	                'font-weight'   => true,
	                'text-align'		=> false,
	                //'subsets'       => false, // Only appears if google is true and subsets not set to false
	                'font-size'     => false,
	                'line-height'   => false,
	                //'word-spacing'  => true,  // Defaults to false
	                //'letter-spacing'=> true,  // Defaults to false
	                'color'         => true,
	                //'preview'       => false, // Disable the previewer
	                'all_styles'    => false,    // Enable all Google Font style/weight variations to be added to the page
	                'output'        => array('h1, h2, h3, h4, h5, h6'), // An array of CSS selectors to apply this font style to dynamically
	                'units'         => 'em', // Defaults to px
	                'subtitle'      => __('', 'redux-framework-demo'),
	                'default'       => array(
	                    'font-family'   => 'Lato',
	                    'font-style'    => '400',
	                    'google'        => true,
	                    'color' 				=> '#666'
	                    ),
                ),
                array(
	                'id'            => 'typography-body',
	                'type'          => 'typography',
	                'title'         => __('Typography Body', 'redux-framework-demo'),
	                'google'        => true,
	                'font-backup'   => false,
	                'font-style'    => false,
	                'font-weight'   => true,
	                'text-align'		=> false,
	                //'subsets'       => false, // Only appears if google is true and subsets not set to false
	                'font-size'     => false,
	                'line-height'   => false,
	                //'word-spacing'  => true,  // Defaults to false
	                //'letter-spacing'=> true,  // Defaults to false
	                'color'         => true,
	                //'preview'       => false, // Disable the previewer
	                'all_styles'    => false,    // Enable all Google Font style/weight variations to be added to the page
	                'output'        => array('body'), // An array of CSS selectors to apply this font style to dynamically
	                'units'         => 'em', // Defaults to px
	                'subtitle'      => __('', 'redux-framework-demo'),
	                'default'       => array(
	                    'font-family'   => 'Open Sans',
	                    'font-style'    => '400',
	                    'google'        => true,
	                    'color' 				=> '#666'
	                    ),
                ),
              )
            );    
            
            
            /* Colors
						==============================
            $this->sections[] = array(
	            'title'     => __('Colors', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-tint',
	            'fields'    => array(
	              
								
              )
            );
            */
            
            /* Format Pricing
						============================== */
            $this->sections[] = array(
	            'title'     => __('Format Pricing', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-money',
	            'fields'    => array(
	              array(
                  'id'        => 'currency-sign',
                  'type'      => 'text',
                  'title'     => __('Currency Sign', 'redux-framework-demo'),
                  'subtitle'  => __('Default: $', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'numeric',
                  'default'   => '$',
                ),
                array(
	                'id'        => 'currency-sign-position',
	                'type'      => 'radio',
	                'title'     => __('Currency Sign Position', 'redux-framework-demo'),
	                'subtitle'  => __('', 'redux-framework-demo'),
	                'desc'      => __('', 'redux-framework-demo'),
	                 //Must provide key => value pairs for radio options
	                'options'   => array(
	                	'left' 			=> 'Left', 
	                  'right' 		=> 'Right', 
	                ),
	                'default'   => 'left'
								),
								array(
                  'id'        => 'price-thousands-separator',
                  'type'      => 'text',
                  'title'     => __('Thousands Separator', 'redux-framework-demo'),
                  'subtitle'  => __('Default: ,', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'numeric',
                  'default'   => ',',
                ),
	            )
	          );
	          
	          
	          
	          /* Footer
						============================== */
            $this->sections[] = array(
	            'title'     => __('Footer', 'redux-framework-demo'),
	            'desc'      => __('', 'redux-framework-demo'),
	            'icon'      => 'fa fa-anchor',
	            'fields'    => array(
	            	array(
                  'id'        							=> 'color-footer-background',
                  'type'      							=> 'background',
                  'output'    							=> array('#footer'),
                  'title'     							=> __('Footer Top Background Color', 'redux-framework-demo'),
                  'subtitle'  							=> __('', 'redux-framework-demo'),
                  'default'   							=> array( 'background-color' => '' ),
                  'background-repeat'  			=> false,
                  'background-attachment'  	=> false,
                  'background-position'			=> false,
                  'background-image'  			=> false,
                  'transparent'			  			=> false,
                  'background-size'	  			=> false,
                ),
                array(
                  'id'        							=> 'color-footer-bottom-background',
                  'type'      							=> 'background',
                  'output'    							=> array('#footer #footer-bottom'),
                  'title'     							=> __('Footer Bottom Background Color', 'redux-framework-demo'),
                  'subtitle'  							=> __('', 'redux-framework-demo'),
                  'default'   							=> array( 'background-color' => '' ),
                  'background-repeat'  			=> false,
                  'background-attachment'  	=> false,
                  'background-position'			=> false,
                  'background-image'  			=> false,
                  'transparent'			  			=> false,
                  'background-size'	  			=> false,
                ),
                array(
	                'id'       								=> 'color-footer',
							    'type'     								=> 'color',
							    'title'    								=> __('Footer Color', 'redux-framework-demo'), 
							    'subtitle' 								=> __('Footer Color (default: #999999)', 'redux-framework-demo'),
							    'default'  								=> '#999999',
							    'output'    							=> array('#footer #footer-bottom, #footer #footer-bottom a, #footer .widget-title'),
							    'validate' 								=> 'color',
							    'transparent'		  				=> false,
								),
	              array(
                  'id'        => 'copyright',
                  'type'      => 'text',
                  'title'     => __('Copyright Text', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'numeric',
                  'default'   => '&copy; 2014 - <a href="http://themetrail.com">ThemeTrail</a>',
                ),
                array(
                  'id'        => 'footer-show-up-button',
                  'type'      => 'checkbox',
                  'title'     => __('Display "To The Top" Button', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => 1
                ),
                array(
                  'id'        => 'footer-property-search-button',
                  'type'      => 'checkbox',
                  'title'     => __('Display "Property Search" Button', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  'default'   => 1
                ),
                array(
                  'id'        => 'social-facebook',
                  'type'      => 'text',
                  'title'     => __('Faceook URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '#',
                ),
                array(
                  'id'        => 'social-twitter',
                  'type'      => 'text',
                  'title'     => __('Twitter URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '#',
                ),
                array(
                  'id'        => 'social-google',
                  'type'      => 'text',
                  'title'     => __('Google+ URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '#',
                ),
                array(
                  'id'        => 'social-linkedin',
                  'type'      => 'text',
                  'title'     => __('LinkedIn URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '',
                ),
                array(
                  'id'        => 'social-pinterest',
                  'type'      => 'text',
                  'title'     => __('Pinterest URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '',
                ),
                array(
                  'id'        => 'social-instagram',
                  'type'      => 'text',
                  'title'     => __('Instagram URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '',
                ),
                array(
                  'id'        => 'social-youtube',
                  'type'      => 'text',
                  'title'     => __('YouTube URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '',
                ),
                array(
                  'id'        => 'social-skype',
                  'type'      => 'text',
                  'title'     => __('Skype URL', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'desc'      => __('', 'redux-framework-demo'),
                  //'validate'  => 'url',
                  'default'   => '',
                ),
                
	            )
	          );
	          
	          
	          
	          /* Contact
						============================== */
            $this->sections[] = array(
							'icon' 		=> 'fa fa-envelope',
							'title' 	=> __('Contact', 'redux-framework-demo'),
							'desc' 	=> __('Contact Details for Contact Page Template.', 'redux-framework-demo'),
							'fields' 	=> array(
								array(
									'id'					=> 	'contact-google-map',
									'type' 				=> 	'switch',
									'title' 			=> 	__('Show Google Maps', 'redux-framework-demo'), 
									'subtitle' 		=> 	__('', 'redux-framework-demo'),
									'desc'				=> 	__('Show Google Map on Contact Page Template.', 'redux-framework-demo'),
									'default' 		=> 	1,
									'on'					=> 	__('Yes', 'redux-framework-demo'), 
									'off'					=> 	__('No', 'redux-framework-demo'), 
								),
								array(
                  'id'        => 'contact-logo',
                  'type'      => 'media',
                  'title'     => __('Logo', 'redux-framework-demo'),
                  'compiler'  => 'true',
                  'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                  'desc'      => __('', 'redux-framework-demo'),
                  'subtitle'  => __('', 'redux-framework-demo'),
                  'required' 		=> 	array('contact-google-map','=','1'),	
	              ),
	              array(
									'id'					=>	'contact-address',
									'type' 				=> 	'text',
									'title' 			=> 	__('Address', 'redux-framework-demo'),
									'subtitle' 		=> 	__('', 'redux-framework-demo'),
									'desc' 				=> 	__('', 'redux-framework-demo'),
									//'validate' 		=> 	'no_special_chars',
									'msg' 				=> 	'',
									'default' 		=> 	'Main St, New York, USA',
									'required' 		=> 	array('contact-google-map','=','1'),	
								),	
								array(
									'id'					=>	'contact-phone',
									'type' 				=> 	'text',
									'title' 			=> 	__('Phone', 'redux-framework-demo'),
									'subtitle' 		=> 	__('', 'redux-framework-demo'),
									'desc' 				=> 	__('', 'redux-framework-demo'),
									//'validate' 		=> 	'no_special_chars',
									'msg' 				=> 	'',
									'default' 		=> 	'+1 555 22 66 8890',
									'required' 		=> 	array('contact-google-map','=','1'),	
								),
								array(
									'id'					=>	'contact-mobile',
									'type' 				=> 	'text',
									'title' 			=> 	__('Mobile', 'redux-framework-demo'),
									'subtitle' 		=> 	__('', 'redux-framework-demo'),
									'desc' 				=> 	__('', 'redux-framework-demo'),
									//'validate' 		=> 	'no_special_chars',
									'msg' 				=> 	'',
									'default' 		=> 	'+1 555 22 66 8891',
									'required' 		=> 	array('contact-google-map','=','1'),	
								),	
								array(
									'id'					=>	'contact-email',
									'type' 				=> 	'text',
									'title' 			=> 	__('Email', 'redux-framework-demo'),
									'subtitle' 		=> 	__('', 'redux-framework-demo'),
									'desc' 				=> 	__('', 'redux-framework-demo'),
									//'validate' 		=> 	'no_special_chars',
									'msg' 				=> 	'',
									'default' 		=> 	'info@yourcompany.com',
									'required' 		=> 	array('contact-google-map','=','1'),	
								),
							)
						);
						

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'realty_theme_option',   // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'submenu',               // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'redux-framework-demo'),
                'page_title'        => __('Theme Options', 'redux-framework-demo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyB66Y-sRZ5P60QYBoGHn3PhplGX2i7o87k', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => false,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'footer_credit'     => '&nbsp;',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            /* SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );
            */

            /* Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');
            */
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
