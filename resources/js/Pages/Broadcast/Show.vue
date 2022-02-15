<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },
    props: {
        model: {
            type: Object,
            required: true,
        },
    },
    methods: {
        filters() {
            const formIds = this.model.broadcast.filters
                .filter(filter => filter.type === 'form')
                .flatMap(filter => filter.value);

            const tagIds = this.model.broadcast.filters
                .filter(filter => filter.type === 'tag')
                .flatMap(filter => filter.value);

            return {
                formIds,
                tagIds,
            };
        },
        tagTitle(id) {
            return this.model.tags.find(tag => tag.id === id).title;
        },
        formTitle(id) {
            return this.model.forms.find(form => form.id === id).title;
        },
        remove() {
            this.$inertia.delete(`/broadcasts/${this.model.broadcast.id}`);
        },
        send() {
            this.$inertia.patch(`/broadcasts/${this.model.broadcast.id}/send`);
        }
    },
}
</script>

<template>
    <Head title="Broadcast" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ model.broadcast.subject }}
                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 mb-4 text-xs font-bold leading-none text-white bg-blue-400 rounded-full">
                    {{ model.broadcast.status }}
                </span>
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <div v-html="model.broadcast.content" class="mb-6"></div>

            <div v-if="filters().formIds.length">
                Form filters:
                <span v-for="formId in filters().formIds" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-gray-400 rounded-full">
                    {{ formTitle(formId) }}
                </span>
            </div>
            <div v-if="filters().tagIds.length">
                Tag filters:
                <span v-for="tagId in filters().tagIds" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-blue-400 rounded-full">
                    {{ formTitle(tagId) }}
                </span>
            </div>

            <button v-if="model.broadcast.status === 'draft'" @click="remove()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3 mt-6" type="button">
                Delete
            </button>
            <button v-if="model.broadcast.status === 'draft'" @click="send()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                Send
            </button>
        </div>
    </BreezeAuthenticatedLayout>
</template>
