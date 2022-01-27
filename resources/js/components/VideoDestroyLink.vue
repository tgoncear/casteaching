<template>
    <a class="text-indigo-600 hover:text-indigo-900 cursor-pointer"
    @click="remove()">Delete</a>
</template>

<script>
import eventBus from "../eventBus";
import casteaching from "@acacha/casteaching";

export default {
    name: "VideoDestroyLink",
    props:{
        video:{
            type:Object,
            required:true
        }
    },
    methods:{
        async remove(){
            try{
                await casteaching().destroy(this.video.id)
                this.$emit('removed');
                eventBus.$emit('status','Video removed successfully');
            }catch(error){
                console.log(error);
            }
        }
    }

}

</script>

<style scoped>

</style>
