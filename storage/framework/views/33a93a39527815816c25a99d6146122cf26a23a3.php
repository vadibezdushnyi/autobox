<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section News post -->
<section class="section section--content  section-certificates animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <div>
              <?php foreach($certificates as $certificate): ?>
              <div class="certificates-container animate">
                <div class="certificates-container__gallery">
                  <a class="gallery-excerpt__body js_gallery-slider-btn"
                  href="<?php echo e(sizeof($certificate->images) > 1 ? url($certificate->images[0]['file']) : ''); ?>"
                  data-gallery-images="<?php echo e(implode('||', array_column($certificate->images, 'file'))); ?>"
                  data-gallery-captions="<?php echo e(implode('||', array_column($certificate->images, 'title'))); ?>"
                  data-gallery-type="nocaption">
                    <div class="gallery-excerpt__image" style="background-image: url('<?php echo e(url($certificate->images[0]['file'])); ?>');"></div>
                    <div class="gallery-excerpt__overlay">
                      <span class="gallery-excerpt__overlay__text"><?php echo e($_page->text_2); ?></span>
                    </div>
                    <?php if(sizeof($certificate->images) > 1): ?>
                    <div class="gallery-excerpt__body__container">
                      <span class="gallery-excerpt__body__text"><?php echo e($_page->text_3); ?></span>
                      <span class="gallery-excerpt__body__count"><span>+ <?php echo e(sizeof($certificate->images) - 1); ?></span></span>
                    </div>
                    <?php endif; ?>
                  </a>
                </div>
                <div class="certificates-container__info">
                  <h3 class="section-title-small"><?php echo e($certificate->name); ?></h3>
                  <div class="section-text">
                    <?php echo $certificate->content; ?>

                  </div>
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