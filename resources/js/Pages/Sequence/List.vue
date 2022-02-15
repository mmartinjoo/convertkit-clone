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
        getPerformance(sequence) {
            if (sequence.status === 'draft') {
                return '-';
            }

            const performance = this.model.performances[sequence.id];

            return `
                ${performance.total_sent_mails} Recipients •
                ${performance.average_open_rate.formatted} Open rate •
                ${performance.average_click_rate.formatted} Click rate
            `;
        },
        open(sequence) {
            this.$inertia.get(`sequences/${sequence.id}`);
        }
    }
}
</script>

<template>
    <Head title="Sequences" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sequences
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <Link href="/sequences/create" as="button" type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-16 mb-5">
                New Sequence
            </Link>
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        E-Mails
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Performance
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                <tr v-for="sequence in model.sequences" :key="sequence.id" class="hover:bg-gray-100 hover:cursor-pointer" @click="open(sequence)">
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ sequence.title }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ sequence.mails.length }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ sequence.status }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            {{ getPerformance(sequence) }}
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
