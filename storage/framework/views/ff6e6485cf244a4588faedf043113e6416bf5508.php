<?php $__env->startSection('content'); ?>
<main class="page-content">


<!-- Section Contact Us -->
<section class="section section--content  section-parts-archive animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <h3 class="section-title-small section-title-small--red animatable"><?php echo e($_page->text_2); ?></h3>
            <div class="section-text animatable">
                <?php echo e($_page->text_3); ?>

            </div>

            <div class="tripple-container animate">
              <?php foreach($categories as $category): ?>
              <div class="excerpt parts-excerpt animate">
                  <div class="parts-excerpt__header">
                      <div class="parts-excerpt__image" style="background-image: url('<?php echo e(url('/public/img/content/parts/'.$category->logo)); ?>')"></div>
                      <div class="parts-excerpt__overlay"></div>
                      <div class="parts-excerpt__header__container">
                          <h3 class="parts-excerpt__title"><?php echo e($category->name); ?></h3>
                      </div>
                  </div>
                  <div class="parts-excerpt__body">
                      <div class="parts-excerpt__list scrollbar-dark">
                        <?php if($category->producers): ?>
                          <?php foreach($category->producers as $producer): ?>
                          <div class="parts-excerpt__list__link"><a href="<?php echo e(url('/parts/'.$producer->id)); ?>"><?php echo e($producer->name); ?></a></div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                      <a href="javascript:void(0)" class="btn btn-red"><?php echo e($_page->text_4); ?></a>
                  </div>
              </div>
              <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>


</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>