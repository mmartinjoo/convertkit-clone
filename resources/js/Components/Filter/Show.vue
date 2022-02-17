<script>
export default {
    name: 'FiltersShow',
    props: {
        tags: {
            type: Array,
            required: true,
        },
        forms: {
            type: Array,
            required: true,
        },
    }
}
</script>
<template>
    <div>
        <div>
            <label class="uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Form filters:
            </label>
            <span v-for="form in forms" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-gray-400 rounded-full">
                {{ form.title }}
            </span>
        </div>
        <div>
            <label class="uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                Tag filters:
            </label>
            <span v-for="tag in tags" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-white bg-blue-400 rounded-full">
                {{ tag.title }}
            </span>
        </div>
    </div>
</template>
