<?php $__env->startSection('content'); ?>
<main class="page-content">
<!-- Section About Us -->
<section class="section section--content section-sitemap animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <h3 class="section-title-small animatable"><?php echo e($_page->text_2); ?></h3>
            <div class="section-text animatable">
                <?php echo e($_page->text_3); ?>

            </div>

            <div class="sitemap-blocks animate">

              <?php foreach($sitemap as $category): ?>
                <div class="sitemap-block">
                    <a class="link-main"><?php echo e($category->name); ?></a>
                    <?php foreach($category->nestings as $nesting): ?>
                      <a href="<?php echo e(url($nesting->alias)); ?>" target="_blank" class="link"><?php echo e($nesting->name); ?></a>
                    <?php endforeach; ?>
                </div>
              <?php endforeach; ?>

            </div>

            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="authorization" data-modal-part="1">Registration</a> -->
            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="authorization" data-modal-part="2">Login</a> -->
            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="authorization" data-modal-part="3">Forgot password</a> -->
            <!-- <a href="" target="_blank" class="link js_modal-open" data-modal-type="email-feedback" data-modal-part="1">Feedback</a> -->

        </div>
    </div>
</section>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>