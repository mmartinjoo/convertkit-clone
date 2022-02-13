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
}
</script>

<template>
    <Head title="All Subscriber" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Subscribers
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <Link href="/subscribers/create" as="button" type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-16 mb-5">
                Add Subscriber
            </Link>
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        E-mail
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Form
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                <tr v-for="subscriber in model.subscribers" :key="subscriber.email" class="hover:bg-gray-100">
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.form.title }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
