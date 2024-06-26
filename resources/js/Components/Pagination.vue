<script setup>
defineProps({
    data:Array
})
import {Link} from "@inertiajs/vue3";
</script>
<template>
    <div class="mt-8">
        <Link :class="{'bg-violet-500 text-white':link.active, 'bg-white': !link.active}"  v-html="link.label" class="p-2 border border-slate-300"  v-for="(link,index) in data" :key="index" :href="link.url ? link.url : ''"/>
    </div>
</template>
