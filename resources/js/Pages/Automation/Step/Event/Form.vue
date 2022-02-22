<script>
export default {
    name: 'AutomationStepEventForm',
    props: {
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
            name: '',
            value: '',
        };
    },
    watch: {
        name() {
            this.value = '';
        }
    },
}
</script>
<template>
    <div>
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mt-4" for="name">
            When a Subscriber
        </label>
        <select name="name" id="name" v-model="name">
            <option value="" disabled selected>Select an event</option>
            <option v-for="(name, key) in events" :key="key" :value="key">{{ name }}</option>
        </select>
        <select v-if="name" name="value" id="value" v-model="value" class="ml-2">
            <option value="" disabled selected>Select a value</option>
            <option v-for="item in forms" :key="item.id" :value="item.id">{{ item.title }}</option>
        </select>
    </div>
</template>
