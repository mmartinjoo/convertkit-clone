<script>
export default {
    name: 'PerformanceLine',
    props: {
        performance: {
            type: Object,
            required: true,
        },
        label: {
            type: String,
            required: false,
            default: 'Recipients'
        }
    },
}
</script>
<template>
    <div class="text-sm text-gray-900">
        {{ performance.total }} {{ label }} • {{ performance.open_rate.formatted }} Open rate • {{ performance.click_rate.formatted }} Click rate
    </div>
</template>
