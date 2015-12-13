<?php
/**
 * Template for serving icon files
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

$file = new Sendfile( apply_filters( 'mu_site_icons_' . $request_path, $request_path ) );
$file->send();
