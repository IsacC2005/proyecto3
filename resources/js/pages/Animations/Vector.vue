<template>
    <div id="app">

        <vue-particles id="tsparticles" @particles-loaded="particlesLoaded" :options="{

            fpsLimit: 120,
            interactivity: {
                events: {
                    onClick: {
                        enable: false,
                        mode: 'bubble'
                    },
                    onHover: {
                        enable: true,
                        mode: 'grab'
                    },
                },
                modes: {
                    grab: {
                        distance: 100, links: {
                            blink: false, consent: false, opacity: 1, color
                                : { value: '#06402B' }
                        }
                    }
                    , bubble: { distance: 400, duration: 10, opacity: 0.8, size: 100 }, push: {
                        quantity: 400
                    }, repulse: { distance: 100, duration: 0.4 }
                }
            }, particles: {
                color: { value: '#06402B' },
                links: { color: '#06402B', distance: 180, enable: true, opacity: 0.5, width: 0.8 }, move: {
                    direction: 'none', enable: true, outModes: 'out', random: false, speed: 1, straight: false
                }, number: {
                    density: { enable: false, }, value: 80
                }, opacity: { value: 0.5 }, shape: { type: 'circle' }, size: {
                    value:
                        { min: 2, max: 3 }
                }
            }, detectRetina: true
        }" />
    </div>
</template>

<script setup lang="ts">

import Particles from '@tsparticles/vue3';


const particlesLoaded = async container => {
    console.log("Particles container loaded", container);
};
</script>

<style scoped>
#tsparticles {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
}

.content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: white;
}
</style>