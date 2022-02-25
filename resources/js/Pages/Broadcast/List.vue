<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import PerformanceLine from "@/Components/Mail/PerformanceLine";

export default {
    components: {
        PerformanceLine,
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
        open(broadcast) {
            this.$inertia.get(`broadcasts/${broadcast.id}`);
        },
        async remove(sequence) {
            // await axios.delete(`sequences/${sequence.id}`);
            // this.model.sequences = this.model.sequences.filter(s => s.id !== sequence.id);
        }
    }
}
</script>

<template>
    <Head title="All Subscriber" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Broadcasts
            </h2>
            <Link href="/broadcasts/create" as="button" type="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-2">
                New Broadcast
            </Link>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Subject
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
                <tr v-for="broadcast in model.broadcasts" :key="broadcast.id" class="hover:bg-gray-100">
                    <td class="px-6 py-4 hover:cursor-pointer" @click="open(broadcast)">
                        <div class="text-sm text-gray-900">{{ broadcast.subject }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ broadcast.status }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <PerformanceLine v-if="broadcast.status !== 'draft'" :performance="model.performances[broadcast.id]"></PerformanceLine>
                        <div v-else>-</div>
                    </td>
                    <td class="px-6 py-4">
                        <button @click="remove(broadcast)" class="bg-transparent hover:bg-red-500 text-red-700 hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" type="button">
                            Remove
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
