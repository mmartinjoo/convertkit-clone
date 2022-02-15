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
        remove() {
            this.$inertia.delete(`/sequences/${this.model.sequence.id}`);
        },
        publish() {
            this.$inertia.patch(`/sequences/${this.model.sequence.id}/publish`);
        },
        getPerformance() {
            return `
                ${this.model.performance.total_sent_mails} Recipients •
                ${this.model.performance.average_open_rate.formatted} Open rate •
                ${this.model.performance.average_click_rate.formatted} Click rate
            `;
        },
    },
}
</script>

<template>
    <Head title="Sequence" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ model.sequence.title }}

                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 mb-4 text-xs font-bold leading-none text-white bg-blue-400 rounded-full">
                    {{ model.sequence.status }}
                </span>
            </h2>
            <div v-if="model.sequence.status === 'sent'" class="text-sm text-gray-900">
                {{ getPerformance() }}
            </div>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <button @click="remove()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3 mt-6" type="button">
                Delete
            </button>
            <button v-if="model.sequence.status === 'draft'" @click="publish()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                Publish
            </button>
        </div>
    </BreezeAuthenticatedLayout>
</template>
