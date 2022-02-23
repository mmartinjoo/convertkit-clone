<script>
export default {
    name: 'AutomationStepEventForm',
    props: {
        initEvent: {
            type: Object,
            required: false,
        },
        events: {
            type: Object,
            required: true,
        },
        forms: {
            type: Array,
            required: false,
        },
    },
    data() {
        return {
            event: {
                name: '',
                value: '',
            }
        };
    },
    created() {
        this.event = this.initEvent;
    },
    watch: {
        'event.value': function () {
            this.$emit('changed', this.event);
        },
    },
}
</script>
<template>
    <div>
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mt-4" for="name">
            When a Subscriber
        </label>
        <select name="name" id="name" v-model="event.name" class="appearance-none w-60 bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            <option value="" disabled selected>Select an event</option>
            <option v-for="(name, key) in events" :key="key" :value="key">{{ name }}</option>
        </select>
        <select v-if="event.name" name="value" id="value" v-model="event.value" class="ml-2 appearance-none w-60 bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
            <option value="" disabled selected>Select a value</option>
            <option v-for="item in forms" :key="item.id" :value="item.id">{{ item.title }}</option>
        </select>
    </div>
</template>
