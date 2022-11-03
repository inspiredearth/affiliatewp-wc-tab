// Add this code to the end of your functions.php file in child theme

// AffiliateWP into My Account dashboard
function moh_add_aff_wp_endpoint() {
add_rewrite_endpoint( "aff-area", EP_ROOT | EP_PAGES );
}
add_action( "init", "moh_add_aff_wp_endpoint" );

function moh_add_aff_wp_link_my_account( $items ) {
if ( function_exists( "affwp_is_affiliate" ) && affwp_is_affiliate() ) {
	return array_merge(
	    array_slice($items, 0, count($items)-1),
	    array("aff-area"=>"Affiliate Area"),
	    array_slice($items, count($items)-1 )
	    );
}
return $items;
}
add_filter( "woocommerce_account_menu_items", "moh_add_aff_wp_link_my_account" );

// Render the Affiliate WP Content within the new tab if Affiliate WP is enabled
function moh_aff_wp_content() {
    if ( ! class_exists( "Affiliate_WP_Shortcodes" ) ) {
	return;
}
$shortcode = new Affiliate_WP_Shortcodes;
echo $shortcode->affiliate_area( $atts, $content = null );
}
add_action( "woocommerce_account_aff-area_endpoint", "moh_aff_wp_content" );

// Make sure that the Affiliate WP tabs properly work
function moh_filter_aff_tabs( $url, $page_id, $tab ) {
    return esc_url_raw( add_query_arg( "tab", $tab ) );
}
add_filter( "affwp_affiliate_area_page_url", "moh_filter_aff_tabs", 10, 3 );
