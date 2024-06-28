<script setup>

import {onMounted, ref, watch} from "vue";
import { XMarkIcon } from '@heroicons/vue/24/solid'
import { v4 as uuidv4 } from 'uuid';

const props = defineProps({
    images:Array
})


const emit = defineEmits(['update:modelValue', 'update:deletedImages'])


const files = ref([]);
const imageUrls = ref([]);
const deletedImages = ref([]);

function onFileChange($event){
    files.value = [...files.value, ...$event.target.files];
    for(let file of $event.target.files){
        file.id = uuidv4();
        readFile(file).then(url=>{
            imageUrls.value.push({
                url:url,
                id:file.id
            });
        })
    }
    emit('update:modelValue', files.value)
}

function readFile(file){
return new Promise((resolve, reject)=>{
    const fileReader = new FileReader();
    fileReader.readAsDataURL(file);
    fileReader.onload = () =>{
        resolve(fileReader.result)
    }
    fileReader.onerror = reject;
})
}

onMounted(()=>{
    emit('update:modelValue', [])
    emit('update:deletedImages', deletedImages.value)

    imageUrls.value = [
        ...imageUrls.value,
        ...props.images.map(im =>({
            ...im,
            isProp:true
        }))
    ]
})


function removeImage(image){
    if(image.isProp){
        deletedImages.value.push(image.id)
        image.deleted = true;
        emit('update:deletedImages', deletedImages.value)
    }else{
        files.value = files.value.filter(f=>f.id !== image.id);
        emit('update:modelValue', files.value)
        imageUrls.value = imageUrls.value.filter(f=>f.id !== image.id);
    }

}

</script>

<template>
<div>
    <div v-for="image in imageUrls" class="relative w-[120px] h-[120px] rounded border border-dashed flex items-center justify-center hover:border-purple-500 overflow-hidden">
        <img :class="{'opacity-25':image.deleted}" :src="image.url" class="max-w-full">

        <span  class="absolute text-center w-full text-white bg-black bottom-0" v-if="image.deleted">To be deleted</span>

        <XMarkIcon class="absolute top-1 ring-1 cursor-pointer w-6 right-0" @click="removeImage(image)"></XMarkIcon>
    </div>
    <div class="relative w-[120px] h-[120px] rounded border border-dashed flex items-center justify-center hover:border-purple-500 overflow-hidden">
        <span>Upload</span>
        <input @change="onFileChange" type="file" class="opacity-0 l-0 t-0 b-0 r-0 absolute w-full h-full">
    </div>
</div>
</template>

<style scoped>

</style>
