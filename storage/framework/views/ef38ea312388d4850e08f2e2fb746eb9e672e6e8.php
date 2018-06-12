<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section Contact Us -->
<section class="section section--content section-news animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <h3 class="section-title-small section-title-small--red animatable"><?php echo e($_page->text_2); ?></h3>
            <div class="section-text animatable">
                <?php echo e($_page->text_3); ?>

            </div>

            <div class="filter-feed-container js_filter-scope animate">

                <div class="filter-nav filter-nav--small">
                    <ul>
                      <?php foreach($tags as $tag): ?>
                        <li>
                            <a href="" class="js_filter-trigger <?php echo e(in_array($tag->alias, ['*','all']) ? 'active' : ''); ?>" <?php echo e(!in_array($tag->alias, ['*','all']) ? 'data-filter='.$tag->alias.'' : ''); ?>><?php echo e($tag->name); ?></a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                </div>

                <div class="filter-feed post-excerpts-container js_filter-feed">
                  <?php foreach($posts as $post): ?>
                    <div class="post-excerpt js_filter-item animate" data-filter="<?php echo e(implode(',', $post->tagaliases)); ?>">
                        <a href="<?php echo e(url('/news/'.$post->alias)); ?>" class="post-excerpt__image">
                            <span class="image-wrapper">
                                <span class="image-container" style="background-image: url('<?php echo e(url('/public/img/content/'.$post->filename)); ?>')">
                                  <img src="<?php echo e(url('/public/img/content/'.$post->filename)); ?>" alt="<?php echo e($post->img_alt); ?>" title="<?php echo e($post->img_title); ?>">
                                </span>
                            </span>
                        </a>
                        <div class="post-excerpt__info">
                            <div class="post-excerpt__meta">
                                <span class="post-excerpt__label"><?php echo e($post->category); ?></span>
                                <span class="post-excerpt__date"><?php echo e(date('d', strtotime($post->created))); ?><span> / </span><?php echo e(date('M', strtotime($post->created))); ?><span> / </span><?php echo e(date('Y', strtotime($post->created))); ?></span>
                            </div>
                            <a href="<?php echo e(url('/news/'.$post->alias)); ?>" class="post-excerpt__title">
                                <?php echo e($post->name); ?>

                            </a>
                            <div class="post-excerpt__description">
                                <?php echo e(substr(strip_tags($post->content), 0, 150).'...'); ?>

                            </div>
                            <div class="post-excerpt__tags">
                              <?php foreach($post->tagnames as $tag): ?>
                                <span class="tag"><?php echo e($tag); ?></span>
                              <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>
    </div>
</section>


</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>