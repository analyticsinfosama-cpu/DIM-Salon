<?php
/**
 * Plugin Name: DIM Salon – Limpieza de espacios en enlaces
 * Description: Elimina espacios sobrantes (%20) al final de los href para evitar
 *              URLs duplicadas (auditoría SEO DinoRANK, bloque urls_lentas).
 * Version:     1.0.0
 *
 * Instalación: copiar a wp-content/mu-plugins/ (se activa automáticamente).
 * Es una red de seguridad: lo correcto es corregir también el enlace en Elementor.
 */

defined( 'ABSPATH' ) || exit;

/**
 * href="…/%20%20" o href="…/ " -> href="…/"
 */
function dim_trim_href_spaces( $html ) {
	if ( ! is_string( $html ) || false === stripos( $html, 'href' ) ) {
		return $html;
	}
	return preg_replace_callback(
		'#\bhref=(["\'])\s*([^"\']*?)(?:\s|%20|&nbsp;|&\#160;)+\1#i',
		function ( $m ) {
			return 'href=' . $m[1] . $m[2] . $m[1];
		},
		$html
	);
}
add_filter( 'the_content', 'dim_trim_href_spaces', 999 );
add_filter( 'widget_text', 'dim_trim_href_spaces', 999 );
add_filter( 'wp_nav_menu', 'dim_trim_href_spaces', 999 );
add_filter( 'elementor/frontend/the_content', 'dim_trim_href_spaces', 999 );
add_filter( 'elementor/widget/render_content', 'dim_trim_href_spaces', 999 );
