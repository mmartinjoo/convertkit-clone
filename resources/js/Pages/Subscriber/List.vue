<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from "@/Components/Pagination";

export default {
    components: {
        Pagination,
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
        async importSubscribers() {
            await axios.post('subscribers/import');
            alert('Subscribers are being imported... Please refresh the page after a few seconds');
        },
        edit(subscriber) {
            this.$inertia.get(`subscribers/${subscriber.id}/edit`);
        },
        async remove(subscriber) {
            this.$inertia.delete(`subscribers/${subscriber.id}`);
        },
        nextPage() {
            if (!this.model.subscribers.next_page_url) {
                return;
            }

            this.$inertia.get(this.model.subscribers.next_page_url);
        },
        prevPage() {
            if (!this.model.subscribers.prev_page_url) {
                return;
            }

            this.$inertia.get(this.model.subscribers.prev_page_url);
        },
    },
}
</script>

<template>
    <Head title="All Subscriber" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subscribers
            </h2>
            <Link href="/subscribers/create" as="button" type="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-2">
                Add Subscriber
            </Link>
            <button class="bg-transparent hover:bg-gray-500 text-gray-700 font-semibold hover:text-white py-2 px-4 border border-gray-500 hover:border-transparent rounded ml-2" @click="importSubscribers()">
                Import subscribers
            </button>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Full Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        E-mail
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Form
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Subscribed At
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tags
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                <tr v-for="subscriber in model.subscribers.data" :key="subscriber.email" class="hover:bg-gray-100">
                    <td class="px-6 py-4 hover:cursor-pointer" @click="edit(subscriber)">
                        <div class="text-sm text-gray-900">{{ subscriber.full_name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.form?.title }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.subscribed_at }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            <span v-for="tag in subscriber.tags" :key="tag.id" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-gray-400 rounded-full mb-2">
                                {{ tag.title}}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <button @click="remove(subscriber)" class="bg-transparent hover:bg-red-500 text-red-700 hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded" type="button">
                            Remove
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <Pagination
                :total="model.total"
                :current_page="model.subscribers.current_page"
                @paginated-prev="prevPage()"
                @paginated-next="nextPage()"
            ></Pagination>
        </div>
    </BreezeAuthenticatedLayout>
</template>
