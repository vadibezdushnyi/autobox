<?php $__env->startSection('content'); ?>
<main class="page-content">

  <!-- Section Products Code -->
  <section class="section section--content section-products-code animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h2 class="page-title"><?php echo e(ucwords($product->producer_name)); ?></h2>
              <div class="brand-info-container">
                  <div class="logo-image"><img alt="" src="<?php echo e(url('/public/img/icons-general/car-logos/', $product->producer_logo)); ?>"></div>
                  <form class="product-overview">
                      <h3 class="partcode-title"><small><?php echo e($_page->text_1); ?></small><?php echo e($product->Code); ?></h3>
                      <table class="product-short-info">
                          <tbody>
                              <tr>
                                  <td><?php echo e($_page->text_2); ?>:</td>
                                  <td><b><?php echo e($product->Details); ?></b></td>
                              </tr>
                              <tr>
                                  <td><?php echo e($_page->text_3); ?>:</td>
                                  <td><b><?php echo e(ucwords($product->producer_name)); ?></b></td>
                              </tr>
                              <?php if($product->factor_group): ?>
                              <tr>
                                  <td><?php echo e($_page->text_4); ?>:</td>
                                  <td><b><?php echo e($product->factor_group); ?></b></td>
                              </tr>
                              <?php endif; ?>
                              <tr>
                                  <td><?php echo e($_page->text_5); ?>:</td>
                                  <td><b><?php echo e($product->Weight); ?></b></td>
                              </tr>
                              <tr>
                                  <td><?php echo e($_page->text_6); ?>:</td>
                                  <td><b><?php echo e($product->Note); ?></b></td>
                              </tr>
                              <tr>
                                  <td><?php echo e($_page->text_7); ?>:</td>
                                  <td><b><?php echo e($product->Sizes); ?></b></td>
                              </tr>
                          </tbody>
                      </table>
                      <div class="cart-footer-actions">
                          <div class="total-amount">
                              <span class="text"><?php echo e($_page->text_10); ?></span><span class="value"><?php echo e(number_format($product->user_price, 2, ',', '')); ?></span>
                          </div>
                          <div class="total-amount">
                            <span class="text"><?php echo e($product->factor_comment); ?></span>
                          </div>
                          <div class="action-buttons">
                              <div class="btn counter-input js_counter-input">
                                  <button type="button" class="counter-input__btn minus js_counter-input-btn"><span></span></button>
                                  <input type="text" name="product-counter" value="1" class="input-quantity">
                                  <button type="button" class="counter-input__btn plus js_counter-input-btn"><span></span></button>
                              </div>
                              <button type="button" class="btn btn-red-small" onclick="__.toCart(<?php echo e($product->Id); ?>, parseInt($(this).siblings().find('.input-quantity').val()))"><?php echo e($_page->text_11); ?></button>
                          </div>
                      </div>
                  </form>
              </div>

          </div>
      </div>
  </section>

  <?php if(isset($product->substitutes) && $product->substitutes): ?>
  <section class="section section-product-analogs animate">
      <div class="page-wrapper">
          <div class="page-container">
              <h3 class="section-title-small"><?php echo e($_page->text_12); ?></h3>
              <div class="analogs-container animate">
                <?php foreach($product->substitutes as $sub): ?>
                  <div class="analog-excerpt animate">
                      <h5 class="code"><?php echo e($sub->Code); ?></h5>
                      <h6 class="title"><?php echo e($sub->producer_name); ?></h6>
                      <a href="<?php echo e(url('products', $sub->Id)); ?>" class="link-more"><?php echo e($_page->text_13); ?></a>
                  </div>
                <?php endforeach; ?>
              </div>
          </div>
      </div>
  </section>
  <?php endif; ?>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>