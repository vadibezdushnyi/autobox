<?php $__env->startSection('content'); ?>

<main class="page-content">


<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url(<?php echo e(url('/public/img/content/bg2.jpg')); ?>)"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title"><?php echo e($_page->text_1); ?></h2>
            <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val <?php echo e($_user->debt > 0 ? 'red' : ''); ?>"><?php echo e($_user->debt); ?><span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val <?php echo e($_user->balance == 0 ? 'red' : ( $_user->balance < 5000 ? 'yellow' : 'green')); ?>"><?php echo e($_user->balance); ?><span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val <?php echo e($_user->deposit_available == 0 ? 'red' : ''); ?>"><?php echo e($_user->deposit_available); ?><span class="currency">&nbsp;€</span></span>
                    </div>
            </div>
        </div>
    </div> 
</div>

<!-- Section Profile -->
<section class="section section--content-inner section-profile animate">
    <div class="page-wrapper">
        <div class="page-container">

            <?php echo $__env->make('elements.profilemenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <h3 class="section-title-small"><?php echo e($_page->text_2); ?></h3>
            <div class="section-text">
              <?php echo e($_page->text_3); ?>

            </div>

            <div class="profile-form-container">
              <div class="content">
                <form class="form-style form-style--dark">
                    <div class="fields-container">

                        <div class="fields-row fields-row--2">
                            <label class="col field-block">
                                <span class="field-block__title"><?php echo e($_page->text_4); ?></span>
                                <span class="field-block__input-container">
                                    <input type="password" id="password-old" name="password-old" value="">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message"><?php echo e($_page->text_5); ?></span>
                            </label>
                            <label class="col field-block">
                                <span class="field-block__title"><?php echo e($_page->text_6); ?></span>
                                <span class="field-block__input-container">
                                    <input type="password" id="password-new" name="password-new" value="">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message"><?php echo e($_page->text_7); ?></span>
                            </label>
                        </div>

                        <div class="fields-row fields-row--2 fields-row--right-align">
                            <label class="col field-block">
                                <span class="field-block__title"><?php echo e($_page->text_8); ?></span>
                                <span class="field-block__input-container">
                                    <input type="password" id="password-new-confirm" name="password-new-confirm" value="">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message"><?php echo e($_page->text_9); ?></span>
                            </label>
                        </div>

                    </div>

                    <div class="form-footer form-footer--half">
                        <div class="col-2">
                            <div class="form-message icon icon-attention message-error active" style="display: none;">
                                <?php echo e($_page->text_10); ?>

                            </div>
                            <div class="form-message icon icon-success message-success active" style="display: none;">
                                <?php echo e($_page->text_11); ?>

                            </div>
                            <div class="col-full col-full--btn-wide">
                                <button type="button" class="btn btn-red-small" onclick="__.passwordRecovery();"><?php echo e($_page->text_12); ?></button>
                                <div class="message-container">
                                    <div class="message"><?php echo e($_page->text_13); ?></div>
                                </div>
                            </div>
                        </div>

                    </div>


                </form>
              </div>
            </div>

        </div>
    </div>
</section>


</main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>