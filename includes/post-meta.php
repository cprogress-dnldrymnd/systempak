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



Container::make('term_meta', __('Category Properties'))
	->where('term_taxonomy', '=', 'product_cat')
	->add_fields(array(
		Field::make('checkbox', 'hide_featured_section', __('Hide Featured Section')),
		Field::make('complex', 'featured_section', __('Featured Section Left'))
			->add_fields(array(
				Field::make('text', 'heading', __('Heading')),
				Field::make('textarea', 'description', __('Description')),
				Field::make('image', 'image', __('Image/Icon')),
			))
			->set_layout('tabbed-horizontal')
			->set_header_template('<%- heading %>'),
			Field::make('complex', 'featured_section_right', __('Featured Section Right'))
			->add_fields(array(
				Field::make('text', 'heading', __('Heading')),
				Field::make('textarea', 'description', __('Description')),
				Field::make('image', 'image', __('Image/Icon')),
			))
			->set_layout('tabbed-horizontal')
			->set_header_template('<%- heading %>')
	));
