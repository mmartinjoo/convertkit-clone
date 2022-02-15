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
    data() {
        return {
            form: {
                subject: null,
                content: null,
                filters: {
                    tag_ids: [],
                    form_ids: [],
                },
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post('/broadcasts', this.form)
        },
    },
}
</script>

<template>
    <Head title="New Subscriber" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Broadcast
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <form class="w-full max-w-lg mx-auto" @submit.prevent="submit">
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
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    Filters
                </label>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="form_ids">
                            Forms
                        </label>
                        <div class="relative">
                            <select v-model="form.filters.form_ids" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="form_ids" multiple>
                                <option :value="form.id" v-for="form in model.forms" :key="form.id">{{ form.title }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="tag_ids">
                            Tags
                        </label>
                        <div class="relative">
                            <select v-model="form.filters.tag_ids" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="tag_ids" multiple>
                                <option :value="tag.id" v-for="tag in model.tags" :key="tag.id">{{ tag.title }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Save
                </button>
                <Link href="/broadcasts" class="text-indigo-600 ml-4">
                    Cancel
                </Link>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
