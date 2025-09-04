<% require css('mouseketeers/elemental-slideshow:client/dist/css/slideshow.css') %>
<% require javascript('mouseketeers/elemental-slideshow:client/dist/js/slideshow.js') %>

<% cached 'element', $ID, $LastEdited %>
<div class="element__container">
    <div class="element__item-container">
        <% include ElementTitleAndContent %>
    </div>
</div>
<div class="element__container">
    <div class="element__item-container">
        <div class="element__item">
            <% if $SlideshowSlides %>
                <div class="slideshow-container swiper" 
                    data-slideshow="{$ID}"
                    data-swiper='{
                        "slidesPerView": 1.2,
                        "spaceBetween": 30,
                        "breakpoints": {
                            "1024": {
                                "slidesPerView": 2.2,
                                "spaceBetween": 20
                            }
                        }                        
                    }'>
                    <div class="slideshow-wrapper swiper-wrapper">
                        <% loop $SlideshowSlides %>
                            <div class="swiper-slide">
                                <div class="slideshow-slide" data-slide="{$ID}" role="group" aria-label="Slide {$Pos}" >
                                    <% if $Image %>
                                        <div class="slide__image">
                                            <% if $Link %>
                                                <a href="$Link.URL" <% if $Link.OpenInNew %>target="_blank" rel="noopener"<% end_if %> aria-label="$Title.ATT">
                                                    $Image.ScaleWidth(800)
                                                </a>
                                            <% else %>
                                                $Image.ScaleWidth(800)
                                            <% end_if %>
                                        </div>
                                    <% end_if %>
                                    <% if $Title || $Content %>
                                        <div class="slide__content">
                                            <% if $Title %>
                                                <h4 class="slide__title">$Title</h4>
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
                    <% end_if %>
                </div>
            <% end_if %>
        </div>
    </div>
</div>
<% end_cached %>