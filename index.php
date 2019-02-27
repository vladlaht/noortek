<html>
<head>
    <title>Avaleht | Narva Noortekeskus</title>
    <?php wp_head(); ?>
</head>
<body>
<?php get_header(); ?>
<div class="container content">
<?php while(have_posts()) : the_post() ?>
    <?php the_content() ?>
<?php endwhile; ?>
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>