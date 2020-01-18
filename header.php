<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="<?php bloginfo('charset');?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php wp_title();?></title>
  <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" />
  
  <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/css/style.css'; ?>" type="text/css" />

  <?php
    wp_head(); 
  ?>
</head>
<body <?php body_class(); ?>>
