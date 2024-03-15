<?php

use Carbon_Fields\Container;
use Carbon_Fields\Complex_Container;
use Carbon_Fields\Field;


/*-----------------------------------------------------------------------------------*/
/* Product Additional Information
/*-----------------------------------------------------------------------------------*/

Container::make('post_meta', 'Tech Sheets')
	->where('post_type', '=', 'product')
	->set_priority('high')
	->add_fields(
		array(
			Field::make('complex', 'tech_sheets', __('Tech Sheet'))
				->add_fields(array(
					Field::make('text', 'tech_sheet_heading', __('Tech Sheet Heading')),
					Field::make('file', 'tech_sheet_file', __('Tech Sheet File')),
				))
				->set_layout('tabbed-horizontal')
		)
	);
