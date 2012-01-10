<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

<meta name="description" content="<?php bloginfo('name'); ?>. <?php if ( is_single() ) { ?>  &raquo; Blog Archive <?php } ?>. <?php wp_title(); ?>." />

 <meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<!--[if lt ie 7]>	
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_directory'); ?>/ie-win.css" />
	<![endif]-->	
	
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />

<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_get_archives('type=monthly&format=link'); ?>

<?php wp_head(); ?>

	<link href="http://www.flator.se/styleWhyBuddha.css" rel="stylesheet" type="text/css"> 

 
 
 
<script type="text/javascript"> 
window.addEvent('domready', function() {
 
	/**
	 * That CSS selector will find all <a> elements with the
	 * attribute rel="boxed"
	 *
	 * The second argument sets additional options.
	 */
});
</script> 
 
 
 
  
</head> 
 
<body> 
 
<div id="logo"> 
	<a href="http://www.flator.se/" title="Flator.se"></a> 
</div> 
<div id="main"> <div id="center">
			<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
			<div class="description"><?php bloginfo('description'); ?></div>