<!-- menu --><nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	<div class="container">
		<a class="navbar-brand" href="#">CMS Welcome</a>
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
									$list .= '<a class="dropdown-item" href="'.$child->menu_href.'">'.$child->menu_item.'</a>';
								}
							}

							$list .= '</div></li>';
						}
					}
					else {
						$list .= '<li class="nav-item"><a class="nav-link" href="'.$menu->menu_href.'">'.$menu->menu_item.'</a></li>';
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
