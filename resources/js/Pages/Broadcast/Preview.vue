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
    <Head title="Broadcast Preview" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ model.subject }}
            </h2>
        </template>

        <div v-html="model.content" class="py-12 max-w-7xl mx-auto"></div>
    </BreezeAuthenticatedLayout>
</template>
