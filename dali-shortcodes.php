<?php
/*
*Plugin Name: Dali Shortcodes
* Plugin URI: https://github.com/sherifalisa3d/dali-shortcodes
* Description: The plugin adds a shortcodes Helper for dali Site elements.
* Version: 1.0.2
* Author: Sherif Ali
* Author URI: https://github.com/sherifalisa3d/
* License: MIT
*
* GitHub Plugin URI: sherifalisa3d/dali-shortcodes
* GitHub Plugin URI: https://github.com/sherifalisa3d/dali-shortcodes
*/

/* ============================================================= */

/*========================================================================
 Include necessary functions and files
========================================================================*/

require_once( dirname( __FILE__ ) . '/includes/defaults.php' );
require_once( dirname( __FILE__ ) . '/includes/actions-filters.php' );
require_once( dirname( __FILE__ ) . '/includes/template-acf.php' );

/*========================================================================*/

	// Begin Shortcodes
	class DaliShortcodes {

        /*========================================================================
          Initialize shortcodes
         ======================================================================== */
    
        function __construct(){
            //Initialize shortcodes
            add_action( 'init', array( $this, 'add_shortcodes' ) );
            add_action( 'wp_enqueue_scripts',  array( $this, 'dali_shortcode_enque_scripts' ) );
            
        }

        /*--------------------------------------------------------------------------------------
		*
		* Add necessary js and css files for the plugin
		*
		* @author sherif ali
		* @since 1.0
		*
		*-------------------------------------------------------------------------------------*/ 
        public function dali_shortcode_enque_scripts() {
         wp_enqueue_script( 'dlai-shortcode-js', plugin_dir_url( __file__ ) . '/assets/js/dali-shorcode.js', array( 'jquery' ), '1.0.0', true);
         wp_enqueue_style( 'dlai-shortcode-css', plugin_dir_url( __file__ )  . '/assets/css/dlai-shortcode.css');
        }
        
        /*--------------------------------------------------------------------------------------
		*
		* add_shortcodes
		*
		* @author sherif ali
		* @since 1.0
		*
		*-------------------------------------------------------------------------------------*/  
        function add_shortcodes(){

            $shortcodes = array(
                'dali-orders',
                'dali-total-sales',
                'dali-wu-template',
                'dali-site-url',
                'dali-product-count'
            );

            foreach ( $shortcodes as $shortcode ) {

                $function = str_replace( '-', '_', $shortcode );
                add_shortcode( $shortcode, array( $this, $function ) );

            }
        }
        /*--------------------------------------------------------------------------------------
		*
		* dali_orders
		*
		* @author Sherif Ali
		* @since 1.0.0
		*
        * [dali-orders]
        * [dali-orders xclass="extra-class" data="data1,data1value|data2,data2value"]
		*-------------------------------------------------------------------------------------*/
        function dali_orders( $atts, $content = null ) {

            $atts = shortcode_atts( array(
                    "class"  => true,
                    "xclass" => false,
                    "data"   => false
            ), $atts );

            extract( $atts );

            $class  = ( $atts['class']   == 'true' )  ? 'dali-orders-number' : '';
            $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

            $data_props = $this->parse_data_attributes( $atts['data'] );
            // Get orders processing and on-hold.
            $args = array(
                'status' => array('wc-processing', 'wc-on-hold', 'wc-completed', 'wc-pending'),
                'numberposts' => -1,
            );
            $orders = wc_get_orders( $args );

            if( !empty( $orders ) && count( $orders ) > 0 ) {
                $orders_found = count( $orders ) ;
            } else {
                $orders_found = 0;
            }
            
            ob_start();

            $output = sprintf(
                '<span class="%s"%s>%s</span>',
                esc_attr( trim($class) ),
                ( $data_props ) ? ' ' . $data_props : '',
                esc_attr( $orders_found )
            );
            $output .= ob_get_clean();

            return $output;
        }

        /*--------------------------------------------------------------------------------------
		*
		* dali_total_sales
		*
		* @author Sherif Ali
		* @since 1.0.0
		*
        * [dali-total-sales]
        * [dali-total-sales xclass="extra-class" data="data1,data1value|data2,data2value"]
		*-------------------------------------------------------------------------------------*/
        function dali_total_sales( $atts, $content = null ) {

            $atts = shortcode_atts( array(
                "class"  => true,
                "xclass" => false,
                "data"   => false
            ), $atts );

            extract( $atts );

            $class  = ( $atts['class']   == 'true' )  ? 'dali-total-sales' : '';
            $class .= ( $atts['xclass'] )   ? ' ' . $atts['xclass'] : '';

            $data_props = $this->parse_data_attributes( $atts['data'] );

            // wc_productget_total_sales
            $dali_total_sales = $this->dali_get_total_sales_db();

            if( !empty( $dali_total_sales ) && $dali_total_sales  > 0 ) {
                $total_sales = $dali_total_sales;
            } else {
                $total_sales = 0;
            }
            
            ob_start();

            $output = sprintf(
                '<span class="%s"%s>%s</span>',
                esc_attr( trim($class) ),
                ( $data_props ) ? ' ' . $data_props : '',
                esc_attr( $total_sales )
            );
            $output .= ob_get_clean();

            return $output;
        }

        /*--------------------------------------------------------------------------------------
		*
		* dali_wu_template
		*
		* @author Sherif Ali
		* @since 1.0.0
		*
        * [dali-wu-template]
		*-------------------------------------------------------------------------------------*/
        function dali_wu_template( $atts, $content = null ) {

            $atts = shortcode_atts( array(
                "class"  => true,
                "page_id" => array(),
            ), $atts );

            extract( $atts );

            $class  = ( $atts['class']   == 'true' )  ? 'dali-total-sales' : '';

            // this is dali custom code get pages from site template to select from 
            /**====================================================================================== */
                //Querying all pages in the argument
                $args = array( 'post_type' => 'page', 'post_per_page' => -1 );
                if(!empty($atts['page_id'])){
                    $args['post__in'] = [$atts['page_id']];
                }
            ob_start();
            $base_site_id = 36;
            switch_to_blog( $base_site_id );     
            $site_template_pages = get_pages( $args ); ?>
                <div class="wu-site-pages" style="padding: 30px 0;">
                    <p id="wrapper-field-site_title" style="clear: both;">
                        <label for="field-site_title" class="wu-block"><?php echo __('اختيار القوالب', 'dali'); ?><span
                                class="wu-checkout-required-field wu-text-red-500">*</span>
                        </label>
                    </p>
                    <div id="wu-site-template-container-grid"
                        class="wu-grid wu-grid-cols-1 sm:wu-grid-cols-2 md:wu-grid-cols-3 wu-gap-4">
                        <?php foreach( $site_template_pages as $pages ) {
                            if( get_field('make_page_template', $pages->ID) === true){
                                include( dirname( __FILE__ ) . '/includes/wu-pages.php' );
                            }
                        } ?>
                        <input type="hidden" name="dali_home_id" value="">
                    </div>
                </div>
            <?php 
            restore_current_blog();            
            /**====================================================================================== */
            
        }
         
        
        /*--------------------------------------------------------------------------------------
		*
		* dali_total_sales
		*
		* @author Sherif Ali
		* @since 1.0.0
		*
        * [dali-site-url]
        * [dali-site-url blog-id=""]
		*-------------------------------------------------------------------------------------*/
        function dali_site_url( $atts, $content = null ) {

            $atts = shortcode_atts( array(
                "blog-id"  => false,
            ), $atts );

            extract( $atts );
            ob_start();
            if( !empty( $atts['blog-id'] ) && is_numeric( $atts['blog-id'] ) ){
                 $blog_id = $atts['blog-id'];
            }else{
                 $blog_id  = get_current_blog_id();
            }
            $blog_url  = get_site_url( $blog_id );
            $blog_host = parse_url($blog_url, PHP_URL_HOST);
            $blog_path = parse_url($blog_url, PHP_URL_PATH);
            if( !empty( $blog_path ) ){
                $output = $blog_host.$blog_path;
            } else {
                $output = $blog_host;
            }
            
            $output .= ob_get_clean();

            return $output;
        }

/*--------------------------------------------------------------------------------------
		*
		* dali_total_sales
		*
		* @author Sherif Ali
		* @since 1.0.0
		*
        * [dali-product-count]
		*-------------------------------------------------------------------------------------*/
        function dali_product_count( $atts, $content = null ) {

            $atts = shortcode_atts( array(), $atts );

            extract( $atts );
            ob_start();
            $args = array(
                // 'stock_status' => 'instock',
                'status' => 'publish',
                'limit' => -1,
            );
            $products = wc_get_products( $args );
            if( count( $products ) > 0  ){
                $output = count( $products );
            }else{
                $output = 0;
            }
            
            
            
            $output .= ob_get_clean();

            return $output;
        }

        /*--------------------------------------------------------------------------------------
		*
		* Parse data-attributes for shortcodes
		*
		*-------------------------------------------------------------------------------------*/
        function parse_data_attributes( $data ) {

            $data_props = '';

            if( $data ) {
                $data = explode( '|', $data );

                foreach( $data as $d ) {
                    $d = explode( ',', $d );
                    $data_props .= sprintf( 'data-%s="%s" ', esc_html( $d[0] ), esc_attr( trim( $d[1] ) ) );
                }
            }
            else {
                $data_props = false;
            }
            return $data_props;
        }

       /*--------------------------------------------------------------------------------------
		*
		* Get dali_get_total_sales_db for shortcodes
		*
		*-------------------------------------------------------------------------------------*/
        function dali_get_total_sales_db() {

            global $wpdb;
            
            $order_totals = apply_filters( 'woocommerce_reports_sales_overview_order_totals', $wpdb->get_row( "
            
            SELECT SUM(meta.meta_value) AS total_sales, COUNT(posts.ID) AS total_orders FROM {$wpdb->posts} AS posts
            
            LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
            
            WHERE meta.meta_key = '_order_total'
            
            AND posts.post_type = 'shop_order'
            
            AND posts.post_status IN ( '" . implode( "','", array( 'wc-completed', 'wc-processing', 'wc-on-hold' ) ) . "' )
            
            " ) );
            
            return absint( $order_totals->total_sales);
            
        }
}

new DaliShortcodes();