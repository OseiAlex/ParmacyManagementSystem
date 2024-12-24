<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="rounded-sm w-5 h-5 border-gray-400 text-purple-600 shadow-sm focus:ring-purple-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-purple-600 dark:focus:ring-offset-gray-800"
    />
</template>
