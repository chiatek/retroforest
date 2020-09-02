<!-- menu --><nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container">
		<a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo site_url('assets/img/uploads/retroforest.png'); ?>" class="nav-logo" alt="retro forest" /></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

	  	<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<!-- code -->
			<?php

			if ($menu_item->rowCount() > 0) {
				 $list = '<ul class="navbar-nav ml-auto">';

				while ($menu = $menu_item->fetch()) {
					if (isset($menu->menu_parent_id)) {

						if (!isset($menu->menu_parent_order)) {
							$list .= '<li class="nav-item dropdown">'.
									  '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$menu->menu_item.'</a>'.
									  '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';

							while ($child = $parent_id->fetch()) {
								if ($menu->menu_id == $child->menu_parent_id) {
									$list .= '<a class="dropdown-item" href="'.$child->menu_href.'"><strong>'.$child->menu_item.'</strong></a>';
								}
							}

							$list .= '</div></li>';
						}
					}
					else {
						$list .= '<li class="nav-item"><a class="nav-link" href="'.$menu->menu_href.'"><strong>'.$menu->menu_item.'</strong></a></li>';
					}

				}
				$list .= '</ul>';

				echo $list;
			}
			else {
				echo "<!-- No menu items found -->";
			}

			?>
			<!-- End code -->
		</div>
	</div>
</nav>
<!-- End menu -->