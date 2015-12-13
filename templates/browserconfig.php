<?php
/**
 * Template for browserconfig.xml
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

header( 'Content-type: application/xml' );
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<browserconfig>
  <msapplication>
    <tile>
      <square70x70logo src="<?php the_site_icon_url( 'mstile-70x70.png' ); ?>"/>
      <square150x150logo src="?<php the_site_icon_url( 'mstile-150x150.png' ); ?>"/>
      <square310x310logo src="<?php the_site_icon_url( 'mstile-310x310.png' ); ?>"/>
      <wide310x150logo src="<?php the_site_icon_url( 'mstile-310x150.png' ); ?>"/>
      <TileColor><?php the_site_icon_tile_color(); ?></TileColor>
    </tile>
  </msapplication>
</browserconfig>

