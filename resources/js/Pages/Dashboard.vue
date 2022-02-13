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

            <h2 class="pl-20 mb-2 mt-4">All Time Performance</h2>
            <div class="sm:px-6 lg:px-8 grid grid-cols-4 gap-2">
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Average Open Rate</p>
                    <div class="text-xl font-medium text-black">{{ model.tracking.average_open_rate.formatted }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Average Click Rate</p>
                    <div class="text-xl font-medium text-black">{{ model.tracking.average_click_rate.formatted }}</div>
                </div>
                <div class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md">
                    <p class="text-gray-500">Total e-mails sent</p>
                    <div class="text-xl font-medium text-black">{{ model.tracking.total_sent_mails }}</div>
                </div>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>
