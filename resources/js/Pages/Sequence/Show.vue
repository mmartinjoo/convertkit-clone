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
    watch: {
        selectedMail: {
            deep: true,
            handler: _.debounce(async function (mail) {
                await axios.patch(`/sequences/${this.model.sequence.id}/mails/${mail.id}`, mail);
            }, 1000)
        }
    },
    methods: {
        remove() {
            this.$inertia.delete(`/sequences/${this.model.sequence.id}`);
        },
        publish() {
            this.$inertia.patch(`/sequences/${this.model.sequence.id}/publish`);
        },
        async addMail() {
            const { data } = await axios.post(`/sequences/${this.model.sequence.id}/mails`, {
                subject: 'My Awesome E-mail',
                content: 'My Awesome Content',
                schedule: {
                    delay: 1,
                    unit: 'day',
                    days: {monday: true, tuesday: true, wednesday: true, thursday: true, friday: true, saturday: true, sunday: true},
                }
            });

            this.model.sequence.mails.push(data);
            this.selectedMail = data;
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
            <form v-if="selectedMail" class="w-full max-w-lg mx-auto">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <button v-if="selectedMail.status === 'draft'" @click="this.selectedMail.status = 'published'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline" type="button">
                            Publish
                        </button>
                        <button v-if="selectedMail.status === 'published'" @click="this.selectedMail.status = 'draft'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline" type="button">
                            Unpublish
                        </button>
                    </div>
                </div>
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
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="delay">
                            Schedule
                        </label>
                        <div class="mb-3">
                            <input v-model="selectedMail.schedule.delay" class="appearance-none w-20 text-center bg-gray-200 text-gray-700 border rounded py-3 px-4 mr-3 leading-tight focus:outline-none focus:bg-white inline-flex" id="delay" type="number" min="1">
                            <select v-model="selectedMail.schedule.unit" name="unit" id="unit" class="rounded bg-gray-200 focus:outline-none focus:bg-white">
                                <option value="day">Day</option>
                                <option value="hour">Hour</option>
                            </select>
                            <p class="inline-flex ml-2">After the last e-mail</p>
                        </div>
                        <div>
                            <input v-model="selectedMail.schedule.days.monday" type="checkbox" class="mr-1"><span class="mr-3">Mon</span>
                            <input v-model="selectedMail.schedule.days.tuesday" type="checkbox" class="mr-1"><span class="mr-3">Tue</span>
                            <input v-model="selectedMail.schedule.days.wednesday" type="checkbox" class="mr-1"><span class="mr-3">Wed</span>
                            <input v-model="selectedMail.schedule.days.thursday" type="checkbox" class="mr-1"><span class="mr-3">Thur</span>
                            <input v-model="selectedMail.schedule.days.friday" type="checkbox" class="mr-1"><span class="mr-3">Fri</span>
                            <input v-model="selectedMail.schedule.days.saturday" type="checkbox" class="mr-1"><span class="mr-3">Sat</span>
                            <input v-model="selectedMail.schedule.days.sunday" type="checkbox" class="mr-1"><span class="mr-3">Sun</span>
                        </div>
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
