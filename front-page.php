<!DOCTYPE html>
<html lang="ee">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NNK booking form">
    <title>Avaleht | Narva Noortekeskus</title>
    <?php wp_head(); ?>
    <script type="text/javascript">var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";</script>
</head>
<body>
<?php get_header(); ?>

<div class="container content">
    <?php while(have_posts()) : the_post() ?>
        <h2 class="page-title-container"><?php the_title(); ?></h2>
        <?php the_content() ?>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>
