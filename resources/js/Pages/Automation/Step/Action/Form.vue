<script>
export default {
    name: 'AutomationStepActionForm',
    props: {
        actions: {
            type: Object,
            required: true,
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
            action: {
                name: '',
                value: '',
            },
        };
    },
    watch: {
        'action.value': function () {
            this.$emit('changed', this.action);
        },
    },
    computed: {
        values() {
            if (this.action.name.toLowerCase().includes('sequence')) {
                return this.sequences;
            }

            return this.tags;
        },
    }
}
</script>
<template>
<div>
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mt-4" for="name">
        Then
    </label>
    <select name="name" id="name" v-model="action.name" class="appearance-none w-60 bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        <option value="" disabled selected>Select an action</option>
        <option v-for="(name, key) in actions" :key="key" :value="key">{{ name }}</option>
    </select>
    <select v-if="action.name" name="value" id="value" v-model="action.value" class="ml-2 appearance-none w-60 bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
        <option value="" disabled selected>Select a value</option>
        <option v-for="item in values" :key="item.id" :value="item.id">{{ item.title }}</option>
    </select>
</div>
</template>
