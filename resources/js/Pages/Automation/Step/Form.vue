<script>
export default {
    name: 'AutomationStepForm',
    props: {
        type: {
            type: String,
            required: true,
        },
        events: {
            type: Array,
            required: true,
        },
        actions: {
            type: Array,
            required: true,
        },
        forms: {
            type: Array,
            required: false,
        },
        sequences: {
            type: Array,
            required: false,
        },
        tags: {
            type: Array,
            required: false,
        },
    },
    data() {
        return {
            name: null,
            value: null,
        };
    },
    computed: {
        names() {
            return this.type === 'event'
                ? this.events
                : this.actions;
        }
    }
}
</script>
<template>
<div>
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
        Name
    </label>
    <select name="name" id="name">
        <option v-for="name in names" :key="name" :value="name">{{ name }}</option>
    </select>
</div>
</template>
