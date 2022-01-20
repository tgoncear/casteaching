<template>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-screen">
        <div class="py-2 align-middle sm:px-6 lg:px-8 w-screen">
            <div class="p-4">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Vídeos</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Informació bàsica del vídeo
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form data-qa="form_video_create" @submit.prevent="store" method="post">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">
                                            Title
                                        </label>
                                        <div class="mt-1">
                                            <input v-model="video.title" required id="title" name="title" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2" placeholder="Titol del vídeo"></input>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Titol curt del nostre vídeo
                                        </p>
                                    </div>

                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">                                                    Description
                                        </label>
                                        <div class="mt-1">
                                            <textarea v-model="video.description" required id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Description"></textarea>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Brief description for your profile. URLs are hyperlinked.
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-3 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="url" class="block text-sm font-medium text-gray-700">
                                                URL
                                            </label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                      <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                        http://
                                                      </span>
                                                <input v-model="video.url" required type="url" name="url" id="url" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="youtube.com/">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button @click="store()" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Crear
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "VideoForm",
    data(){
        return{
            video:{}
        }
    },
    methods:{
        async store(){
            await window.tgoncearcasteaching.video.create({
                title: this.video.title,
                description: this.video.description,
                url: this.video.url
            });
            console.log(this.video);
        }
    }
}
</script>

<style scoped>

</style>
