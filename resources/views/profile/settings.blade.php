@extends('layouts.app')
@section('content')

<main class="page-content">

<div class="page-header-bg animate page-header-bg--profile">
    <div class="page-header-bg__image" style="background-image: url({{ url('/public/img/content/bg2.jpg')  }})"></div>
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_21 }}</h2>
            <div class="ext-balance">
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Debt</span><span class="t-mobile">Debt</span></h5>
                        <span class="ext-balance__val {{ $_user->debt > 0 ? 'red' : '' }}">{{ $_user->debt }}<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Balance</span><span class="t-mobile">Balance</span></h5>
                        <span class="ext-balance__val {{ $_user->balance == 0 ? 'red' : ( $_user->balance < 5000 ? 'yellow' : 'green') }}">{{ $_user->balance }}<span class="currency">&nbsp;€</span></span>
                    </div>
                    <div class="ext-balance__item">
                        <h5 class="ext-balance__title"><span class="t-desktop">Deposit Available</span><span class="t-mobile">Deposit Available</span></h5>
                        <span class="ext-balance__val {{ $_user->deposit_available == 0 ? 'red' : '' }}">{{ $_user->deposit_available }}<span class="currency">&nbsp;€</span></span>
                    </div>
            </div>
        </div>
    </div> 
</div>

<!-- Section Profile -->
<section class="section section--content-inner section-profile animate">
    <div class="page-wrapper">
        <div class="page-container">

            @include('elements.profilemenu')

            <h3 class="section-title-small">{{ $_page->text_1 }}</h3>
            <div class="section-text">
                {{ $_page->text_2 }}
            </div>

            <div class="profile-form-container">
                <form class="form-style form-style--dark form-disabled">
                    <div class="tabs-toggler">
                        <div class="tabs-toggler__container">
                            <button type="button" class="btn btn-left js_form-cancel active">{{ $_page->text_3 }}<span class="rectangle"></span></button>
                            <div class="bridge"></div>
                            <button type="button" class="btn btn-right js_form-edit">{{ $_page->text_4 }}</span><span class="rectangle"></span></button>
                        </div>
                    </div>

                    <div class="fields-container">

                        <div class="fields-row fields-row--2">
                            <label class="col field-block">
                                <span class="field-block__title">{{ $_page->text_5 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled readonly type="text" id="profile-login" name="profile-login" value="{{ $user->login }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_22 }}</span>
                            </label>
                            <label class="col field-block field-block--button">
                                <span class="field-block__title">{{ $_page->text_6 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled readonly type="text" id="profile-password" name="profile-password" value="******">
                                    <span class="appearance"><span></span></span>
                                    <button type="button" class="btn btn-field-refresh icon icon-refresh" onclick="document.location.href='{{ url('/profile/security') }}'"></button>
                                </span>
                                <span class="error-message">{{ $_page->text_23 }}</span>
                            </label>
                        </div>

                        <div class="fields-row fields-row--2">
                            <label class="col field-block">
                                <span class="field-block__title">{{ $_page->text_7 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-name" name="profile-name" value="{{ $user->fname }}" data-buffer="{{ $user->fname }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_24 }}</span>
                            </label>

                            <label class="col field-block">
                                <span class="field-block__title">{{ $_page->text_8 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-surname" name="profile-surname" value="{{ $user->lname }}" data-buffer="{{ $user->lname }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_25 }}</span>
                            </label>
                        </div>

                        <div class="fields-row">
                            <label class="col field-block">
                                <span class="field-block__title">{{ $_page->text_9 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-company" name="profile-company" value="{{ $user->company }}" data-buffer="{{ $user->company }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_26 }}</span>
                            </label>
                        </div>

                        <div class="fields-row">
                            <label class="col field-block">
                                <span class="field-block__title">{{ $_page->text_10 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-street" name="profile-street" value="{{ $user->street }}" data-buffer="{{ $user->street }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_27 }}</span>
                            </label>
                        </div>

                        <div class="fields-row fields-row--3">
                            <label class="col col-big field-block">
                                <span class="field-block__title">{{ $_page->text_11 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-town" name="profile-town" value="{{ $user->town }}" data-buffer="{{ $user->town }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_28 }}</span>
                            </label>

                            <label class="col col-small field-block">
                                <span class="field-block__title">{{ $_page->text_12 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-zip" name="profile-zip" value="{{ $user->zip }}" data-buffer="{{ $user->zip }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_29 }}</span>
                            </label>

                            <label class="col col-big field-block field-block--list">
                                <span class="field-block__title">{{ $_page->text_13 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-country" name="profile-country" value="{{ $user->country_name }}" data-buffer="{{ $user->country_name }}"  data-value="{{ $user->country }}">
                                    <span class="appearance"><span></span></span>
                                    <div class="field-list">
                                        <ul>
                                          @foreach($countries as $country)
                                            <li><a href="" class="element" data-value="{{ $country->id }}">{{ $country->name }}</a></li>
                                          @endforeach
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-field-list icon icon-arrow-down2"></button>
                                </span>
                                <span class="error-message">{{ $_page->text_30 }}</span>
                            </label>
                        </div>

                        <div class="fields-row fields-row--3">
                            <label class="col col-small field-block">
                                <span class="field-block__title">{{ $_page->text_14 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="tel" id="profile-telephone" name="profile-telephone" value="{{ $user->phone }}" data-buffer="{{ $user->phone }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_31 }}</span>
                            </label>

                            <label class="col col-big field-block">
                                <span class="field-block__title">{{ $_page->text_15 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="email" id="profile-email" name="profile-email" value="{{ $user->email }}" data-buffer="{{ $user->email }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_32 }}</span>
                            </label>

                            <label class="col col-big field-block">
                                <span class="field-block__title">{{ $_page->text_16 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-website" name="profile-website" value="{{ $user->website }}" data-buffer="{{ $user->website }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_33 }}</span>
                            </label>
                        </div>

                        <div class="fields-row fields-row--2">
                            <label class="col field-block">
                                <span class="field-block__title">{{ $_page->text_17 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-turnover" name="profile-turnover" value="{{ $user->turnover }}" data-buffer="{{ $user->turnover }}">
                                    <span class="appearance"><span></span></span>
                                </span>
                                <span class="error-message">{{ $_page->text_34 }}</span>
                            </label>

                            <label class="col field-block field-block--list">
                                <span class="field-block__title">{{ $_page->text_18 }}</span>
                                <span class="field-block__input-container">
                                    <input disabled type="text" id="profile-account" name="profile-account" value="{{ $user->profile }}" data-buffer="{{ $user->profile }}">
                                    <span class="appearance"><span></span></span>
                                    <div class="field-list">
                                        <ul>
                                          @foreach($profiles as $profile)
                                              <li><a href="" class="element">{{ $profile }}</a></li>
                                          @endforeach
                                        </ul>
                                    </div>
                                    <button type="button" class="btn btn-field-list icon icon-arrow-down2"></button>
                                </span>
                                <span class="error-message">{{ $_page->text_35 }}</span>
                            </label>
                        </div>

                    </div>

                    <div class="form-footer">
                        <div class="form-message icon icon-attention message-error" style="visibility:hidden;display:block;" data-default="{{ $_page->text_36 }}">
                            {{ $_page->text_36 }}
                        </div>
                        <div class="form-message icon icon-success message-success" style="visibility:hidden;display:block;" data-default="{{ $_page->text_37 }}">
                            {{ $_page->text_37 }}
                        </div>
                        <div class="action-buttons js_actions-save">
                            <button type="button" class="btn btn-grey js_form-cancel" onclick="__.discardChanges(event)">{{ $_page->text_19 }}</button>
                            <button type="button" class="btn btn-red js_form-save" onclick="__.saveChanges(event)">{{ $_page->text_20 }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

</main>

<script>

  window.onload = function() {
    // Keyboard ESC close modal trigger
    $(document).on('keyup', function(e) {
        var params = {};
        if (e.which == 27) {
            $('.field-block.field-list-active').removeClass('field-list-active');
        }
    });
    // Field list search
    $('.field-block--list input').on('input change paste propertychange', function(e) {
        var val = $(this).val();
            fieldBlock = $(this).closest('.field-block'),
            list = fieldBlock.find('.field-list'),
            listElements = list.find('li');

        listElements.removeClass('hidden').each(function() {
            if ($(this).find('a').text().trim().toLowerCase().indexOf(val.toLowerCase()) !== 0) $(this).addClass('hidden');
        });

        fieldBlock.addClass('field-list-active');

    });

    // Form logic
    $('.js_form-edit').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form'),
            tabsToggler = form.find('.tabs-toggler');

        form.removeClass('form-disabled').find('input[disabled]').prop("disabled", false).first().focus();
        form.find('.js_actions-save').addClass('active');
        tabsToggler.find('.btn').removeClass('active').filter('.js_form-edit').addClass('active');
        if (!clientInfo.mobile) {
            $('html, body').animate({ scrollTop: form.find('input').first().offset().top - cs.winHeight/3.8 }, 400);
        } else {
            $('html, body').animate({ scrollTop: form.find('input').first().offset().top - cs.winHeight/3.8 }, 0);
        }
    });
    $('.js_form-cancel').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form'),
            tabsToggler = form.find('.tabs-toggler');

        form.addClass('form-disabled').find('input').prop("disabled", true).blur();
        form.find('.js_actions-save').removeClass('active');
        tabsToggler.find('.btn').removeClass('active').filter('.js_form-cancel').addClass('active');
    });
  };

</script>

@endsection
