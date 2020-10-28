<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Result
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex p-10">
                        <div
                            v-for="category in categories"
                            :key="category.index"
                            class="w-1/3 mx-2 border border-gray-400 p-10 rounded-md text-center"
                        >
                            <h3 class="font-bold text-lg uppercase">{{ category.name }}</h3>
                            <div class="font-bold text-3xl">{{ category.score }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    export default {
        components: {
            AppLayout
        },
        props : ['categories', 'q']
    }
</script>
