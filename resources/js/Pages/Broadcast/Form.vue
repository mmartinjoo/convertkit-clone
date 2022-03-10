<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import FiltersForm from "@/Components/Filter/Form";
import PerformanceLine from "@/Components/Mail/PerformanceLine";

export default {
    components: {
        FiltersForm,
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
    data() {
        return {
            form: {
                id: null,
                subject: null,
                content: null,
                filters: {
                    tag_ids: [],
                    form_ids: [],
                },
            }
        }
    },
    created() {
        if (!this.model.broadcast) {
            return;
        }

        this.form = {
            id: this.model.broadcast.id,
            subject: this.model.broadcast.subject,
            content: this.model.broadcast.content,
            filters: {
                form_ids: this.model.broadcast.filters.form_ids,
                tag_ids: this.model.broadcast.filters.tag_ids,
            },
        };
    },
    methods: {
        submit() {
            if (this.model.broadcast) {
                this.$inertia.put(`/broadcasts/${this.model.broadcast.id}`, this.form)
            } else {
                this.$inertia.post('/broadcasts', this.form)
            }
        },
        updateFilters(filters) {
            this.form.filters.tag_ids = filters.tagIds;
            this.form.filters.form_ids = filters.formIds;
        }
    },
}
</script>

<template>
    <Head title="New Broadcast" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span v-if="!model.broadcast">New Broadcast</span>
                <span v-else>{{ model.broadcast.subject }}</span>
                <span v-if="model.broadcast?.status === 'sent'" class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-400 rounded-full mb-2">
                    Sent
                </span>
            </h2>
            <PerformanceLine v-if="model.broadcast?.status === 'sent'" :performance="model.performance" class="inline-flex"></PerformanceLine>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <form class="w-full max-w-lg mx-auto" @submit.prevent="submit">
                <fieldset :disabled="model.broadcast?.status === 'sent'">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="subject">
                                Subject
                            </label>
                            <input v-model="form.subject" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="subject" type="text" placeholder="My Awesome Broadcast">
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="content">
                                Content
                            </label>
                            <textarea rows="10" v-model="form.content" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="content" type="text" placeholder="HTML content"></textarea>
                        </div>
                    </div>
                    <FiltersForm
                        :tags="model.tags"
                        :forms="model.forms"
                        :initial-selected-form-ids="form.filters.form_ids"
                        :initial-selected-tag-ids="form.filters.tag_ids"
                        @filtersChanged="updateFilters($event)"
                    />
                </fieldset>
                <button v-if="model.broadcast?.status !== 'sent'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Save
                </button>
                <Link href="/broadcasts" class="text-indigo-600 ml-4">
                    Cancel
                </Link>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
