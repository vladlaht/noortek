<!DOCTYPE html>
<html lang="ee">
<head>
    <title>Avaleht | Narva Noortekeskus</title>
    <?php wp_head(); ?>
</head>
<body>
<?php get_header(); ?>
<div class="container content">
    <h2><?php _e("Viimased uudised", "noortek") ?></h2>
    <?php $the_query = new WP_Query(['post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 8]); ?>
    <?php if ($the_query->have_posts()) : ?>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <div class="card col-4" style="width: 18rem;">
                            <img src="<?php echo get_the_post_thumbnail_url($ID) ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php the_title(); ?></h5>
                                <p class="card-text"><?php the_content(null, true) ?></p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>
