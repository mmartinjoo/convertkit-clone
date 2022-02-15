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
            selectedMail: null,
        };
    },
    created() {
        this.selectedMail = this.model.sequence.mails[0];
    },
    methods: {
        remove() {
            this.$inertia.delete(`/sequences/${this.model.sequence.id}`);
        },
        publish() {
            this.$inertia.patch(`/sequences/${this.model.sequence.id}/publish`);
        },
        addMail() {
            this.$inertia.post(`/sequences/${this.model.sequence.id}/mails`, {
                subject: 'My Awesome E-mail',
                content: 'My Awesome Content',
                schedule: {
                    delay: 1,
                    unit: 'day',
                    days: [0,1,2,3,4,5,6],
                }
            });
        },
        submit() {

        },
        getPerformance() {
            return `
                ${this.model.performance.total_sent_mails} Recipients •
                ${this.model.performance.average_open_rate.formatted} Open rate •
                ${this.model.performance.average_click_rate.formatted} Click rate
            `;
        },
    },
}
</script>

<template>
    <Head title="Sequence" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ model.sequence.title }}

                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 mb-4 text-xs font-bold leading-none text-white bg-blue-400 rounded-full">
                    {{ model.sequence.status }}
                </span>
            </h2>
            <div v-if="model.sequence.status === 'sent'" class="text-sm text-gray-900">
                {{ getPerformance() }}
            </div>
            <button @click="remove()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-3 mt-6" type="button">
                Delete
            </button>
            <button v-if="model.sequence.status === 'draft'" @click="publish()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline" type="button">
                Publish
            </button>
            <button @click="addMail()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                Add E-Mail
            </button>
        </template>
        <div class="py-12 max-w-7xl mx-auto grid grid-cols-2">
            <form v-if="selectedMail" class="w-full max-w-lg mx-auto" @submit.prevent="submit">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="subject">
                            Subject
                        </label>
                        <input v-model="selectedMail.subject" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="subject" type="text">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="content">
                            Content
                        </label>
                        <textarea rows="10" v-model="selectedMail.content" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="content" type="text"></textarea>
                    </div>
                </div>
            </form>

            <div class="sm:px-6 lg:px-8">
                <div v-for="mail in model.sequence.mails" :key="mail.id" @click="selectedMail = mail" class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md hover:cursor-pointer hover:bg-gray-50 mb-4">
                    <p class="text-gray-500">{{ mail.subject }}</p>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
