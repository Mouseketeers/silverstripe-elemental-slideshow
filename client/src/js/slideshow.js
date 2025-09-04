import { Swiper } from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

document.addEventListener('DOMContentLoaded', function() {
    const slideshows = document.querySelectorAll('.slideshow-container');
    
    slideshows.forEach(function(swiperElement) {
        const wrapper = swiperElement.querySelector('.slideshow-wrapper');
        const slides = wrapper?.querySelectorAll('.slideshow-slide');
        
        // Exit early if structure is invalid
        if (!wrapper || !slides || slides.length === 0) {
            return;
        }
        
        const hasMultipleSlides = slides.length > 1;
        
        // Default configuration
        let config = {
            modules: [Navigation, Pagination, Autoplay],
            slidesPerView: 1,
            spaceBetween: 0,
            loop: hasMultipleSlides,
            navigation: {
                nextEl: swiperElement.querySelector('.slideshow-next'),
                prevEl: swiperElement.querySelector('.slideshow-prev'),
            },
            pagination: {
                el: swiperElement.querySelector('.slideshow-pagination'),
                clickable: true,
            },
        };
        
        // Check for data-swiper attribute with JSON configuration
        if (swiperElement.dataset.swiper) {
            try {
                const customConfig = JSON.parse(swiperElement.dataset.swiper);
                
                // Merge custom config with defaults
                config = {
                    ...config,
                    ...customConfig,
                    // Preserve certain defaults that shouldn't be overwritten completely
                    modules: config.modules,
                    navigation: {
                        ...config.navigation,
                        ...(customConfig.navigation || {})
                    },
                    pagination: {
                        ...config.pagination,
                        ...(customConfig.pagination || {})
                    }
                };
                
                // Handle autoplay separately since it can be boolean or object
                if (customConfig.autoplay === true) {
                    config.autoplay = {
                        delay: 5000,
                        disableOnInteraction: false
                    };
                } else if (typeof customConfig.autoplay === 'object') {
                    config.autoplay = customConfig.autoplay;
                }
                
            } catch (e) {
                console.error('Invalid JSON in data-swiper attribute:', e);
                console.error('Element:', swiperElement);
                console.error('JSON string:', swiperElement.dataset.swiper);
            }
        }
        
        new Swiper(swiperElement, config);
    });
});