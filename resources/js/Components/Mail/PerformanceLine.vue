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
        {{ performance.total }} {{ label }} • {{ performance.average_open_rate.formatted }} Open rate • {{ performance.average_click_rate.formatted }} Click rate
    </div>
</template>
