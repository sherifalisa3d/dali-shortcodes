<?php
/*
Plugin Name: Dali Shortcodes
Plugin URI: https://github.com/sherifalisa3d/dali-shortcodes
Description: The plugin adds a shortcodes for dali elements.
Version: 1.0.0
Author: Sherif Ali
Author URI: https://github.com/sherifalisa3d/
License: MIT
*/

/* ============================================================= */

/*========================================================================
 Include necessary functions and files
========================================================================*/

require_once( dirname( __FILE__ ) . '/includes/defaults.php' );
require_once( dirname( __FILE__ ) . '/includes/actions-filters.php' );

/*========================================================================*/

	// Begin Shortcodes
	class DaliShortcodes {

        /*========================================================================
          Initialize shortcodes
         ======================================================================== */
    
        function __construct(){
            //Initialize shortcodes
            add_action( 'init', array( $this, 'add_shortcodes' ) );
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
        * [dali-orders xclass="extra-class" data="number,animated|id,12"]
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
        * [dali-total-sales xclass="extra-class" data="number,animated|id,12"]
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
            $wc_product = new WC_Product();
            $dali_total_sales = $wc_product->get_total_sales();

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
}

new DaliShortcodes();