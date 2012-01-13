<div class="page-wrapper container">

	<header class="page-header-container clearfix">
		
		<?php if (isset($site_name)): ?>
		<div class="site-name-container container">
			
			<?php if (!empty($logo)): ?>
			<div class="site-logo <?php print $page_classes['logo']; ?>">
				<a href="<?php print url('<front>'); ?>" title="<?php print t('Return to home page'); ?>">
				<?php 
				print theme('image', array(
					'path' => $logo,
					'attributes' => array(
						'class' => 'full',
						'alt' => $site_name.' logo',
					),
				)); 
				?>
				</a>
			</div>
			<?php endif; ?>
			
			<?php if (drupal_is_front_page()): ?>
				<h1 id="site-name" class="<?php print $page_classes['site_name']; ?>">
			<?php else: ?>
				<header id="site-name" class="<?php print $page_classes['site_name']; ?>">
			<?php endif; ?>
			
				<a href="<?php print url('<front>'); ?>" title="<?php print t('Return to home page'); ?>">
				<?php print $site_name; ?>
				</a>
			
			<?php if (drupal_is_front_page()): ?>
				</h1>
			<?php else: ?>
				</header>
			<?php endif; ?>
			
		</div>
		<?php endif; ?>
		
		<?php if (isset($page['user_bar'])): ?>
			<div class="page-header-user-bar">
				<?php print render($page['user_bar']); ?>
			</div>
		<?php endif; ?>
		
		<?php if (isset($page['top_nav'])): ?>
			<div class="page-header-top-nav <?php print $page_classes['top_nav']; ?>">
				<?php print render($page['top_nav']); ?>
			</div>
		<?php endif; ?>
		
	</header>
	
	<section class="page-content-container clearfix">
		
		<?php if (!empty($breadcrumbs) || !empty($tabs) || isset($page['content_prefix'])) : ?>
		<header class="page-content-prefix">
			<?php if (!empty($breadcrumbs)): ?>
			<?php print render($breadcrumbs); ?>
			<?php endif; ?>
			
			<?php if (!empty($tabs)): ?>
			<?php print render($tabs); ?>
			<?php endif; ?>
			
			<?php print render($page['content_prefix']); ?>
		</header>
		<?php endif; ?>
		
		<div class="page-content">
		
		<?php if (!empty($page_title)): ?>
		<header class="page-content-title">
			<?php if (drupal_is_front_page()): ?>
				<h2 id="page-name"><?php print $page_title; ?></h2>
			<?php else: ?>
				<h1 id="page-name"><?php print $page_title; ?></h1>
			<?php endif; ?>
		</header>
		<?php endif; ?>
		
		<?php if (isset($page['content_left'])) : ?>
		<div class="page-content-left <?php print $page_classes['content_left']; ?>">
			<?php print render($page['content_left']); ?>
		</div>
		<?php endif; ?>
		
		<div id="content" class="<?php print $page_classes['content']; ?>">
		<?php if (isset($page['content'])) : ?>
			<?php print render($page['content']); ?>
		<?php endif; ?>
		</div>
		
		<?php if (isset($page['content_right'])) : ?>
		<div class="page-content-right <?php print $page_classes['content_right']; ?>">
			<?php print render($page['content_right']); ?>
		</div>
		<?php endif; ?>
		
		</div>
		
		<?php if (isset($page['content_suffix'])) : ?>
		<footer class="page-content-suffix">
			<?php print render($page['content_suffix']); ?>
		</footer>
		<?php endif; ?>
		
	</section>
	
	<footer class="page-footer-container clearfix">
		
		<?php if (isset($page['bottom_nav'])): ?>
			<div class="page-footer-bottom-nav">
				<?php print render($page['bottom_nav']); ?>
			</div>
		<?php endif; ?>
		
		<?php if (isset($page['footer'])) : ?>
			<?php print render($page['footer']); ?>
		<?php endif; ?>
		
	</footer>

</div>

<?php if (isset($page['closure'])) : ?>
	<?php print render($page['closure']); ?>
<?php endif; ?>