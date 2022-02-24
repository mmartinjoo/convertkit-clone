<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import FiltersShow from "@/Components/Filter/Show";
import PerformanceLine from "@/Components/Mail/PerformanceLine";

export default {
    components: {
        FiltersShow,
        BreezeAuthenticatedLayout,
        Head,
        Link,
        PerformanceLine,
    },
    props: {
        model: {
            type: Object,
            required: true,
        },
    },
    methods: {
        remove() {
            this.$inertia.delete(`/broadcasts/${this.model.broadcast.id}`);
        },
        send() {
            this.$inertia.patch(`/broadcasts/${this.model.broadcast.id}/send`);
        },
        getSelectedTags() {
            return this.model.tags.filter(tag => this.model.broadcast.filters.tag_ids.includes(tag.id));
        },
        getSelectedForms() {
            return this.model.forms.filter(form => this.model.broadcast.filters.form_ids.includes(form.id));
        },
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
            <PerformanceLine v-if="model.broadcast.status === 'sent'" :performance="model.performance"></PerformanceLine>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <div v-html="model.broadcast.content" class="mb-6"></div>

            <FiltersShow :tags="getSelectedTags()" :forms="getSelectedForms()" />
            <button v-if="model.broadcast.status === 'draft'" @click="remove()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3 mt-6" type="button">
                Delete
            </button>
            <button v-if="model.broadcast.status === 'draft'" @click="send()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                Send
            </button>
        </div>
    </BreezeAuthenticatedLayout>
</template>
