<?php

/**
 * Preprocessor for html.tpl.php
 * Adds meta tag to control viewport, and path to theme in JS.
 */

function plain_response_preprocess_html(&$vars) {
  
  $meta = array(
    '#tag' => 'meta',
      '#attributes' => array(
  	  'name' => 'viewport',
  	  'content' => 'width=device-width, initial-scale=1, minimum-scale=1',
    ),
  );
  
  drupal_add_html_head($meta, 'plain-response-viewport');
  
  $settings = array(
    'base_url' => url('<front>', array('absolute' => 'true')),
  	'theme_path' => path_to_theme(),
  	'default_scheme' => file_default_scheme(),
  );
  
  foreach(file_get_stream_wrappers() as $name => $wrapper) {
  	$settings[$name.'_files'] = file_create_url($name.'://');
  }
  
  $path = drupal_get_path('theme', 'plain_response');
  drupal_add_js(array('plain_response' => $settings), array('type' => 'setting'));
}

/**
 * Preprocessor for page.tpl.php
 * Adds site name and page name,
 * sets grid class names for site name and content areas.
 */

function plain_response_preprocess_page(&$vars) {
  
  $vars['site_name'] = variable_get('site_name', '');
  $vars['page_title'] = drupal_get_title();
  
  $classes = array(
  	'site_name' => 'grid_16 alpha omega',
  	'logo' => 'grid_4 alpha',
  	'content' => 'grid_16',
  	'content_left' => '',
  	'content_right' => '',
  	'top_nav' => '',
  );
  
  /* Make room for logo */
  if (!empty($vars['logo'])) {
  	$classes['site_name'] = 'grid_12 omega';
  }
  
  /* Set column widths */
  if (!empty($vars['page']['content_left'])) {
  	$classes['content_left'] = 'grid_6 alpha';
  	$classes['content'] = 'grid_10 omega';
  }
  if (!empty($vars['page']['content_right'])) {
  	$classes['content'] = 'grid_10 alpha';
  	$classes['content_right'] = 'grid_6 omega';
  }
  if (!empty($vars['page']['content_left']) && !empty($vars['page']['content_right'])) {
  	$classes['content_left'] = 'grid_3 alpha';
  	$classes['content'] = 'grid_10';
  	$classes['content_right'] = 'grid_3 omega';
  }
  
  /* Support fixing nav to top */
  if (theme_get_setting('fix_nav') == 1) {
    $classes['top_nav'] = 'top-fixed';
  }
  
  $vars['page_classes'] = $classes;
  
}

/**
 * Override for theme_image_style
 * Adds custom styles for this theme
 */

function plain_response_image_style($variables) {
  // Determine the dimensions of the styled image.
  $dimensions = array(
    'width' => $variables['width'], 
    'height' => $variables['height'],
  );

  image_style_transform_dimensions($variables['style_name'], $dimensions);

  $variables['width'] = $dimensions['width'];
  $variables['height'] = $dimensions['height'];

  $original_path = $variables['path'];
  $variables['attributes']['data-originalsrc'] = $original_path;
  // Determine the url for the styled image.
  $variables['path'] = image_style_url($variables['style_name'], $original_path);
  
  // Use quarter as default size.
  if (strpos($variables['style_name'], 'plain_response_') === 0) {
    $variables['path'] = image_style_url('plain_response_quarter', $original_path);
    if (!isset($variables['attributes']['class'])) {
      $variables['attributes']['class'] = '';
    }
    $variables['attributes']['class'] .= ' '.str_replace('plain_response_', '', $variables['style_name']);
    unset($variables['width']);
    unset($variables['height']);
  }
  
  return theme('image', $variables);
}

/**
 * Override for theme_image
 * Ensures that the data-originalsrc attribute is set
 */

function plain_response_image($variables) {
  $attributes = $variables['attributes'];
  $attributes['src'] = file_create_url($variables['path']);
  
  if (!isset($attributes['data-originalsrc'])) {
    $attributes['data-originalsrc'] = $variables['path'];
  }

  foreach (array('width', 'height', 'alt', 'title') as $key) {

    if (isset($variables[$key])) {
      $attributes[$key] = $variables[$key];
    }
  }

  return '<img' . drupal_attributes($attributes) . ' />';
}