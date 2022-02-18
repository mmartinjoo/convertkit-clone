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
        getPerformance() {
            return `
                ${this.model.total_performance.total_sent_mails} Recipients •
                ${this.model.total_performance.average_open_rate.formatted} Open rate •
                ${this.model.total_performance.average_click_rate.formatted} Click rate
            `;
        },
    }
}
</script>

<template>
    <Head title="Sequence" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ model.sequence.title }}
            </h2>
            {{ getPerformance() }}
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Subject
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Recipients
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Average Open Rate
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Average Click Rate
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                <tr v-for="mail in model.sequence.mails" :key="mail.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ mail.subject }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ model.mail_performances[mail.id].total_sent_mails }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ model.mail_performances[mail.id].average_open_rate.formatted }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ model.mail_performances[mail.id].average_click_rate.formatted }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
