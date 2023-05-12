<template>
    <div class="mx-auto w-1/2 mt-8">
        <h1 class="text-lg text-center font-medium">Edit field</h1>
        <div class="mt-4">
            <form class="flex flex-col gap-1 w-52 mx-auto">
                <input type="text" placeholder="Address" class="w-24">
                <input type="text" placeholder="New Value in field" class="w-52">
                <div class="w-full">
                    <button class="border border-sky-950 rounded-full px-3 py-1 bg-sky-400 text-sky-950 hover:opacity-95 click:opacity-50">Update</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: 'EditField',

    props: [
        'file',
    ],
}
</script>

<style scoped>
</style>
