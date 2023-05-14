<template>
    <div class="w-96 mx-auto mt-8">
        <h2 class="text-center font-semibold text-lg">File</h2>
    </div>
    <div v-if="!tableContentTitles" class="w-96 mx-auto mt-6">
        <p class="font-medium text-sky-500 text-center">Processing{{ processing.dots }}</p>
    </div>
    <div>
        <div v-if="tableContentTitles" class="flex flex-col mx-auto w-1/2 mt-6">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center text-sm font-light">
                            <thead class="border-b bg-neutral-50 font-medium dark:border-neutral-500 dark:text-neutral-800">
                                <tr>
                                    <template v-for="columns in tableContentTitles">
                                        <template v-for="column in columns">
                                            <th scope="col" class=" px-6 py-4">{{ column }}</th>
                                        </template>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rows in tableContentItems" class="border-b dark:border-neutral-500">
                                    <template v-for="items in rows">
                                        <template v-for="item in items">
                                            <td class="whitespace-nowrap  px-6 py-4 font-medium">{{ item }}</td>
                                        </template>
                                    </template>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="tableContentTitles" class="w-1/2 mt-8 mx-auto">
        <a :href="urlDowloadFile"
            class="mx-auto border-2 border-green-950 bg-green-400 rounded-full px-6 py-3 font-semibold text-green-950">Download</a>
    </div>
</template>

<script>
import FileInput from 'vue3-simple-file-input'

export default {
    name: 'Show',

    props: [
        'file',
    ],

    data() {
        return {
            tableContentTitles: null,
            tableContentItems: [],
            processing: {
                dots: '',
            },
        }
    },

    mounted() {
        this.listenChannel()
        this.load()
    },

    beforeDestroy() {
        Echo.leave(`table.imported.${this.file.id}`)
    },

    methods: {
        listenChannel() {
            Echo.private(`table.imported.${this.file.id}`)
                .listen('.table.imported', r => {
                    if (!this.tableContentTitles) {
                        this.tableContentTitles = r.content
                    } else {
                        this.tableContentItems.push(r.content)
                    }
                })
        },

        load() {
            setTimeout(() => {
                if (this.processing.dots === '') {
                    this.processing.dots = '.'
                } else if (this.processing.dots === '.') {
                    this.processing.dots = '..'
                } else if (this.processing.dots === '..') {
                    this.processing.dots = '...'
                } else {
                    this.processing.dots = ''
                }

                this.load()
            }, 1000)
        },
    },

    computed: {
        urlDowloadFile() {
            return '/files/download/' + this.file.id
        },
    },

    components: {
        FileInput
    },
}
</script>

<style></style>
