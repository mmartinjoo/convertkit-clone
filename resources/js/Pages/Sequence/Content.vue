<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import SequenceMailList from "@/Pages/Sequence/SequenceMail/List";
import SequenceMailForm from "@/Pages/Sequence/SequenceMail/Form";
import PerformanceLine from "@/Components/Mail/PerformanceLine";

export default {
    components: {
        SequenceMailForm,
        SequenceMailList,
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

                if (mail.id) {
                    await axios.patch(`/sequences/${this.model.sequence.id}/mails/${mail.id}`, mail);
                } else {
                    const { data } = await axios.post(`/sequences/${this.model.sequence.id}/mails`, mail);
                    this.selectedMail.id = data.id;
                    this.selectedMail.schedule = data.schedule;
                }
            }, 1000)
        }
    },
    methods: {
        async publish() {
            const { data } = await axios.patch(`/sequences/${this.model.sequence.id}/publish`);
            this.model.sequence.status = data.status;
        },
        async addMail() {
            this.model.sequence.mails.push(this.model.dummy_mail);
            this.selectedMail = this.model.dummy_mail;
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
                ${this.model.performance.total} Recipients •
                ${this.model.performance.open_rate.formatted} Open rate •
                ${this.model.performance.click_rate.formatted} Click rate
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
            <div>
                <PerformanceLine v-if="model.sequence.status === 'published'" :performance="model.performance" label="Subscribers" class="inline-flex"></PerformanceLine>
                <Link v-if="model.sequence.status === 'published'" :href="`/sequences/${model.sequence.id}/reports`" class="ml-4 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                    See Reports
                </Link>
            </div>
            <button v-if="model.sequence.status === 'draft'" @click="publish()" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="button">
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
