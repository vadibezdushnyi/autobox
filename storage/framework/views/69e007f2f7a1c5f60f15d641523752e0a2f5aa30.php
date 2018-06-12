<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section News post -->
<section class="section section--content  section-news-post animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>

            <a href="<?php echo e(url('/news')); ?>" class="link-back"><?php echo e($_page->text_2); ?></a>

            <div class="news-post-container animate">
                <div class="post-excerpt post-excerpt--news-post animate">
                    <div class="post-excerpt__gallery">
                        <a class="gallery-excerpt__body js_gallery-slider-btn" href="<?php echo e(url($post->cover)); ?>"
                          data-gallery-images="<?php echo e(implode('||', array_column($post->gallery, 'file'))); ?>"
                          data-gallery-captions="<?php echo e(implode('||', array_column($post->gallery, 'title'))); ?>">
                            <div class="gallery-excerpt__image" style="background-image: url('<?php echo e(url($post->cover)); ?>')"></div>
                            <div class="gallery-excerpt__overlay">
                                <span class="gallery-excerpt__overlay__text"><?php echo e($_page->text_3); ?></span>
                            </div>
                            <div class="gallery-excerpt__body__container">
                                <span class="gallery-excerpt__body__text"><?php echo e($_page->text_4); ?></span>
                                <span class="gallery-excerpt__body__count"><span>+ <?php echo e(sizeof($post->gallery)); ?></span></span>
                            </div>
                        </a>
                    </div>
                    <div class="post-excerpt__info">
                        <div class="post-excerpt__meta">
                            <span class="post-excerpt__label"><?php echo e($post->category); ?></span>
                            <span class="post-excerpt__date"><?php echo e(date('d', strtotime($post->created))); ?><span> / </span><?php echo e(date('M', strtotime($post->created))); ?><span> / </span><?php echo e(date('Y', strtotime($post->created))); ?></span>
                        </div>
                        <h2 class="post-excerpt__title">
                            <?php echo e($post->name); ?>

                        </h2>
                        <div class="post-excerpt__description">
                          <?php echo $post->content; ?>

                        </div>
                    </div>
                </div>

            </div>

            <div class="news-post-footer">
                <div class="post-excerpt__tags">
                  <?php foreach($post->tagnames as $tag): ?>
                    <span class="tag"><?php echo e($tag); ?></span>
                  <?php endforeach; ?>
                </div>
                <div class="social-links-simple">
                    <a href="javascript:void(0)" class="social-link link-facebook">
                        <span class="icon icon-facebook"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-twitter">
                        <span class="icon icon-twitter"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-instagram">
                        <span class="icon icon-instagram"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-google-plus">
                        <span class="icon icon-google-plus"></span>
                    </a>
                    <a href="javascript:void(0)" class="social-link link-linkedin">
                        <span class="icon icon-linkedin"></span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>


</main>
<?php echo $__env->make('elements.gallerymodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>