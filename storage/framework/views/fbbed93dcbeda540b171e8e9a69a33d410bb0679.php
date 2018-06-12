
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0"/>
    <meta name="format-detection" content="telephone=no">
    <title><?php echo e($_page->meta_title); ?></title>

    <meta name="robots" content="<?php echo e($_page->indexing==1 ? 'index, follow' : 'noindex, nofollow'); ?>" />
    <meta name="description" content="<?php echo e($_page->meta_desc); ?>" />
    <meta name="keywords" content="<?php echo e($_page->meta_keys); ?>" />
    <meta name="author" content="KAM Studio" />

    <?php if($_route == 'post'): ?>
      <meta property="og:title" content="<?php echo e($post->name); ?>">
      <meta property="og:description" content="<?php echo e($post->content); ?>">
      <meta property="og:url" content="http://beta24.com">
      <meta property="og:site_name" content="beta24"/>
      <meta property="og:type" content="website" />
      <meta property="og:image" content="<?php echo e(url($post->cover)); ?>">
      <meta property="og:image:width" content="600">
      <meta property="og:image:height" content="315">
      <meta property="og:image:type" content="image/jpeg">
    <?php endif; ?>

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(url('/public/img/favicon/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(url('/public/img/favicon/apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(url('/public/img/favicon/apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(url('/public/img/favicon/apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(url('/public/img/favicon/apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(url('/public/img/favicon/apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(url('/public/img/favicon/apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(url('/public/img/favicon/apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(url('/public/img/favicon/apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e(url('/public/img/favicon/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(url('/public/img/favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(url('/public/img/favicon/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(url('/public/img/favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(url('/public/img/favicon/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(url('/public/img/favicon/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">
    <!-- end favicon -->
    
    <link rel="stylesheet" href="<?php echo e(url('/public/css/base.css')); ?>">
    <?php if(in_array($_route, ['profile','orders','order','cart','discounts','security','balance','pricelists','product','products'])): ?>
    <link rel="stylesheet" href="<?php echo e(url('/public/css/user.css')); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(url('/public/css/__.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('/public/css/chat.css')); ?>">

    <!--[if IE]>
        <script src="<?php echo e(url('/public/js/respond.min.js')); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-shim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es5-shim/4.5.7/es5-sham.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/json3/3.3.2/json3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-shim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/es6-shim/0.34.2/es6-sham.min.js"></script>
        <script src="https://wzrd.in/standalone/es7-shim@latest"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

  </head>
  <body class="<?php echo e($_bodyclass); ?>">
    <?php echo $__env->make('elements.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('elements.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('elements.modals', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('elements.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </body>
  <?php echo e(csrf_field()); ?>

</html>
