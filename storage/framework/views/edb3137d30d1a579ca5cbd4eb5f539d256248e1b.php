<?php $__env->startSection('content'); ?>
<main class="page-content">
  <!-- Section 404 -->
  <section class="section section--content-inner section-404 animate">
      <div class="page-wrapper">
          <div class="page-container">

              <div class="block-404 animate">
                  <div class="block-404__s">
                      <span class="block-404__s__el letter letter-left">4</span>
                      <div class="block-404__s__el tire">
                          <img alt="" src="<?php echo e(url('/public/img/content/tire.png')); ?>">
                      </div>
                      <span class="block-404__s__el letter letter-right">4</span>
                  </div>
                  <div class="block-404__title">Error</div>
                  <div class="block-404__subtitle">Dear user, unfortunately, you have sought to open a page that does not exist</div>
              </div>

          </div>
      </div>
  </section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>