<script>
export default {
    name: 'AutomationStepForm',
    props: {
        type: {
            type: String,
            required: true,
        },
        events: {
            type: Object,
            required: true,
        },
        actions: {
            type: Object,
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
            name: '',
            value: '',
        };
    },
    computed: {
        names() {
            return this.type === 'event'
                ? this.events
                : this.actions;
        },
        values() {
            if (this.type === 'event') {
                return this.forms;
            }

            if (this.name.toLowerCase().includes('sequence')) {
                return this.sequences;
            }

            return this.tags;
        },
        nameLabel() {
            return this.type === 'event'
                ? 'When a Subscriber'
                : 'Then';
        }
    }
}
</script>
<template>
<div>
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mt-4" for="name">
        {{ nameLabel }}
    </label>
    <select name="name" id="name" v-model="name">
        <option value="" disabled selected>Select an {{ this.type }}</option>
        <option v-for="(name, key) in names" :key="key" :value="key">{{ name }}</option>
    </select>
    <select v-if="name" name="value" id="value" v-model="value" class="ml-2">
        <option value="" disabled selected>Select a value</option>
        <option v-for="item in values" :key="item.id" :value="item.id">{{ item.title }}</option>
    </select>
</div>
</template>
