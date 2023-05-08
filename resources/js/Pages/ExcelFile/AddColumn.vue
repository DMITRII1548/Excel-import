<template>
<div class="w-96 mx-auto mt-8 mb-8">
    <h1 class="text-lg text-center text-green-950 font-medium">Add column</h1>
    <form class="flex flex-col items-center">
        <div>
            <input v-model="column.title" type="text" placeholder="Title">
        </div>
        <div class="mt-3">
            <input v-model="column.items[0]" type="text" placeholder="Item">
        </div>
        <template v-for="n in column.countItems">
            <div class="mt-1">
                <input v-model="column.items[n]" type="text" placeholder="Item">
            </div>
        </template>
        <div class="flex gap-10 mt-4">
            <button class="border border-sky-950 rounded-full px-3 py-1 bg-sky-400 text-sky-950 hover:opacity-95 click:opacity-50">Send</button>
            <div @click="addItem" class="border border-sky-950 rounded-full px-3 py-1 bg-sky-400 text-sky-950 hover:opacity-95 click:opacity-50">Add item</div>
        </div>
    </form>
</div>
</template>

<script>
export default {
    name: 'AddColumn',

    data() {
        return {
            column: {
                title: '',
                items: [],
                countItems: 0,
            },
        }
    },

    methods: {
        addItem() {
            this.column.countItems++
        },

        addColumn() {
            console.log(111)
        },
    },
}
</script>

<style>

</style>
