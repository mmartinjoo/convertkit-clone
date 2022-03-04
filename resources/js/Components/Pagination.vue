<script>
export default {
    props: {
        total: Number,
        current_page: Number,
    },
}
</script>
<template>
<div class="min-w-full divide-gray-200 mx-16 pt-4 grid grid-cols-3">
    <div class="mt-1">
        Total: {{ this.total }}
    </div>
    <div></div>
    <div class="text-right">
        <button @click="$emit('paginatedPrev')" :disabled="this.current_page === 1" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-l">
            Prev
        </button>
        <button @click="$emit('paginatedNext')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r">
            Next
        </button>
    </div>
</div>
</template>
