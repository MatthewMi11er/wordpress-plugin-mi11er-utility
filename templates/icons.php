<?php
				$file = new Sendfile( apply_filters( 'mu_site_icons_' . $request_path, $request_path ) );
				$file->send();
