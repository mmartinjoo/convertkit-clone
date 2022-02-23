<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import AutomationStepActionForm from "@/Pages/Automation/Step/Action/Form";
import AutomationStepEventForm from "@/Pages/Automation/Step/Event/Form";

export default {
    components: {
        AutomationStepActionForm,
        AutomationStepEventForm,
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
                id: null,
                name: null,
                steps: {
                    event: {},
                    actions: [{}],
                },
            },
        };
    },
    created() {
        if (!this.model.automation) {
            return;
        }

        this.form = {
            id: this.model.automation.id,
            name: this.model.automation.name,
            steps: {
                event: this.model.automation.event,
                actions: this.model.automation.actions,
            }
        };
    },
    methods: {
        submit() {
            if (this.model.automation) {
                this.$inertia.put(`/automations/${this.model.automation.id}`, this.form)
            } else {
                this.$inertia.post('/automations', this.form)
            }
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
            <form class="w-full mx-auto" @submit.prevent="submit">
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
                        <AutomationStepEventForm
                            :initEvent="form.steps.event"
                            :events="model.events"
                            :forms="model.forms"
                            @changed="form.steps.event = $event"
                        ></AutomationStepEventForm>

                        <AutomationStepActionForm
                            v-for="(action, idx) in form.steps.actions"
                            :initAction="action"
                            :actions="model.actions"
                            :tags="model.tags"
                            :sequences="model.sequences"
                            :label="idx === 0 ? 'Then' : 'And'"
                            @changed="form.steps.actions[idx] = $event"
                            @removed="form.steps.actions = form.steps.actions.filter(a => a !== action)"
                        ></AutomationStepActionForm>

                        <button @click.prevent="this.form.steps.actions.push({})" class="bg-transparent hover:bg-blue-500 text-blue-700 hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded mt-4" type="button">
                            Add Action
                        </button>
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
