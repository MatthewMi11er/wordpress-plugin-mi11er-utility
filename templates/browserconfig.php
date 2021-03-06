<?php
/**
 * Template for browserconfig.xml
 *
 * Use this for customization of browserconfig.xml
 * {@see https://msdn.microsoft.com/en-us/library/dn320426(v=vs.85).aspx}
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use Mi11er\Utility\Template_Tags as TT;

// Make sure to set appropriate headers.
header( 'Content-type: application/xml' );
?>
<?xml version="1.0" encoding="utf-8"?>
<browserconfig>
	<msapplication>
		<tile>
			<square70x70logo src="<?php TT::the_site_icon_url( 'mstile-70x70.png' ); ?>"/>
			<square150x150logo src="<?php TT::the_site_icon_url( 'mstile-150x150.png' ); ?>"/>
			<square310x310logo src="<?php TT::the_site_icon_url( 'mstile-310x310.png' ); ?>"/>
			<wide310x150logo src="<?php TT::the_site_icon_url( 'mstile-310x150.png' ); ?>"/>
			<TileColor><?php TT::the_site_icon_tile_color(); ?></TileColor>
		</tile>
	</msapplication>
</browserconfig>

