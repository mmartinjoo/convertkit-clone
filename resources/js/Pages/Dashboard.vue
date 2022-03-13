<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
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
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 max-w-7xl mx-auto">
            <h2 class="pl-20 mb-2">New Subscribers</h2>
            <div class="sm:px-6 lg:px-8 grid grid-cols-4 gap-2">
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Today</p>
                    <div class="text-xl font-medium text-black">{{ model.new_subscribers_count.today }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">This Week</p>
                    <div class="text-xl font-medium text-black">{{ model.new_subscribers_count.this_week }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">This Month</p>
                    <div class="text-xl font-medium text-black">{{ model.new_subscribers_count.this_month }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Total</p>
                    <div class="text-xl font-medium text-black">{{ model.new_subscribers_count.total }}</div>
                </div>
            </div>

            <h2 class="pl-20 mb-2 mt-4">All-Time Performance</h2>
            <div class="sm:px-6 lg:px-8 grid grid-cols-4 gap-2">
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Average Open Rate</p>
                    <div class="text-xl font-medium text-black">{{ model.performance.open_rate.formatted }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Average Click Rate</p>
                    <div class="text-xl font-medium text-black">{{ model.performance.click_rate.formatted }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Total e-mails sent</p>
                    <div class="text-xl font-medium text-black">{{ model.performance.total }}</div>
                </div>
            </div>

            <h2 class="pl-20 mb-2 mt-4">Most Recent Subscribers</h2>
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
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                <tr v-for="subscriber in model.recent_subscribers" :key="subscriber.email" class="hover:bg-gray-100">
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.full_name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ subscriber.form.title }}</div>
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
                </tr>
                </tbody>
            </table>

            <h2 class="pl-20 mb-2 mt-4">Daily Subscribers</h2>
            <table class="min-w-full divide-y divide-gray-200 mx-16">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Count
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 overflow-y-scroll">
                <tr v-for="daily in model.daily_subscribers" :key="daily.day" class="hover:bg-gray-100">
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ daily.day }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ daily.count }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </BreezeAuthenticatedLayout>
</template>
