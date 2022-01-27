<template>
    <a @click="edit" target="_blank" class="text-indigo-600 hover:text-indigo-900 cursor-pointer">Edit</a>
</template>

<script>
import eventBus from "../eventBus";

export default {
    name: "VideoEditLink",
    props : {
        video : {
            type:Object,
            required : true
        }
    },
    methods:{
        edit(){
            eventBus.$emit('edit',this.video);
        }
    }

}
</script>

<style scoped>

</style>
