<% require css('mouseketeers/elemental-slideshow:client/dist/css/slideshow.css') %>
<% require javascript('mouseketeers/elemental-slideshow:client/dist/js/slideshow.js') %>

<div class="element__container">
    <div class="element__item-container">
        <div class="element__content-container">
        <% if $Title && $ShowTitle %>
            <h2 class="element__title">$Title</h2>
        <% end_if %>
        <% if $HTML %>
            <div class="element__content">$HTML</div>
        <% end_if %>
        </div>
    </div>
    <div class="element__item-container">
            <% if $SlideshowSlides %>
                <div class="slideshow-container swiper" data-slideshow="{$ID}">
                    <div class="slideshow-wrapper swiper-wrapper">
                        <% loop $SlideshowSlides %>
                            <div class="swiper-slide">
                                <div class="slideshow-slide" data-slide="{$ID}" role="group" aria-label="Slide {$Pos}" >
                                    <% if $Image %>
                                        <div class="slide__image">
                                            <% if $Link %>
                                                <a href="$Link.URL" <% if $Link.OpenInNew %>target="_blank" rel="noopener"<% end_if %> aria-label="$Title.ATT">
                                                    $Image.ScaleMaxWidth(1800)
                                                </a>
                                            <% else %>
                                                $Image.ScaleMaxWidth(1800)
                                            <% end_if %>
                                        </div>
                                    <% end_if %>
                                    
                                    <% if $Title || $Content %>
                                        <div class="slide__content">
                                            <% if $Title %>
                                                <h3 class="slide__title">$Title</h3>
                                            <% end_if %>
                                            
                                            <% if $Content %>
                                                <div class="slide__text">$Content</div>
                                            <% end_if %>
                                            
                                            <% if $Link && not $Image %>
                                                <div class="slide__link">
                                                    <a href="$Link.URL" class="btn" <% if $Link.OpenInNew %>target="_blank" rel="noopener"<% end_if %>>
                                                        $Link.Title
                                                    </a>
                                                </div>
                                            <% end_if %>
                                        </div>
                                    <% end_if %>
                                </div>
                            </div>
                        <% end_loop %>
                    </div>
                    <% if $SlideshowSlides.Count > 1 %>
                        <div class="slideshow-controls">
                            <button class="slideshow-prev swiper-button-prev" aria-label="Previous slide"></button>
                            <button class="slideshow-next swiper-button-next" aria-label="Next slide"></button>
                        </div>
                        <div class="slideshow-pagination swiper-pagination"></div>
                    <% end_if %>
                </div>
            <% end_if %>
        </div>
    </div>
</div>