<template>
    <div class="mx-auto w-1/2 mt-8">
        <h1 class="text-lg text-center font-medium">Edit field</h1>
        <div class="mt-4">
            <form @submit.prevent="updateField" class="flex flex-col gap-1 w-52 mx-auto">
                <div>
                    <input v-model="address" type="text" placeholder="Address" class="w-24">
                    <p v-if="errors.address" class="text-sm text-red-500">{{ errors.address }}</p>
                </div>
                <div>
                    <input v-model="field" type="text" placeholder="New Value in field" class="w-52">
                    <p v-if="errors.field" class="text-sm text-red-500">{{ errors.fiel }}</p>
                </div>
                <button :disabled="isDisabled" type="submit" class="border border-sky-950 rounded-full px-3 py-1 bg-sky-400 text-sky-950 hover:opacity-95 click:opacity-50 w-24">Update</button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    name: 'EditField',

    props: [
        'file',
        'errors',
    ],

    data() {
        return {
            address: '',
            field: '',
        }
    },

    methods: {
        updateField() {
            this.$inertia.put(`/files/update/${this.file.id}/field`, {
                address: this.address,
                field: this.field,
            })
        }
    },

    computed: {
        isDisabled() {
            return this.address === '' || this.field === ''
        }
    }
}
</script>

<style scoped>
</style>
