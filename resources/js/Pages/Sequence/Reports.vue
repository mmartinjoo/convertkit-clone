<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import PerformanceLine from "@/Components/Mail/PerformanceLine";

export default {
    components: {
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
}
</script>

<template>
    <Head title="Sequence Reports" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ model.sequence.title }}
            </h2>
            <PerformanceLine :performance="model.total_performance" label="Subscribers"></PerformanceLine>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <div class="sm:px-6 lg:px-8 grid grid-cols-3 gap-2 mb-10">
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Total Subscribers</p>
                    <div class="text-xl font-medium text-black">{{ model.progress.total }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">In Progress</p>
                    <div class="text-xl font-medium text-black">{{ model.progress.in_progress }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Completed</p>
                    <div class="text-xl font-medium text-black">{{ model.progress.completed }}</div>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Subject
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sends
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
                        <div class="text-sm text-gray-900">{{ model.mail_performances[mail.id].total }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ model.mail_performances[mail.id].open_rate.formatted }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ model.mail_performances[mail.id].click_rate.formatted }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
