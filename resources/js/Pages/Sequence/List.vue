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
    methods: {
        getPerformance(sequence) {
            if (sequence.status === 'draft') {
                return '-';
            }

            const performance = this.model.performances[sequence.id];

            return `
                ${performance.total} Recipients •
                ${performance.open_rate.formatted} Open rate •
                ${performance.click_rate.formatted} Click rate
            `;
        },
        open(sequence) {
            this.$inertia.get(`sequences/${sequence.id}/edit`);
        },
        async remove(sequence) {
            this.$inertia.delete(`sequences/${sequence.id}`);
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
            <Link href="/sequences/create" as="button" type="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-2">
                New Sequence
            </Link>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                <tr v-for="sequence in model.sequences" :key="sequence.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 hover:cursor-pointer" @click="open(sequence)">
                        <div class="text-sm text-gray-900">{{ sequence.title }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ sequence.mails.length }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ sequence.status }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <PerformanceLine v-if="sequence.status === 'published'" :performance="model.performances[sequence.id]" label="Subscribers"></PerformanceLine>
                        <div v-else>-</div>
                    </td>
                    <td class="px-6 py-4">
                        <button @click="remove(sequence)" class="bg-transparent hover:bg-red-500 text-red-700 hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" type="button">
                            Remove
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
