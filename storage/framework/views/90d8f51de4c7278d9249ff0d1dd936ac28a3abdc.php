<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section Gallery -->
<section class="section section--content  section-gallery animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <h3 class="section-title-small section-title-small--red animatable"><?php echo e($_page->text_2); ?></h3>
            <div class="section-text animatable">
                <?php echo $_page->text_3; ?>

            </div>

            <div class="tripple-container animate">

              <?php foreach($gallery as $item): ?>
                <div class="excerpt gallery-excerpt animate">
                  <a class="gallery-excerpt__body js_gallery-slider-btn"
                    href="<?php echo e(sizeof($item->images) > 1 ? url($item->images[0]['file']) : ''); ?>"
                    data-gallery-images="<?php echo e(implode('||', array_column($item->images, 'file'))); ?>"
                    data-gallery-captions="<?php echo e(implode('||', array_column($item->images, 'title'))); ?>">
                    <div class="gallery-excerpt__image" style="background-image: url('<?php echo e(url($item->images[0]['file'])); ?>');"></div>
                    <div class="gallery-excerpt__overlay">
                      <span class="gallery-excerpt__overlay__text"><?php echo e($_page->text_4); ?></span>
                    </div>
                    <?php if(sizeof($item->images) > 1): ?>
                    <div class="gallery-excerpt__body__container">
                      <span class="gallery-excerpt__body__text"><?php echo e($_page->text_5); ?></span>
                      <span class="gallery-excerpt__body__count"><span>+ <?php echo e(sizeof($item->images) - 1); ?></span></span>
                    </div>
                    <?php endif; ?>
                  </a>
                  <div class="gallery-excerpt__footer">
                    <h3 class="gallery-excerpt__title"><?php echo e($item->name); ?></h3>
                    <span class="gallery-excerpt__subtitle"><?php echo e($item->title); ?></span>
                  </div>
                </div>
              <?php endforeach; ?>

            </div>

        </div>
    </div>
</section>


</main>
<?php echo $__env->make('elements.gallerymodal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>