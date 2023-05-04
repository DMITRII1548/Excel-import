<template>
    <div class="w-96 mx-auto mt-8">
        <h2 class="text-center font-semibold text-lg">Upload excel file</h2>
        <form class="mt-6 flex flex-col items-center gap-2" @submit.prevent="uploadFile">
            <div>
                <file-input v-model="file" placeholder-input-text="Excel file" button-background-color="rgb(74 222 128)" button-text-color="rgb(5 46 22)" is_excel></file-input>
            </div>
            <div>
                <button :disabled="isDisabled" type="submit" class="border-2 border-green-950 bg-green-400 rounded-full px-6 py-3 font-semibold text-green-950">Upload</button>
            </div>
        </form>
    </div>
    <div>
    <div v-if="tableContentTitles" class="flex flex-col mx-auto w-1/2">
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
          <div class="overflow-hidden">
            <table class="min-w-full text-center text-sm font-light">
              <thead
                class="border-b bg-neutral-50 font-medium dark:border-neutral-500 dark:text-neutral-800">
                <tr>
                  <template v-for="column in tableContentTitles">
                    <th scope="col" class=" px-6 py-4">{{ column }}</th>
                  </template>
                </tr>
              </thead>
              <tbody>
                <tr v-for="items in tableContentItems" class="border-b dark:border-neutral-500">
                  <template v-for="item in items">
                    <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ item }}</td>
                  </template>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    </div>

</template>

<script>
import FileInput from 'vue3-simple-file-input'

export default {
    name: 'Create',

    data() {
        return {
            file: null,
            tableContentTitles: null,
            tableContentItems: null
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
                    axios.get(`/files/${response.data.id}`)
                        .then(res => {
                            window.Echo.private(`table.imported.${response.data.id}`)
                                .listen('.table.imported', r => {
                                    console.log(r)
                                    // this.tableContentTitles = r.content.shift()
                                    // this.tableContentItems = r.content
                                })
                        })
                })
        },
    },

    computed: {
        isDisabled() {
            return !this.file
        },
    },

    components: {
        FileInput
    },
}
</script>

<style>

</style>
700
