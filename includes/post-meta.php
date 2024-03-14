<?php

use Carbon_Fields\Container;
//use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;


/*-----------------------------------------------------------------------------------*/
/* Product Additional Information
/*-----------------------------------------------------------------------------------*/

Container::make('post_meta', 'Product Additional Information')
	->where('post_type', '=', 'product')
	->set_priority('high')
	->add_fields(
		array(
			Field::make('file', 'tech_sheet', __('Tech Sheet')),
		)
	);
