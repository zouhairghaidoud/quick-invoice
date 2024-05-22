<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import { setTheme } from '../theme';

onMounted(() => {
    initFlowbite();
    setTheme();
})
</script>

<template>
    <slot />
</template>
