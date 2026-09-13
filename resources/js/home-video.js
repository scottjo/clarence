export default function homeVideo() {
    let observer;
    let motion;
    let onMotionChange;

    return {
        playing: false,
        visible: false,
        pausedByUser: false,
        reducedMotion: false,
        init() {
            motion = window.matchMedia('(prefers-reduced-motion: reduce)');
            this.reducedMotion = motion.matches;
            onMotionChange = () => {
                this.reducedMotion = motion.matches;
                this.syncPlayback();
            };
            motion.addEventListener('change', onMotionChange);
            observer = new IntersectionObserver(([entry]) => {
                this.visible = entry.isIntersecting;
                this.syncPlayback();
            }, { threshold: 0.25 });
            observer.observe(this.$refs.video);
        },
        async play() {
            const video = this.$refs.video;
            if (!video.getAttribute('src')) {
                video.src = video.dataset.src;
            }
            video.muted = true;
            try {
                await video.play();
            } catch {
                this.playing = false;
            }
        },
        syncPlayback() {
            if (this.visible && !document.hidden && !this.pausedByUser && !this.reducedMotion) {
                this.play();
            } else {
                this.$refs.video.pause();
            }
        },
        toggle() {
            if (this.playing) {
                this.pausedByUser = true;
                this.$refs.video.pause();
            } else {
                this.pausedByUser = false;
                this.play();
            }
        },
        destroy() {
            observer?.disconnect();
            motion?.removeEventListener('change', onMotionChange);
            this.$refs.video.pause();
        },
    };
}
