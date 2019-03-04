<html>
<head>
    <title>Avaleht | Narva Noortekeskus</title>
    <?php wp_head(); ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
</head>
<body>
<?php get_header(); ?>
<div class="container content">
<?php while(have_posts()) : the_post() ?>
<h2><?php the_title(); ?></h2>
    <?php the_content() ?>
<?php endwhile; ?>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>
</body>
</html>