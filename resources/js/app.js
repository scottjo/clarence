import './bootstrap';
import homeVideo from './home-video';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('homeVideo', homeVideo);
});
