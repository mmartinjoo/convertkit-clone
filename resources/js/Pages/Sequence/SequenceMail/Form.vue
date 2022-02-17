<script>
import FiltersForm from "@/Components/Filter/Form";

export default {
    name: 'SequenceMailForm',
    components: {
        FiltersForm
    },
    props: {
        mail: {
            type: Object,
            required: true,
        },
        tags: {
            type: Array,
            required: true,
        },
        forms: {
            type: Array,
            required: true,
        }
    },
    watch: {
        mail: {
            deep: true,
            handler: function () {
                this.$emit('changed', this.mail);
            }
        }
    },
    methods: {
        updateFilters(filters) {
            this.mail.filters.form_ids = filters.formIds;
            this.mail.filters.tag_ids = filters.tagIds;
        },
    }
}
</script>
<template>
    <form v-if="mail" class="w-full max-w-lg mx-auto">
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <button v-if="mail.status === 'draft'" @click="this.mail.status = 'published'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline" type="button">
                    Publish
                </button>
                <button v-if="mail.status === 'published'" @click="this.mail.status = 'draft'" class="bg-gray-400 hover:bg-gray-600 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline" type="button">
                    Unpublish
                </button>
                <button @click="$emit('removed', mail)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mr-3 rounded focus:outline-none focus:shadow-outline" type="button">
                    Remove Mail
                </button>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="subject">
                    Subject
                </label>
                <input v-model="mail.subject" class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="subject" type="text">
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="content">
                    Content
                </label>
                <textarea rows="10" v-model="mail.content" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="content" type="text"></textarea>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="delay">
                    Schedule
                </label>
                <div class="mb-3">
                    <input v-model="mail.schedule.delay" class="appearance-none w-20 text-center bg-gray-200 text-gray-700 border rounded py-3 px-4 mr-3 leading-tight focus:outline-none focus:bg-white inline-flex" id="delay" type="number" min="1">
                    <select v-model="mail.schedule.unit" name="unit" id="unit" class="rounded bg-gray-200 focus:outline-none focus:bg-white">
                        <option value="day">Day</option>
                        <option value="hour">Hour</option>
                    </select>
                    <p class="inline-flex ml-2">After the last e-mail</p>
                </div>
                <div>
                    <input v-model="mail.schedule.days.monday" type="checkbox" class="mr-1"><span class="mr-3">Mon</span>
                    <input v-model="mail.schedule.days.tuesday" type="checkbox" class="mr-1"><span class="mr-3">Tue</span>
                    <input v-model="mail.schedule.days.wednesday" type="checkbox" class="mr-1"><span class="mr-3">Wed</span>
                    <input v-model="mail.schedule.days.thursday" type="checkbox" class="mr-1"><span class="mr-3">Thur</span>
                    <input v-model="mail.schedule.days.friday" type="checkbox" class="mr-1"><span class="mr-3">Fri</span>
                    <input v-model="mail.schedule.days.saturday" type="checkbox" class="mr-1"><span class="mr-3">Sat</span>
                    <input v-model="mail.schedule.days.sunday" type="checkbox" class="mr-1"><span class="mr-3">Sun</span>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full px-3">
                <FiltersForm
                    :tags="tags"
                    :forms="forms"
                    :initial-selected-form-ids="mail.filters.form_ids"
                    :initial-selected-tag-ids="mail.filters.tag_ids"
                    @filtersChanged="updateFilters($event)"
                />
            </div>
        </div>
    </form>
</template>
