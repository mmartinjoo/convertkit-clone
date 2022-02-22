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
            name: '',
            value: '',
        };
    },
    watch: {
        name() {
            this.value = '';
        }
    },
    computed: {
        values() {
            if (this.name.toLowerCase().includes('sequence')) {
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
    <select name="name" id="name" v-model="name">
        <option value="" disabled selected>Select an action</option>
        <option v-for="(name, key) in actions" :key="key" :value="key">{{ name }}</option>
    </select>
    <select v-if="name" name="value" id="value" v-model="value" class="ml-2">
        <option value="" disabled selected>Select a value</option>
        <option v-for="item in values" :key="item.id" :value="item.id">{{ item.title }}</option>
    </select>
</div>
</template>
