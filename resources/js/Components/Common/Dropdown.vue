<template>
    <div class="relative">
        <div @click="open = !open">
            <slot name="trigger" />
        </div>
        
        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div v-show="open" class="absolute z-50 mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                :class="alignmentClass"
                @click="open = false"
            >
                <div class="py-1">
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    align: { type: String, default: 'right' },
    width: { type: String, default: '48' },
});

const open = ref(false);

const alignmentClass = computed(() => {
    if (props.align === 'left') return 'left-0';
    if (props.align === 'right') return 'right-0';
    return 'left-0';
});

const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));
</script>
