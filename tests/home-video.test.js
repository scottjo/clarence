import { test } from 'node:test';
import assert from 'node:assert/strict';
import homeVideo from '../resources/js/home-video.js';

test('video loads on visibility, respects pause and motion preferences, and cleans up', async () => {
    let observe;
    let motionChange;
    let disconnected = false;
    const motion = {
        matches: false,
        addEventListener: (_, callback) => { motionChange = callback; },
        removeEventListener: () => { motionChange = null; },
    };
    globalThis.window = { matchMedia: () => motion };
    globalThis.document = { hidden: false };
    globalThis.IntersectionObserver = class {
        constructor(callback) { observe = callback; }
        observe() {}
        disconnect() { disconnected = true; }
    };
    let plays = 0;
    const video = {
        dataset: { src: '/club.mp4' },
        getAttribute() { return this.src; },
        async play() { plays++; state.playing = true; },
        pause() { state.playing = false; },
    };
    const state = homeVideo();
    state.$refs = { video };
    state.init();
    assert.equal(video.src, undefined);
    observe([{ isIntersecting: true }]);
    assert.equal(video.src, '/club.mp4');
    assert.equal(video.muted, true);
    assert.equal(plays, 1);
    state.toggle();
    observe([{ isIntersecting: false }]);
    observe([{ isIntersecting: true }]);
    assert.equal(plays, 1);
    state.toggle();
    assert.equal(plays, 2);
    document.hidden = true;
    state.syncPlayback();
    assert.equal(state.playing, false);
    document.hidden = false;
    motion.matches = true;
    motionChange();
    observe([{ isIntersecting: true }]);
    assert.equal(plays, 2);
    state.toggle();
    assert.equal(plays, 3);
    observe([{ isIntersecting: false }]);
    assert.equal(state.playing, false);
    video.play = async () => { throw new Error('Autoplay blocked'); };
    await state.play();
    assert.equal(state.playing, false);
    state.destroy();
    assert.equal(disconnected, true);
    assert.equal(motionChange, null);
});
