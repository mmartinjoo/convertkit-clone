<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import SequenceMailList from "@/Pages/Sequence/SequenceMail/List";
import SequenceMailForm from "@/Pages/Sequence/SequenceMail/Form";

export default {
    components: {
        SequenceMailForm,
        SequenceMailList,
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
                if (!mail) {
                    return;
                }

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
                    days: { monday: true, tuesday: true, wednesday: true, thursday: true, friday: true, saturday: true, sunday: true },
                }
            });

            this.model.sequence.mails.push(data);
            this.selectedMail = data;
        },
        async removeMail() {
            await axios.delete(`/sequences/${this.model.sequence.id}/mails/${this.selectedMail.id}`);
            this.model.sequence.mails = this.model.sequence.mails.filter(m => m.id !== this.selectedMail.id);

            if (this.model.sequence.mails.length) {
                this.selectedMail = this.model.sequence.mails[0];
            } else {
                this.selectedMail = null;
            }
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
                Remove Sequence
            </button>
            <button v-if="model.sequence.status === 'draft'" @click="publish()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline" type="button">
                Publish
            </button>
        </template>
        <div class="py-12 max-w-7xl mx-auto grid grid-cols-2">
            <SequenceMailForm
                v-if="selectedMail"
                :mail="selectedMail"
                :tags="model.tags"
                :forms="model.forms"
                @changed="selectedMail = $event"
                @removed="removeMail()"
            />

            <SequenceMailList :mails="model.sequence.mails" @selected="selectedMail = $event" @mailAdded="addMail()" />
        </div>
    </BreezeAuthenticatedLayout>
</template>
