<script>
export default {
    name: 'SequenceMailList',
    props: {
        mails: {
            type: Array,
            required: true,
        },
    },
}
</script>
<template>
    <div class="sm:px-6 lg:px-8">
        <div v-for="mail in mails" :key="mail.id" @click="$emit('selected', mail)" class="p-6 w-52 max-w-sm mx-auto bg-white shadow-md hover:cursor-pointer hover:bg-gray-50 mb-4">
            <p class="text-gray-500">{{ mail.subject }}</p>
        </div>
    </div>
</template>
