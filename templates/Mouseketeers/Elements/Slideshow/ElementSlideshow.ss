<% if $Title && $ShowTitle %>
    <h2 class="element__title">$Title</h2>
<% end_if %>

<% if $Content %>
    <div class="element__content">$Content</div>
<% end_if %>

<% if $SlideshowSlides %>
    <div class="slideshow-container" data-slideshow="{$ID}">
        <div class="slideshow-wrapper">
            <% loop $SlideshowSlides %>
                <% include SlideshowSlides %>
            <% end_loop %>
        </div>
        
        <% if $SlideshowSlides.Count > 1 %>
            <div class="slideshow-controls">
                <button class="slideshow-prev" aria-label="Previous slide">&larr;</button>
                <button class="slideshow-next" aria-label="Next slide">&rarr;</button>
            </div>
            
            <div class="slideshow-indicators">
                <% loop $SlideshowSlides %>
                    <button class="slideshow-indicator" data-slide="{$Pos}" aria-label="Go to slide {$Pos}"></button>
                <% end_loop %>
            </div>
        <% end_if %>
    </div>
<% end_if %>