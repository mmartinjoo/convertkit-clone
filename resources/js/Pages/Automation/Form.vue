<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import FiltersForm from "@/Components/Filter/Form";
import AutomationStepForm from "@/Pages/Automation/Step/Form";

export default {
    components: {
        AutomationStepForm,
        FiltersForm,
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
    data() {
        return {
            form: {
                name: null,
                steps: null,
            },
        };
    },
    methods: {
        submit() {
            this.$inertia.post('/automations', this.form)
        },
    },
}
</script>

<template>
    <Head title="New Automation" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Automation
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <form class="w-full max-w-lg mx-auto" @submit.prevent="submit">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                            Name
                        </label>
                        <input v-model="form.name" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" type="text" placeholder="My Awesome Automation">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <h2>Event</h2>
                        <AutomationStepForm type="event" :events="model.events" :actions="model.actions" :tags="model.tags" :forms="model.forms" :sequences="model.sequences"></AutomationStepForm>
                        <AutomationStepForm type="action" :events="model.events" :actions="model.actions" :tags="model.tags" :forms="model.forms" :sequences="model.sequences"></AutomationStepForm>
                    </div>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Save
                </button>
                <Link href="/automations" class="text-indigo-600 ml-4">
                    Cancel
                </Link>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
