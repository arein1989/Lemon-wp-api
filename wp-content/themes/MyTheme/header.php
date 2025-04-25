<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?> <!-- WordPress head hook -->
</head>
<body <?php body_class(); ?>>
<header>
    <h1><?php bloginfo('name'); ?></h1> <!-- Site name -->
    <span><?php bloginfo('description'); ?></span> <!-- Tagline -->
</header>