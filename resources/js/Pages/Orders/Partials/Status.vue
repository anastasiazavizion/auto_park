<script setup>
import {computed} from "vue";
const props = defineProps({
    status:Object
})
const background = computed(()=>{return 'bg-'+props.status.color+'-500'})
</script>

<template>
<span class="text-white py-1 px-2 rounded" :class="background">
    {{props.status.name}}
</span>
</template>
