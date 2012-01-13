<?php

/**
 * Define preset image styles for responsive behaviour
 */

function _plain_response_image_styles() {
	$styles = array(
	  'quarter' => array(
		'effects' => array(
		  array(
			'effect callback' => 'image_scale_effect',
			'dimensions callback' => 'image_resize_dimensions',
			'form callback' => 'image_resize_form',
			'summary theme' => 'image_resize_summary',
			'module' => 'image',
			'name' => 'image_scale',
			'data' => array(
			  'width' => '400',
			  'height' => null,
			  'upscale' => false
			),
			'weight' => '1',
		  ),
		),
	  ),
	  'third' => array(
		'effects' => array(
		  array(
			'effect callback' => 'image_scale_effect',
			'dimensions callback' => 'image_resize_dimensions',
			'form callback' => 'image_resize_form',
			'summary theme' => 'image_resize_summary',
			'module' => 'image',
			'name' => 'image_scale',
			'data' => array(
			  'width' => '512',
			  'height' => null,
			  'upscale' => false
			),
			'weight' => '1',
		  ),
		),
	  ),
	  'half' => array(
		'effects' => array(
		  array(
			'effect callback' => 'image_scale_effect',
			'dimensions callback' => 'image_resize_dimensions',
			'form callback' => 'image_resize_form',
			'summary theme' => 'image_resize_summary',
			'module' => 'image',
			'name' => 'image_scale',
			'data' => array(
			  'width' => '800',
			  'height' => null,
			  'upscale' => false
			),
			'weight' => '1',
		  ),
		),
	  ),
	  'twothirds' => array(
		'effects' => array(
		  array(
			'effect callback' => 'image_scale_effect',
			'dimensions callback' => 'image_resize_dimensions',
			'form callback' => 'image_resize_form',
			'summary theme' => 'image_resize_summary',
			'module' => 'image',
			'name' => 'image_scale',
			'data' => array(
			  'width' => '1024',
			  'height' => null,
			  'upscale' => false
			),
			'weight' => '1',
		  ),
		),
	  ),
	  'threequarters' => array(
		'effects' => array(
		  array(
			'effect callback' => 'image_scale_effect',
			'dimensions callback' => 'image_resize_dimensions',
			'form callback' => 'image_resize_form',
			'summary theme' => 'image_resize_summary',
			'module' => 'image',
			'name' => 'image_scale',
			'data' => array(
			  'width' => '1200',
			  'height' => null,
			  'upscale' => false
			),
			'weight' => '1',
		  ),
		),
	  ),
	  'full' => array(
		'effects' => array(
		  array(
			'effect callback' => 'image_scale_effect',
			'dimensions callback' => 'image_resize_dimensions',
			'form callback' => 'image_resize_form',
			'summary theme' => 'image_resize_summary',
			'module' => 'image',
			'name' => 'image_scale',
			'data' => array(
			  'width' => '1600',
			  'height' => null,
			  'upscale' => false
			),
			'weight' => '1',
		  ),
		),
	  ),
	);
	return $styles;
}

/**
 * Check whether all styles have been created
 */

function _plain_response_check_styles() {
  $count = 0;
  $styles = _plain_response_image_styles();
  foreach (array_keys($styles) as $part) {
	$name = 'plain_response_'.$part;
	
	$style = image_style_load($name);
	if (!empty($style)) {
	  $count++;
	}
  }
  return $count == count($styles);
}

/**
 * Alters theme settings form
 * Adds buttons to enable or disable custom image styles
 */

function plain_response_form_system_theme_settings_alter(&$form, &$form_state) {
  
  $form['theme_settings']['fix_nav'] = array(
    '#type' => 'checkbox',
    '#title' => t('Fix nav to top of window'),
    '#value' => theme_get_setting('fix_nav'),
  );
  
  $form['theme_settings']['enable_custom_image_styles'] = array(
    '#type' => 'submit',
    '#value' => t('Add Custom Image Styles'),
    '#prefix' => '<p>'.(
      _plain_response_check_styles() ? t('All custom styles are active.') : 
      t('Some custom styles are not active. Please click <em>Add Custom Image Styles</em> to enable them.')
    ).'</p>',
    '#submit' => array('_plain_response_settings_form_submitted'),
  );
  
  $form['theme_settings']['disable_custom_image_styles'] = array(
    '#type' => 'submit',
    '#value' => t('Remove Custom Image Styles'),
    '#submit' => array('_plain_response_settings_form_submitted'),    
  );
}

/**
 * Add or remove styles if button is clicked
 */

function _plain_response_settings_form_submitted($form, $form_state) {
	$styles = _plain_response_image_styles();
	
	if ($form_state['values']['op'] === t('Add Custom Image Styles')) {
	  
	  foreach ($styles as $part => $settings) {
	    $name = 'plain_response_'.$part;
	    
	    $style = image_style_load($name);
	    if (empty($style)) {
	      $style = image_style_save(array(
			'name' => $name
		  ) + $settings);
		  
		  foreach($settings['effects'] as $effect) {
		    $effect = image_effect_save(array(
		      'isid' => $style['isid'],
		    ) + $effect);
		  }
	    }
	  }
	  
	  drupal_set_message('Custom image styles have been added.');
	}
	
	if ($form_state['values']['op'] === t('Remove Custom Image Styles')) {
	  foreach (array_keys($styles) as $part) {
	    $name = 'plain_response_'.$part;
	    
	    $style = image_style_load($name);
	    if (!empty($style)) {
	      image_style_delete($style);
	    }
	  }
	  
	  drupal_set_message('Custom image styles have been removed.');
	}
}