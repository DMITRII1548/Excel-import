<template>
    <div class="w-96 mx-auto mt-8">
        <h2 class="text-center font-semibold text-lg">Upload excel file</h2>
        <form class="mt-6 flex flex-col items-center gap-2" @submit.prevent="uploadFile">
            <div>
                <file-input v-model="file" placeholder-input-text="Excel file" button-background-color="rgb(74 222 128)" button-text-color="rgb(5 46 22)" is_excel></file-input>
            </div>
            <div>
                <button type="submit" class="border-2 border-green-950 bg-green-400 rounded-full px-6 py-3 font-semibold text-green-950">Upload</button>
            </div>
        </form>
    </div>
</template>

<script>
import FileInput from 'vue3-simple-file-input'

export default {
    name: 'Create',

    data() {
        return {
            file: null,
        }
    },

    methods: {
        uploadFile() {
            axios.post('/files', {
                file: this.file.file,
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    console.log(response)
                })
        }
    },

    components: {
        FileInput
    },
}
</script>

<style>

</style>
700
