@extends('layouts.app')
@section('content')
<main class="page-content">


<!-- Section Team -->
<section class="section section--content  section-team animate">
    <div class="page-wrapper">
        <div class="page-container">
            <h2 class="page-title">{{ $_page->text_1 }}</h2>
            <h3 class="section-title-small animatable">{{ $_page->text_2 }}</h3>
            <div class="section-text animatable">
                {{ $_page->text_3 }}
            </div>

            <div class="team-container">
                <h3 class="section-title-small section-title-small--red">{{ $_page->text_4 }}</h3>

                <div class="tripple-container animate">
                  @foreach($teammates[0] as $member)
                    <div class="excerpt team-member-excerpt animate">
                        <div class="team-member-excerpt__header">
                            <div class="image" style="background-image: url('{{ url('/public/img/content/'.$member->cover) }}')"></div>
                            <div class="info">
                                <h4 class="title">{{ $member->name }}</h4>
                                <span class="position">{{ $member->position }}</span>
                            </div>
                        </div>
                        <div class="team-member-excerpt__contacts js_team-member-contacts">
                          @if(strlen($member->phone_1))
                            <a href="tel:{{ $member->phone_1 }}" class="person-contact"><span class="icon icon-telephone2"></span>{{ $member->phone_1 }}</a>
                          @endif
                          @if(strlen($member->phone_2))
                            <a href="tel:{{ $member->phone_2 }}" class="person-contact"><span class="icon icon-telephone2"></span>{{ $member->phone_2 }}</a>
                          @endif
                          @if(strlen($member->phone_3))
                            <a href="tel:{{ $member->phone_3 }}" class="person-contact"><span class="icon icon-telephone2"></span>{{ $member->phone_3 }}</a>
                          @endif
                          @if(strlen($member->fax))
                            <a href="tel:{{ $member->fax }}" class="person-contact"><span class="icon icon-fax"></span>{{ $member->fax }}</a>
                          @endif
                          @if(strlen($member->email))
                            <a href="mailto:{{ $member->email }}" class="person-contact"><span class="icon icon-mail"></span>{{ $member->email }}</a>
                          @endif
                        </div>
                        <div class="team-member-excerpt__socials">
                            <div class="social-links-simple">
                              @if(strlen(trim($member->fb_link)))
                                <a href="{{ $member->fb_link }}" class="social-link link-facebook">
                                    <span class="icon icon-facebook"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->tw_link)))
                                <a href="{{ $member->tw_link }}" class="social-link link-twitter">
                                    <span class="icon icon-twitter"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->ins_link)))
                                <a href="{{ $member->ins_link }}" class="social-link link-instagram">
                                    <span class="icon icon-instagram"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->sk_link)))
                                <a href="skype:{{ $member->sk_link }}?call" class="social-link link-skype">
                                    <span class="icon icon-skype"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->in_link)))
                                <a href="{{ $member->in_link }}" class="social-link link-linkedin">
                                    <span class="icon icon-linkedin"></span>
                                </a>
                              @endif
                            </div>
                        </div>
                        <div class="team-member-excerpt__languages">
                            <div class="contact-languages">
                              @foreach(json_decode($member->languages) as $language)
                                <span class="language"><img src="{{ url('/public/img/icons-general/flags/', $language->logo) }}" alt="{{ $language->name_s }}">{{ $language->name }}</span>
                              @endforeach
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>

            </div>


            <div class="team-container">
                <h3 class="section-title-small section-title-small--red">{{ $_page->text_5 }}</h3>

                <div class="tripple-container animate">
                  @foreach($teammates[1] as $member)
                    <div class="excerpt team-member-excerpt animate">
                        <div class="team-member-excerpt__header">
                            <div class="image" style="background-image: url('{{ url('/public/img/content/'.$member->cover) }}')"></div>
                            <div class="info">
                                <h4 class="title">{{ $member->name }}</h4>
                                <span class="position">{{ $member->position }}</span>
                            </div>
                        </div>
                        <div class="team-member-excerpt__contacts js_team-member-contacts">
                          @if(strlen($member->phone_1))
                            <a href="tel:{{ $member->phone_1 }}" class="person-contact"><span class="icon icon-telephone2"></span>{{ $member->phone_1 }}</a>
                          @endif
                          @if(strlen($member->phone_2))
                            <a href="tel:{{ $member->phone_2 }}" class="person-contact"><span class="icon icon-telephone2"></span>{{ $member->phone_2 }}</a>
                          @endif
                          @if(strlen($member->phone_3))
                            <a href="tel:{{ $member->phone_3 }}" class="person-contact"><span class="icon icon-telephone2"></span>{{ $member->phone_3 }}</a>
                          @endif
                          @if(strlen($member->fax))
                            <a href="tel:{{ $member->fax }}" class="person-contact"><span class="icon icon-fax"></span>{{ $member->fax }}</a>
                          @endif
                          @if(strlen($member->email))
                            <a href="mailto:{{ $member->email }}" class="person-contact"><span class="icon icon-mail"></span>{{ $member->email }}</a>
                          @endif
                        </div>
                        <div class="team-member-excerpt__socials">
                            <div class="social-links-simple">
                              @if(strlen(trim($member->fb_link)))
                                <a href="{{ $member->fb_link }}" class="social-link link-facebook">
                                    <span class="icon icon-facebook"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->tw_link)))
                                <a href="{{ $member->tw_link }}" class="social-link link-twitter">
                                    <span class="icon icon-twitter"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->ins_link)))
                                <a href="{{ $member->ins_link }}" class="social-link link-instagram">
                                    <span class="icon icon-instagram"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->sk_link)))
                                <a href="skype:{{ $member->sk_link }}?call" class="social-link link-skype">
                                    <span class="icon icon-skype"></span>
                                </a>
                              @endif
                              @if(strlen(trim($member->in_link)))
                                <a href="{{ $member->in_link }}" class="social-link link-linkedin">
                                    <span class="icon icon-linkedin"></span>
                                </a>
                              @endif
                            </div>
                        </div>
                        <div class="team-member-excerpt__languages">
                            <div class="contact-languages">
                              @foreach(json_decode($member->languages) as $language)
                                <span class="language"><img src="{{ url('/public/img/icons-general/flags/', $language->logo) }}" alt="{{ $language->name_s }}">{{ $language->name }}</span>
                              @endforeach
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>

            </div>

        </div>
    </div>
</section>


</main>
@endsection
