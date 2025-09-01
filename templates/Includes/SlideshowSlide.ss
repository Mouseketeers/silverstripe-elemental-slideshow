<div class="slideshow-slide" data-slide="{$ID}" role="group" aria-label="Slide {$Pos}">
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