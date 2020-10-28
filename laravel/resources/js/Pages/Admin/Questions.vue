<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Questions
            </h2>
        </template>
        <dialog-modal :show="show" :closeable="false" @close="close">
            <template #title>
                Add new question
            </template>
            <template #content>
                <form action="" @submit.prevent>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="question">
                            Question
                        </label>
                        <textarea v-model="addnew.question" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="question"></textarea>
                    </div>
                    <div class="mb-4 flex">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="question">
                                Type
                            </label>
                            <div class="inline-block relative w-64">
                                <select v-model="addnew.type" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="checkbox">Checkbox</option>
                                    <option value="radio">Radio</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="ml-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="question">
                                Category
                            </label>
                            <div class="inline-block relative w-64">
                                <select v-model="addnew.category" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="1">History</option>
                                    <option value="2">Culture</option>
                                    <option value="3">Sport</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="ml-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="question">
                                Add to Quiz?
                            </label>
                            <div class="inline-block relative">
                                <select v-model="addnew.question_set" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="false">No</option>
                                    <option value="true">Yes</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 flex">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="question">
                                Depend on
                            </label>
                            <div class="inline-block relative">
                                <select v-model="addnew.depend_on" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option v-for="item in question_set" :key="item.id" :value="item.question_id">{{ item.question_id }}</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="ml-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="question">
                                Condition
                            </label>
                            <div class="inline-block relative">
                                <select v-model="addnew.condition" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="correct">Correct</option>
                                    <option value="incorrect">Incorrect</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="choices">
                            Choices
                        </label>
                        <div class="mb-3 pb-3" v-for="item in addnew.choices" :key="item.index">
                            <input v-model="item.text" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
                            <label class="md:w-2/3 block text-gray-500 font-bold mt-3">
                                <input v-model="item.is_correct" class="mr-2 leading-tight" type="checkbox">
                                <span class="text-sm">
                                    Correct Answer?
                                </span>
                            </label>
                        </div>
                    </div>
                </form>
            </template>
            <template #footer>
                <button @click="submit" class="bg-black text-white hover:bg-gray-300 hover:text-gray-900 px-3 py-1 rounded text-xs uppercase">submit</button>
                <button @click="close" class="bg-black text-white hover:bg-gray-300 hover:text-gray-900 px-3 py-1 rounded text-xs uppercase">cancel</button>
            </template>
        </dialog-modal>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-3 w-full relative h-10">
                    <button
                        class="absolute right-0 bg-black text-white hover:bg-gray-300 hover:text-gray-900 px-3 py-1 rounded text-xs uppercase"
                        @click="addNew"
                    >
                        Add New Question
                    </button>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg clear-both p-10">
                    <table class="table-auto ">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Question</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="w-1/5 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="question in questions" :key="question.id">
                                <td class="border px-4 py-2">{{ question.id }}</td>
                                <td class="border px-4 py-2">{{ question.text }}</td>
                                <td class="border px-4 py-2">{{ question.type }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex justify-center">
                                        <button class="bg-black text-white hover:bg-gray-300 hover:text-gray-900 px-3 py-1 rounded text-xs uppercase">Edit</button>
                                        <button class="bg-black text-white hover:bg-gray-300 hover:text-gray-900 px-3 py-1 rounded text-xs uppercase ml-2" @click="[deleteModal=true, deleteId=question.id]">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                </div>
            </div>
        </div>
        <confirmation-modal :show="deleteModal" :closeable="false" @close="closeDeleteModal">
            <template #title>Warning</template>
            <template #content>Delete this Question?</template>
            <template #footer>
                <div>
                    <button @click="deleteQuestion(deleteId)" class="bg-black text-white hover:bg-gray-300 hover:text-gray-900 px-3 py-1 rounded text-xs uppercase">delete</button>
                    <button @click="closeDeleteModal" class="bg-black text-white hover:bg-gray-300 hover:text-gray-900 px-3 py-1 rounded text-xs uppercase">cancel</button>
                </div>
            </template>
        </confirmation-modal>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DialogModal from '@/Jetstream/DialogModal'
    import ConfirmationModal from '@/Jetstream/ConfirmationModal'
    export default {
        components: {
            AppLayout, DialogModal, ConfirmationModal
        },
        props: ['questions', 'question_set'],
        data() {
            return {
                show:false,
                deleteModal: false,
                deleteId: null,
                addnew : {
                    question: '',
                    type: 'checkbox',
                    category: 1,
                    question_set: false,
                    depend_on: null,
                    condition: null,
                    choices: [
                        {
                            'text':'',
                            'is_correct':false
                        },
                        {
                            'text':'',
                            'is_correct':false
                        },
                        {
                            'text':'',
                            'is_correct':false
                        },
                        {
                            'text':'',
                            'is_correct':false
                        },
                    ]
                }
            }
        },
        methods: {
            close: function()
            {
                this.show = !this.show;
            },
            closeDeleteModal: function()
            {
                this.deleteModal = !this.deleteModal;
            },
            addNew: function()
            {
                this.show = true
            },
            submit: function()
            {
                this.$inertia.post('/admin/questions', this.addnew)
                this.show = !this.show;
                this.addnew = {
                    question: '',
                    type: 'checkbox',
                    category: 1,
                    question_set: false,
                    depend_on: null,
                    condition: null,
                    choices: [
                        {
                            'text':'',
                            'is_correct':false
                        },
                        {
                            'text':'',
                            'is_correct':false
                        },
                        {
                            'text':'',
                            'is_correct':false
                        },
                        {
                            'text':'',
                            'is_correct':false
                        },
                    ]
                }
            },
            deleteQuestion: function(id)
            {
                this.$inertia.delete(`/admin/questions/${id}`)
            }
        }
    }
</script>
